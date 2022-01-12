<?php

namespace Components\Enterprise\Enterprise\Application\Commands;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use Carbon\Carbon;
use Components\Connector\Pappers\Application\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;

class GetFrCompaniesFromPappersApi extends Command
{
    protected $signature = 'enterprise:get-fr-companies-from-pappers-api';

    protected $description = '';

    public function handle()
    {
        $country_fr_id = DB::table('countries')->where('code', 'fr')->first()->id;
        $pappers = new Client;
        $now = Carbon::now();

        foreach (Enterprise::ofType('vendor')->cursor() as $enterprise) {
            //$enterprise = Enterprise::where('name', 'ADDWORKING')->first();
            try {
                // if enterprise enterprise identification number is null, continue process
                if (is_null($enterprise->identification_number)) {
                    Log::warning("Pappers: enterprise identification number is null");
                    continue;
                }

                Log::info("Pappers: company {$enterprise->identification_number} search in progress");

                // Siren in the Addworking database
                $params = ['siren' => $enterprise->siren];

                // Response from Pappers API
                $response = $pappers->getEnterprise($params);
                $data = $response->body;

                // if enterprise doens't exist in Pappers API, continue process
                if (is_null($data)) {
                    Log::warning("Pappers: enterprise {$enterprise->siren} not exist");
                    continue;
                }

                // if enterprise data is not readable in Pappers API
                if ($data->diffusable == false) {
                    Log::warning("Pappers: enterprise {$data->siren} not diffusable");
                    continue;
                }

                // if company already exist in Addworking database
                if (DB::table('companies')->where('identification_number', $data->siren)->count() > 0) {
                    Log::warning("Pappers: company {$data->siren} already exists in addworking system");

                    $company_id = DB::table('companies')->where('identification_number', $data->siren)
                        ->first()->id;

                    // if source of data on entreprise in Addworking database is not from Pappers API, update it
                    if ($enterprise->origin_data != 'api.pappers.fr') {
                        foreach ($data->etablissements as $establishment) {
                            $siret = substr(str_replace(' ', '', trim($enterprise->identification_number)), 0, 14);

                            if ($establishment->siret != $siret) {
                                continue;
                            }

                            $activity_id = $this->getActivity($establishment->code_naf, $country_fr_id)->id;
                            $country_id = $this->getCountry($establishment->code_pays)->id;
                            $city = $this->getCity($country_fr_id, $establishment);

                            if (is_null($city)) {
                                $city_id = $this->createCity($country_fr_id, $establishment, $now);
                            } else {
                                $city_id = $city->id;
                            }

                            $this->updateEstablishment(
                                $enterprise,
                                $establishment,
                                $company_id,
                                $activity_id,
                                $city_id,
                                $country_id
                            );
                        }
                    }
                    continue;
                }

                // define the legal form of company
                $legal_form = $this->defineLegalForm($data->categorie_juridique, $enterprise);

                // create a company
                $company_id = DB::table('companies')->insertGetId([
                    'id' => Uuid::generate(4),
                    'short_id' => $enterprise->number,
                    'identification_number' => $data->siren,
                    'legal_form_id' => $legal_form['legal_form_id'],
                    'country_id' => $country_fr_id,
                    'creation_date' => $data->date_creation,
                    'cessation_date' => $data->date_cessation,
                    'last_updated_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'is_sole_shareholder' => $data->associe_unique ?? false,
                    'origin_data' => 'api.pappers.fr'
                ]);

                // create denomination of company (name company)
                DB::table('company_denominations')->insert([
                    'id' => Uuid::generate(4),
                    'short_id' => DB::table('company_denominations')->max('short_id') + 1,
                    'company_id' => $company_id,
                    'name' =>
                        is_null($data->nom_entreprise) ? null : mb_strtoupper($data->nom_entreprise),
                    'commercial_name' => null,
                    'acronym' => is_null($data->sigle) ? null : mb_strtoupper($data->sigle),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // define the accounting year end date (month-day)
                if ($data->date_cloture_exercice != null) {
                    $account_year = Carbon::createFromLocaleFormat('d F', 'fr', $data->date_cloture_exercice)
                        ->endOfMonth()->format('m-d');
                } else {
                    $account_year = '12-31';
                }

                // create the invoincing details of company
                DB::table('company_invoicing_details')->insert([
                    'id' => Uuid::generate(4),
                    'short_id' => DB::table('company_invoicing_details')->max('short_id') + 1,
                    'company_id' => $company_id,
                    'accounting_year_end_date' => $account_year,
                    'vat_number' => $data->numero_tva_intracommunautaire,
                    'vat_exemption' => $legal_form['vat_exemption'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // if enterprise has employees, add it
                if ($data->entreprise_employeuse == true) {
                    DB::table('company_employees')->insert([
                        'id' => Uuid::generate(4),
                        'short_id' => DB::table('company_employees')->max('short_id') + 1,
                        'company_id' => $company_id,
                        'number' => $data->effectif_min,
                        'range' => 1,
                        'year' =>
                            Carbon::createFromFormat('Y', $data->annee_effectif)->endOfYear()->format('Y-m-d'),
                        'created_at' => $now,
                        'updated_at' => $now,
                        'origin_data' => 'api.pappers.fr'
                    ]);
                }

                // if enterprise has shared capital, add it
                if (! is_null($data->capital)) {
                    $currency_id = DB::table('currencies')->where('code', 978)->first()->id;
                    DB::table('company_share_capitals')->insert([
                        'id' => Uuid::generate(4),
                        'short_id' => DB::table('company_share_capitals')->max('short_id') + 1,
                        'company_id' => $company_id,
                        'currency_id' => $currency_id,
                        'amount' => $data->capital,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                if ($data->statut_rcs == 'Inscrit') {
                    $organisation = DB::table('registration_organizations')
                        ->where('code', $data->code_greffe)
                        ->where('country_id', $country_fr_id)
                        ->first();

                    if (! is_null($organisation)) {
                        $this->createRegistrationOrganization(
                            $company_id,
                            $organisation->id,
                            $data->date_immatriculation_rcs,
                            $data->date_radiation_rcs,
                            $now
                        );
                    }
                }

                if (! is_null($data->rnm)) {
                    $organisation = DB::table('registration_organizations')
                        ->where('location_formatted', mb_strtoupper($data->rnm->chambre_des_metiers))
                        ->where('country_id', $country_fr_id)
                        ->first();

                    if (! is_null($organisation)) {
                        $this->createRegistrationOrganization(
                            $company_id,
                            $organisation->id,
                            $data->rnm->date_immatriculation,
                            $data->rnm->date_radiation,
                            $now
                        );
                    }
                }

                if (empty($data->representants) && $data->personne_morale == false) {
                    DB::table('company_legal_representatives')->insert([
                        'id' => Uuid::generate(4),
                        'short_id' => DB::table('company_legal_representatives')->max('short_id') + 1,
                        'company_id' => $company_id,
                        'quality' => "Chef d'entreprise",
                        'starts_at' => $data->date_creation,
                        'first_name' => $data->prenom,
                        'last_name' => is_null($data->nom) ? null : mb_strtoupper(remove_accents($data->nom)),
                        'origin_data' => 'app.addworking.com',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                foreach ($data->representants as $legal_representative) {
                    if ($legal_representative->personne_morale == false) {
                        $item = [
                            'id' => Uuid::generate(4),
                            'short_id' => DB::table('company_legal_representatives')->max('short_id') + 1,
                            'company_id' => $company_id,
                            'quality' => $legal_representative->qualite,
                            'starts_at' => $legal_representative->date_prise_de_poste,
                            'first_name' => $legal_representative->prenom,
                            'last_name' => is_null($legal_representative->nom)
                                ? null
                                : mb_strtoupper(remove_accents($legal_representative->nom)),
                            'origin_data' => 'api.pappers.fr',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'date_birth' => $legal_representative->date_de_naissance ?? null,
                        ];

                        if (isset($legal_representative->code_pays_de_naissance)) {
                            $item['country_birth_id'] = DB::table('countries')
                                ->where('code', strtolower($legal_representative->code_pays_de_naissance))
                                ->first()->id;
                        }

                        if (isset($legal_representative->code_nationalité)) {
                            $item['country_nationality_id'] = DB::table('countries')
                                ->where('code', strtolower($legal_representative->code_nationalité))
                                ->first()->id;
                        }

                        if (isset($legal_representative->code_pays)) {
                            $item['country_id'] = DB::table('countries')
                                ->where('code', strtolower($legal_representative->code_pays))
                                ->first()->id;
                        }

                        DB::table('company_legal_representatives')->insert($item);
                    } else {
                        $item = [
                            'id' => Uuid::generate(4),
                            'short_id' => DB::table('company_legal_representatives')->max('short_id') + 1,
                            'company_id' => $company_id,
                            'quality' => $legal_representative->qualite,
                            'starts_at' => $legal_representative->date_prise_de_poste,
                            'denomination' =>
                                $legal_representative->denomination." (".$legal_representative->forme_juridique.")",
                            'identification_number' => $legal_representative->siren,
                            'origin_data' => 'api.pappers.fr',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];

                        if (isset($legal_representative->code_pays)) {
                            $item['country_id'] = DB::table('countries')
                                ->where('code', strtolower($legal_representative->code_pays))
                                ->first()->id;
                        }

                        DB::table('company_legal_representatives')->insert($item);
                    }
                }

                $activity_id = $this->getActivity($data->code_naf, $country_fr_id)->id;

                DB::table('company_activities')->insert([
                    'id' => Uuid::generate(4),
                    'short_id' => DB::table('company_activities')->max('short_id') + 1,
                    'activity_id' => $activity_id,
                    'company_id' => $company_id,
                    'social_object' => $data->objet_social,
                    'starts_at' => $data->date_creation,
                    'ends_at' => null,
                    'origin_data' => 'api.pappers.fr',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($data->etablissements as $establishment) {
                    $identification_number = str_replace(' ', '', trim($enterprise->identification_number));

                    $activity_id = $this->getActivity($establishment->code_naf, $country_fr_id)->id;
                    $country_id = $this->getCountry($establishment->code_pays)->id;
                    $city = $this->getCity($country_fr_id, $establishment);

                    if (is_null($city)) {
                        $city_id = $this->createCity($country_fr_id, $establishment, $now);
                    } else {
                        $city_id = $city->id;
                    }

                    if ($identification_number == $establishment->siret) {
                        $this->updateEstablishment(
                            $enterprise,
                            $establishment,
                            $company_id,
                            $activity_id,
                            $city_id,
                            $country_id
                        );
                    }
                }

                Log::info("Pappers: company {$data->siren} {$data->nom_entreprise} added");
                unset($company_id);
            } catch (\Exception $e) {
                Log::error("Pappers: company {$data->siren} {$data->nom_entreprise} errored");
                Log::error($e);
            }

            unset($enterprise);
            unset($response);
            unset($data);

            gc_collect_cycles();
        }
    }

    public function defineLegalForm(string $code, Enterprise $enterprise)
    {
        $legal_form = null;
        $vat_exemption = false;

        $subCode = substr($code, 0, 2);
        switch ($subCode) {
            case 57:
                $legal_form = LegalForm::where('name', 'sas')->first();
                break;
            case 56:
            case 55:
                $legal_form = LegalForm::where('name', 'sa')->first();
                break;
            case 54:
                $legal_form = LegalForm::where('name', 'sarl')->first();
                break;
            case 10:
                $legal_form = LegalForm::where('name', 'ei')->first();
                if ($enterprise->legalForm()->first()->name == 'micro') {
                    $vat_exemption = true;
                }
                break;
        }

        return [
            'legal_form_id' => $legal_form->id,
            'vat_exemption' => $vat_exemption
        ];
    }

    public function createCity(string $country_fr_id, $establishment, Carbon $now)
    {
        return DB::table('cities')
            ->insertGetId([
                'id' => Uuid::generate(4),
                'short_id' => DB::table('cities')->max('short_id') + 1,
                'country_id' => $country_fr_id,
                'name' => $establishment->ville,
                'zip_code' => $establishment->code_postal,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
    }

    public function getCity(string $country_fr_id, $establishment)
    {
        return DB::table('cities')
            ->where('country_id', $country_fr_id)
            ->where('name', $establishment->ville)
            ->where('zip_code', $establishment->code_postal)
            ->first();
    }

    public function getActivity(string $code, string $country_id)
    {
        return DB::table('activities')
            ->where('code', $code)
            ->where('country_id', $country_id)
            ->first();
    }

    public function getCountry(string $code)
    {
        return DB::table('countries')
            ->where('code', strtolower($code))
            ->first();
    }

    public function updateEstablishment($enterprise, $establishment, $company_id, $activity_id, $city_id, $country_id)
    {
        DB::table('addworking_enterprise_enterprises')->where('id', $enterprise->id)
            ->update([
                'short_id' => DB::table('addworking_enterprise_enterprises')->max('short_id') + 1,
                'company_id' => $company_id,
                'activity_id' => $activity_id,
                'establishment_name' => null,
                'code' => $establishment->nic,
                'address' => mb_strtoupper(remove_accents($establishment->adresse_ligne_1)),
                'additional_address' => is_null($establishment->adresse_ligne_2)
                    ? null
                    : mb_strtoupper(remove_accents($establishment->adresse_ligne_2)),
                'city_id' => $city_id,
                'country_id' => $country_id,
                'creation_date' => $establishment->date_de_creation,
                'cessation_date' => $establishment->date_cessation,
                'is_headquarter' => $establishment->siege,
                'origin_data' => 'api.pappers.fr',
            ]);
    }

    public function createRegistrationOrganization($company_id, $organisation_id, $registred_at, $delisted_at, $now)
    {
        DB::table('company_registration_organizations')->insert([
            'id' => Uuid::generate(4),
            'short_id' => DB::table('company_registration_organizations')->max('short_id') + 1,
            'company_id' => $company_id,
            'organization_id' => $organisation_id,
            'registred_at' => $registred_at,
            'delisted_at' => $delisted_at,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
