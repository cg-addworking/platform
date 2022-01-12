<?php

namespace App\Models\Spie\Enterprise;

use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise as AddworkingEnterprise;
use App\Models\Spie\Enterprise\CsvLoaderCasts;
use App\Models\Spie\Enterprise\Enterprise as SpieEnterprise;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Arr;
use RuntimeException;
use stdClass;

class EnterprisesCsvLoader extends CsvLoader
{
    use CsvLoaderCasts;

    protected $flags = CsvLoader::IGNORE_FIRST_LINE;

    public function headers(): array
    {
        return [
            'code',
            'index',
            'active',
            'name',
            'parent_external_id',
            'parent',
            'town',
            'zipcode',
            'phone',
            'email',
            'rank',
            'year',
            'gross_income',
            'topology',
            'al',
            'last_coface_enquiry',
            'last_coface_grade',
            'previous_coface_enquiry',
            'previous_coface_grade',
            'nuclear_qualification',
            'addressable_volume_large_order',
            'addressable_volume_average_order',
            'adressable_volume_small_order',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        $item->name   = strtoupper(remove_accents(trim($item->name)));
        $item->parent = strtoupper(remove_accents(trim($item->parent)));
        $item->phone  = preg_replace('/[^\d\+]/', '', $item->phone ?? '');

        $this->string($item->email);
        $this->string($item->topology);
        $this->string($item->parent_external_id);
        $this->string($item->town);
        $this->string($item->zipcode);
        $this->string($item->phone);

        $this->boolean($item->active);
        $this->boolean($item->nuclear_qualification);
        $this->boolean($item->addressable_volume_large_order);
        $this->boolean($item->addressable_volume_average_order);
        $this->boolean($item->adressable_volume_small_order);
        $this->boolean($item->al);

        $this->integer($item->rank);
        $this->integer($item->year);

        $this->float($item->gross_income);
        $this->float($item->last_coface_grade);
        $this->float($item->previous_coface_grade);

        $this->date($item->last_coface_enquiry);
        $this->date($item->previous_coface_enquiry);

        if ($item->parent == "N'APPARTIENT PAS A UN GROUPE") {
            $item->parent = null;
        }

        if (empty($item->name)) {
            throw new RuntimeException("name should not be empty");
        }

        if (empty($item->code)) {
            throw new RuntimeException("code should not be empty");
        }

        return $item;
    }

    public function import(stdClass $item): bool
    {
        $attributes = Arr::except(
            (array) $item,
            ['parent_external_id', 'parent', 'town', 'zipcode', 'phone', 'email']
        );

        if (is_null($spie_enterprise = SpieEnterprise::where(['code' => $item->code])->first())) {
            $addworking_enterprise = AddworkingEnterprise::firstOrCreate(
                ['name' => $item->name],
                ['external_id' => $item->code, 'registration_town' => $item->town]
            );

            if (SpieEnterprise::where('enterprise_id', $addworking_enterprise->id)->exists()) {
                throw new RuntimeException("dupplicated enterprise name: '{$item->name}'");
            }

            $spie_enterprise = new SpieEnterprise($attributes);
            $spie_enterprise->enterprise()->associate($addworking_enterprise);
            $spie_enterprise->save();
        }

        if (! $spie_enterprise->wasRecentlyCreated) {
            $spie_enterprise->update($attributes);
        }

        if ($spie_enterprise->enterprise->name != $item->name) {
            $spie_enterprise->enterprise->update(['name' => $item->name]);
        }

        if ($item->parent) {
            $spie_enterprise->enterprise->parent()->associate(
                AddworkingEnterprise::firstOrCreate(
                    ['name' => $item->parent],
                    ['external_id' => $item->parent_external_id]
                )
            )->save();
        }

        if ($item->phone) {
            $phone_number = PhoneNumber::firstOrCreate([
                'number' => $item->phone,
            ]);

            if ($phone_number->wasRecentlyCreated) {
                $spie_enterprise->enterprise->phoneNumbers()->sync($phone_number);
            }
        }

        return true;
    }
}
