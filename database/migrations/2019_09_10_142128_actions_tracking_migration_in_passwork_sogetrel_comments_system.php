<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class ActionsTrackingMigrationInPassworkSogetrelCommentsSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $passworks = DB::table('sogetrel_user_passworks')->get('id');

        foreach ($passworks as $passwork) {
            $revisions = DB::table('revisions')
                ->where('key', "comment")
                ->where('revisionable_id', $passwork->id)
                ->get();

            if ($revisions->count() == 0) {
                continue;
            }

            foreach ($revisions as $revision) {
                if (!DB::table('addworking_user_users')->where('id', $revision->user_id)->exists()) {
                    continue;
                }

                DB::table('addworking_common_comments')
                    ->insert([
                        'id'                => Uuid::generate(4),
                        'author_id'         => $revision->user_id,
                        'content'           => $revision->new_value,
                        'commentable_id'    => $passwork->id,
                        'commentable_type'  => "App\Models\Sogetrel\User\Passwork",
                        'created_at'        => $revision->created_at,
                        'updated_at'        => $revision->updated_at,
                        'visibility'        => "public",
                    ]);
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
        $passworks = DB::table('sogetrel_user_passworks')->get('id');

        foreach ($passworks as $passwork) {
            $revisions = DB::table('revisions')
                ->where('key', "comment")
                ->where('revisionable_id', $passwork->id)
                ->get();

            if ($revisions->count() == 0) {
                continue;
            }

            foreach ($revisions as $revision) {
                DB::table('addworking_common_comments')
                    ->where('content', $revision->new_value)
                    ->where('created_at', $revision->created_at)
                    ->where('commentable_type', "App\Models\Sogetrel\User\Passwork")
                    ->where('author_id', $revision->user_id)
                    ->delete();
            }
        }
    }
}
