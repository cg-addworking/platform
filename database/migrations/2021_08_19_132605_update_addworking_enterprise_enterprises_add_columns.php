<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->integer('short_id')->nullable();
            $table->uuid('company_id')->nullable();
            $table->uuid('activity_id')->nullable();
            $table->string('establishment_name')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('additional_address')->nullable();
            $table->uuid('city_id')->nullable();
            $table->uuid('country_id')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->date('creation_date')->nullable();
            $table->date('cessation_date')->nullable();
            $table->boolean('is_headquarter')->default(false);
            
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('CASCADE');
            
            $table->foreign('activity_id')
                ->references('id')->on('activities')
                ->onDelete('SET NULL');
            
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('SET NULL');
            
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn([
                'short_id',
                'company_id',
                'activity_id',
                'establishment_name',
                'commercial_name',
                'code',
                'address',
                'additional_address',
                'city_id',
                'country_id',
                'latitude',
                'longitude',
                'creation_date',
                'cessation_date',
                'is_headquarter'
            ]);
        });
    }
}
