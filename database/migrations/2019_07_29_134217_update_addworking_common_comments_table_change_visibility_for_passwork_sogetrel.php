<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingCommonCommentsTableChangeVisibilityForPassworkSogetrel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (sogetrel_passwork()::get() as $passwork) {
            foreach ($passwork->comments as $comment) {
                $comment->update(['visibility' => 'public']);
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
        foreach (sogetrel_passwork()::get() as $passwork) {
            foreach ($passwork->comments as $comment) {
                $comment->update(['visibility' => 'protected']);
            }
        }
    }
}
