<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @deprecated v0.5.57 this migration uses models!
 */
class UpdateEnterprisesAddSignatory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->uuid('signatory_id')->nullable()->after('billing_date');
        });

        $id = optional(DB::table('roles')->where('name', 'owner')->first())->id;

        $items = DB::table('enterprise_user')
            ->select('user_id', 'enterprise_id')
            ->where('role_id', $id)
            ->where('primary', true)
            ->get();

        foreach ($items as $item) {
            DB::table('enterprises')
                ->where('id', $item
                ->enterprise_id)
                ->update(['signatory_id' => $item->user_id]);
        }

        if ($user = DB::table('users')->where('email', 'julien@addworking.com')->first()) {
            DB::table('enterprises')->where('name', 'ADDWORKING')->update([
                'signatory_id' => $user->id,
            ]);
        }

        if ($user = DB::table('users')->where('email', 'florence.dubreuil@stars-services.com')->first()) {
            DB::table('enterprises')->where('name', 'TSE EXPRESS MEDICAL')->update([
                'signatory_id' => $user->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('signatory_id');
        });
    }
}
