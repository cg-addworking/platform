<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class UpdateAddworkingEnterpriseEnterprisesHasPartnersTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->dateTime('activity_starts_at')->nullable();
            $table->dateTime('activity_ends_at')->nullable();
            $table->uuid('updated_by')->nullable();

            $table
                ->foreign('updated_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');
        });

        $partenships = DB::table('addworking_enterprise_enterprises_has_partners')->get();
        foreach ($partenships as $partenship) {
            $vendor = DB::table('addworking_enterprise_enterprises')->find($partenship->vendor_id);
            DB::table('addworking_enterprise_enterprises_has_partners')->where('vendor_id', $vendor->id)
                ->update(['activity_starts_at' => $vendor->created_at]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->dropColumn('activity_starts_at');
        });

        Schema::table('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->dropColumn('activity_ends_at');
        });

        Schema::table('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
}
