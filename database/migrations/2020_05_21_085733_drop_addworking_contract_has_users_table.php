<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DropAddworkingContractHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // move data to addworking_contract_contract_parties
        DB::table('addworking_contract_has_users')->get()->each(function ($row) {
            $user = DB::table('addworking_user_users')
                ->where('id', $row->user_id)
                ->first();

            $enterprise = DB::table('addworking_enterprise_enterprises_has_users')
                ->where('user_id', $row->user_id)
                ->where('is_signatory', true)
                ->first();

            DB::table('addworking_contract_contract_parties')->insert([
                'id' => Str::uuid(),
                'contract_id' => $row->contract_id,
                'contract_template_party_id' => null,
                'denomination' => "{$user->firstname} {$user->lastname}",
                'order' => 0,
                'enterprise_id' => optional($enterprise)->enterprise_id ,
                'user_id' => $row->user_id,
                'enterprise_name' => "",
                'user_name' => "{$user->firstname} {$user->lastname}",
                'signed' => $row->signed,
                'signed_at' => $row->signed_at,
            ]);
        });

        Schema::drop('addworking_contract_has_users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_contract_has_users', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('user_id')->nullable();
            $table->uuid('support_updated_signing_by')->nullable();
            $table->boolean('signed')->default(false);
            $table->integer('order')->default(0);
            $table->string('signinghub_field_name')->nullable();
            $table->string('signinghub_signer_name')->nullable();
            $table->string('signinghub_signature_status')->nullable();
            $table->string('signinghub_signature_reason')->nullable();
            $table->string('signinghub_signing_location')->nullable();
            $table->string('signinghub_contact_information')->nullable();
            $table->string('signinghub_signing_time')->nullable();
            $table->string('signinghub_subject_dn')->nullable();
            $table->datetime('signed_at')->nullable();

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');

            $table->foreign('support_updated_signing_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });
    }
}
