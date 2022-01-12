<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateAddworkingEnterpriseLegalFormsTable extends Migration
{
    protected $legalForms = [
        "sas"   => "SAS",
        "sasu"  => "SASU",
        "sa"    => "SA",
        "sarl"  => "SARL",
        "sarlu" => "SARLU",
        "eurl"  => "EURL",
        "eirl"  => "EIRL",
        "ei"    => "EI (Entreprise Individuelle)",
        "micro" => "Micro Entrepreneur",
    ];

    public function up()
    {
        Schema::create('addworking_enterprise_legal_forms', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('country');
            $table->timestamps();
            $table->primary('id');
        });

        DB::table('addworking_enterprise_legal_forms')->insert(
            Collection::wrap($this->legalForms)->map(function ($display_name, $name) {
                return compact('name', 'display_name') + [
                    'id' => Str::uuid(), 'country' => "fr", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                ];
            })->toArray()
        );

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->uuid('legal_form_id')->nullable();
            $table->foreign('legal_form_id')
                ->references('id')
                ->on('addworking_enterprise_legal_forms')
                ->onDelete('set null');
        });

        foreach (array_keys($this->legalForms) as $name) {
            DB::table('addworking_enterprise_enterprises')->where('legal_form', $name)->update([
                'legal_form_id' => DB::table('addworking_enterprise_legal_forms')
                    ->where('name', $name)
                    ->first()->id ?? null,
            ]);
        }

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('legal_form');
        });
    }

    public function down()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->string('legal_form')->nullable();
        });

        $ids = DB::table('addworking_enterprise_enterprises')
            ->whereNotNull('legal_form_id')
            ->groupBy('legal_form_id')
            ->pluck('legal_form_id');

        foreach ($ids as $id) {
            DB::table('addworking_enterprise_enterprises')->update([
                'legal_form' => DB::table('addworking_enterprise_legal_forms')->find($id)->name
            ]);
        }

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('legal_form_id');
        });

        Schema::dropIfExists('addworking_enterprise_legal_forms');
    }
}
