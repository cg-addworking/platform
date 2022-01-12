<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @deprecated v0.5.57 this migration uses model classes!
 */
class ReattachContractToUsersEnterprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('files')->get() as $file) {
            if (!$file->contract) {
                continue;
            }

            $contract = $file->contract;

            try {
                $contract->enterprises()->attach($file->user->enterprises()->first());
            } catch (Exception $e) {
                // noop
            }

            try {
                $contract->users()->attach($file->user, [
                    'signed' => in_array($contract->status, ['signed', 'approved']),
                    'order' => 1,
                ]);
            } catch (Exception $e) {
                // noop
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
