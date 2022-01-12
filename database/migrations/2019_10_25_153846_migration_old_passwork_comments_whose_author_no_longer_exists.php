<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class MigrationOldPassworkCommentsWhoseAuthorNoLongerExists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $i = 0;

        foreach (DB::table('sogetrel_user_passworks')->get() as $passwork) {
            $revisions = DB::table('revisions')
                ->where('revisionable_type', "App\Models\Sogetrel\User\Passwork")
                ->where('key', "comment")
                ->where('revisionable_id', $passwork->id)
                ->get();

            if ($revisions->count() == 0) {
                continue;
            }

            foreach ($revisions as $revision) {
                $user = DB::table('addworking_user_users')->find($revision->user_id);

                if ($user) {
                    continue;
                }

                // The messages will be related to Stéphanie Deville
                $user = DB::table('addworking_user_users')->find('bd2165b1-3a39-4f68-a694-5177a1790252');

                if (!$user) {
                    break;
                }

                DB::table('addworking_common_comments')->insert([
                    'id'                => Str::uuid(),
                    'author_id'         => $user->id,
                    'created_at'        => $revision->created_at,
                    'updated_at'        => $revision->updated_at,
                    'commentable_id'    => $passwork->id,
                    'commentable_type'  => "App\Models\Sogetrel\User\Passwork",
                    'content'           => "Auteur initial supprimé : " . $revision->new_value,
                    'visibility'        => "public",
                    'deleted_at'        => null,
                ]);

                $i++;
            }
        }

        logger()->debug("[MigrationOldPassworkCommentsWhoseAuthorNoLongerExists] $i message(s) were retrieved");
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
