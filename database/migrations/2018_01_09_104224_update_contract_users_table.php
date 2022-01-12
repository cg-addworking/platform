<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_user', function (Blueprint $table) {
            $table->string('signinghub_field_name')->nullable();
            $table->string('signinghub_signer_name')->nullable();
            $table->string('signinghub_signature_status')->nullable();
            $table->string('signinghub_signature_reason')->nullable();
            $table->string('signinghub_signing_location')->nullable();
            $table->string('signinghub_contact_information')->nullable();
            $table->string('signinghub_signing_time')->nullable();
            $table->string('signinghub_subject_dn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_user', function (Blueprint $table) {
            $table->dropColumn([
                'signinghub_field_name',
                'signinghub_signer_name',
                'signinghub_signature_status',
                'signinghub_signature_reason',
                'signinghub_signing_location',
                'signinghub_contact_information',
                'signinghub_signing_time',
                'signinghub_subject_dn',
            ]);
        });
    }
}
