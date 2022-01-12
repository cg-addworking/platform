<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrationOfOperationalTrackingCommentsToNewCommentSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('sogetrel_user_passwork_logs')->get() as $comment) {
            DB::table('addworking_common_comments')->insert([
                'id'                => $comment->id,
                'author_id'         => $comment->user_id,
                'commentable_id'    => $comment->passwork_id,
                'commentable_type'  => "App\Models\Sogetrel\User\Passwork",
                'content'           => $comment->message,
                'created_at'        => $comment->created_at,
                'updated_at'        => $comment->updated_at,
                'deleted_at'        => null,
                'visibility'        => "protected"
            ]);
        }

        Schema::dropIfExists('sogetrel_user_passwork_logs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('sogetrel_user_passwork_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('passwork_id');
            $table->foreign('passwork_id')->references('id')->on('sogetrel_user_passworks')->onDelete('cascade');
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('addworking_user_users')->onDelete('set null');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }
}
