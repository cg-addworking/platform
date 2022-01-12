<?php

namespace App\Domain\Sogetrel\Navibat;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Sogetrel\Enterprise\Data;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SoapClient;
use Illuminate\Support\Facades\Log;
use Exception;

class Client
{
    protected $client;
    protected $wsdl_url;
    protected $login;
    protected $password;

    protected const METHOD = 'sendFournisseurAW?wsdl';

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $env = config('sogetrel.navibat.env');

        $this->wsdl_url = config("sogetrel.navibat.base_url_{$env}") . self::METHOD;
        $this->login    = config('sogetrel.navibat.auth.username');
        $this->password = config('sogetrel.navibat.auth.password');
    }

    /**
     * Connection to Sogetrel Navibat
     *
     * @return Client
     * @throws Exception
     */
    public function auth(): self
    {
        if (config('sogetrel.navibat.enabled') == false) {
            Log::error('Sogetrel Navibat webservice for sending vendors is disabled');
            throw new Exception("Sogetrel Navibat webservice for sending vendors is disabled");
        }

        if (is_null($this->client)) {
            $this->client = new SoapClient($this->wsdl_url, config('sogetrel.navibat.soap_options') + [
                'login' => $this->login,
                'password' => $this->password,
            ]);

            Log::info('Sogetrel Navibat webservice: Connection established');
        }

        return $this;
    }

    /**
     * Check if the vendor exist in Navibat database
     * Using wsExistFournisseur
     *
     * @param Enterprise $vendor
     * @return bool
     * @throws Exception
     */
    public function checkVendorExists(Enterprise $vendor): bool
    {
        Log::info("Sogetrel Navibat webservice: Check vendor {$vendor->name}");

        $data = $this->checkVendorExistsData($vendor);
        $validator = Validator::make($data, self::checkVendorExistsRules());

        if ($validator->fails()) {
            $this->logErrors($vendor, json_encode($validator->errors()->messages()), 'check');

            $errors = implode("", Arr::flatten($validator->errors()->getMessages()));
            Log::error(
                "Sogetrel Navibat webservice: Error when checked vendor exist {$vendor->name} ({$vendor->id})
                Errors : {$errors}",
            );

            return true;
        }

        $response = $this->auth()->client->wsExistFournisseur($data);
        $exist = (strtolower($response->returnValue) == 'true');

        if ($exist) {
            Log::info("Sogetrel Navibat webservice: vendor {$vendor->name} already exist in Navibat");

            if (! empty($response->NumeroFournisseur)) {
                $oracle_id_exist = Data::where('oracle_id', $response->NumeroFournisseur)->count();
                if ($oracle_id_exist > 0) {
                    $msg = "Oracle ID {$response->NumeroFournisseur} already exist in Addworking system";
                    Log::error("{$msg} (nbr = {$oracle_id_exist})");
                    return true;
                }

                if (! $vendor->sogetrelData()->exists()) {
                    $data = new Data;
                    $data->navibat_id = $vendor->number;
                    $data->navibat_sent = true;
                    $data->oracle_id = $response->NumeroFournisseur;

                    if ($vendor->legalForm->name == 'micro') {
                        $data->compta_marche_tva_group = 'FR-EXO';
                    }

                    $data->enterprise()->associate($vendor);
                    $data->save();
                } else {
                    $vendor->sogetrelData->update(['oracle_id' => $response->NumeroFournisseur]);
                }
                Log::info("Oracle id {$response->NumeroFournisseur} added to vendor {$vendor->name}");
            }
        }

        return $exist;
    }

    /**
     * Send vendor's informations to Navibat
     * Using wsPushFournisseur
     *
     * @param Enterprise $vendor
     * @return bool
     * @throws Exception
     */
    public function sendVendor(Enterprise $vendor, &$errors = null): bool
    {
        Log::info("Sogetrel Navibat webservice: Send vendor {$vendor->name}");

        $data = $this->sendVendorData($vendor);
        $validator = Validator::make($data, self::sendVendorRules());

        if ($validator->fails()) {
            $this->logErrors($vendor, json_encode($validator->errors()->messages()), 'send');
            $errors = implode("", Arr::flatten($validator->errors()->getMessages()));

            Log::error(
                "Sogetrel Navibat webservice: Error when sended vendor {$vendor->name} ({$vendor->id}) 
                validation fail Errors : {$errors}",
            );

            return false;
        }

        $kbis = DocumentType::where('id', '4bfa1efd-8a75-40e5-b470-2f4185b79ba1')->first();
        $kbis_validated = $vendor->documents()->ofDocumentType($kbis)->onlyValidated()->exists();

        if (! $kbis_validated) {
            $this->logErrors($vendor, 'certificate of establishment not valid', 'check');
            Log::info("Sogetrel Navibat webservice: Error {$vendor->name} ({$vendor->id}) kbis not valid");

            return false;
        }

        $request = $this->auth()->client->wsPushFournisseur($data);
        $vendor->sogetrelData->update(['navibat_sent' => true]);

        $vendor->logs()->create([
            'context'      => 'sogetrel',
            'process_type' => 'job',
            'type'         => 'info',
            'process_name' => 'SendVendorsToNavibat',
            'message'      =>
                "Sogetrel Navibat webservice: vendor sended {$vendor->id}, request response {$request->Retour}"
        ]);


        Log::info("Sogetrel Navibat webservice: vendor {$vendor->name} sended");

        return true;
    }

    /**
     * @return array
     */
    protected static function sendVendorRules()
    {
        return [
            'NoFournisseur'                 => "required|string|max:20",
            'SIRET'                         => "required|regex:/^\d{14}$/",
            'IdentifiantIntracommunautaire' => "required|string",
            'RaisonSociale'                 => "required|string|max:360",
            'Adresse'                       => "required|string|max:240",
            'Adresse2'                      => "nullable|string|max:240",
            'CP'                            => "required|string|max:20",
            'Ville'                         => "required|string|max:60",
            'CodeAPE'                       => "required|string|max:10",
            'Telephone'                     => "required|french_phone_number",
            'Email'                         => "required|email|max:80",
            'Effectif'                      => "nullable|integer",
            'GroupeComptaMarche'            => [
                'nullable', 'string', Rule::in(Data::getAvailableComptaMarcheGroups())
            ],
            'GroupComptaMarcheTVA'          => [
                'nullable', 'string', Rule::in(Data::getAvailableComptaMarcheTvaGroups())
            ],
            'GroupComptaProduit'            => [
                'nullable', 'string', Rule::in(Data::getAvailableComptaProduitGroups())
            ],
        ];
    }

    /**
     * @return array
     */
    protected static function checkVendorExistsRules()
    {
        return [
            'SIRET'     => 'required|regex:/^\d{14}$/',
            'IntraComm' => 'nullable',
        ];
    }

    /**
     * @param Enterprise $vendor
     * @return array
     */
    protected function checkVendorExistsData(Enterprise $vendor): array
    {
        return [
            'SIRET'     => $vendor->identification_number,
            'IntraComm' => Enterprise::calculateTaxIdentificationNumber($vendor),
        ];
    }

    /**
     * @param Enterprise $vendor
     * @return array
     */
    protected function sendVendorData(Enterprise $vendor): array
    {
        if (! $vendor->sogetrelData()->exists()) {
            $data = new Data;
            $data->navibat_id   = $vendor->number;
            $data->navibat_sent = false;

            if ($vendor->legalForm->name == 'micro') {
                $data->compta_marche_tva_group = 'FR-EXO';
            }

            $data->enterprise()->associate($vendor);
            $data->save();
        }

        $user = $vendor->legalRepresentatives()->first();
        $tvaNumber = $vendor->tax_identification_number ?? Enterprise::calculateTaxIdentificationNumber($vendor);
        $file64 = $this->createVendorFileInformations($vendor, $tvaNumber, $user);
        $legalForm = strtoupper($vendor->legalForm->name) ?? '';

        return [
            'NoFournisseur'                 => $vendor->sogetrelData->navibat_id,
            'SIRET'                         => $vendor->identification_number,
            'IdentifiantIntracommunautaire' => $tvaNumber,
            'RaisonSociale'                 => $vendor->name .' '. $legalForm,
            'Adresse'                       => $vendor->address->address,
            'Adresse2'                      => $vendor->address->additionnal_address ?? '',
            'CP'                            => $vendor->address->zipcode,
            'Ville'                         => $vendor->address->town,
            'CodeAPE'                       => strtoupper(trim($vendor->main_activity_code)) ?? '',
            'Telephone'                     => $vendor->primary_phone_number,
            'Email'                         => $vendor->legalRepresentatives()->first()->email,
            'Effectif'                      => $vendor->employees_count,
            'GroupeComptaMarche'            => $vendor->sogetrelData->compta_marche_group,
            'GroupComptaMarcheTVA'          => $vendor->sogetrelData->compta_marche_tva_group,
            'GroupComptaProduit'            => $vendor->sogetrelData->compta_produit_group,
            'CodeTaxe' => $this->getCodeTaxe($vendor),
            'Contact' => [
                'Civilite' => $this->getCivility($user->gender),
                'Prenom' => $user->firstname,
                'Nom' => $user->lastname,
                'IntituleEmploie' => $user->getJobTitleFor($vendor),
                'Telephone' => $vendor->primary_phone_number,
                'emailContact' => $user->email,
                'ContactAdministratif' => "",
            ],
            'piecesJointes' => [
                'fichierBase64' => $file64,
                'nom' => "QUESTIONNAIRE FOURNISSEUR SOGETREL",
                'extension' => "pdf"
            ]
        ];
    }

    /**
     * Add log in database
     *
     * @param Enterprise $enterprise
     * @param $errors
     * @param $method
     */
    private function logErrors(Enterprise $enterprise, $error, $method)
    {
        return $enterprise->logs()->create([
            'context' => 'sogetrel',
            'process_type' => 'job',
            'type' => 'error',
            'process_name' => 'SendVendorsToNavibat',
            'message' => "Sogetrel Navibat webservice: Error when {$method} vendor {$enterprise->id}",
            'content' => $error
        ]);
    }

    private function createVendorFileInformations(Enterprise $vendor, $tvaNumber, $user)
    {
        $pdf = PDF::loadView(
            "sogetrel.enterprise.document.vendor.information-pdf",
            @compact('vendor', 'tvaNumber', 'user')
        );

        $file = File::from($pdf->output())
            ->fill(['mime_type' => "application/pdf"])
            ->name("/{$vendor->id}/questionnaire-fournisseur-sogetrel-%ts%.pdf")
            ->saveAndGet();

        return base64_encode($file->content);
    }

    private function getCodeTaxe(Enterprise $vendor)
    {
        if (in_array($vendor->legalForm()->first()->name, ['ei', 'micro', 'eirl'])) {
            return 'FR_DE_DEC_EXO';
        }
        
        return 'FR_DE_AUTOL_TN';
    }

    private function getCivility(string $gender)
    {
        switch ($gender) {
            case 'male':
                return 'mr';
            case 'female':
                return 'mrs';
            default:
                return "other";
        }
    }
}
