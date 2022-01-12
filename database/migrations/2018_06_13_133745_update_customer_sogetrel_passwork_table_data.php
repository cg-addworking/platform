<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerSogetrelPassworkTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $passworks = DB::table('customer_sogetrel_passwork')->select('id', 'data')->get();

        foreach ($passworks as $passwork) {
            $data = json_decode($passwork->data, true);

            $data['departments'] = collect($data['departments'] ?? [])->mapWithKeys(function ($item) {
                return [snake_case(config('regions.Départements')[$item] ?? 'none') => true];
            })->toArray() ?? null;

            $data['has_worked_with'] = collect($data['has_worked_with'] ?? [])->mapWithKeys(function ($item) {
                return [$item => true];
            })->toArray() ?? null;

            $data['wants_to_work_with'] = collect($data['wants_to_work_with'] ?? [])->mapWithKeys(function ($item) {
                return [$item => true];
            })->toArray() ?? null;

            DB::table('customer_sogetrel_passwork')->where('id', $passwork->id)->update(['data' => json_encode($data)]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $passworks = DB::table('customer_sogetrel_passwork')->select('id', 'data')->get();

        foreach ($passworks as $passwork) {
            $data = json_decode($passwork->data, true);

            $data['departments'] = collect($data['departments'] ?? [])->keys()->toArray();

            $data['has_worked_with'] = collect($data['has_worked_with'] ?? [])->keys()->toArray();

            $data['wants_to_work_with'] = collect($data['wants_to_work_with'] ?? [])->keys()->toArray();

            DB::table('customer_sogetrel_passwork')->where('id', $passwork->id)->update(['data' => json_encode($data)]);
        }
    }
}
