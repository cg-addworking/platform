<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MigrationOldPassworkCommentsIntoTheNewCommentSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('sogetrel_user_passworks')->where('comment', '!=', null)->get() as $passwork) {
            $passwork = collect($passwork);

            $revision = db::table('revisions')
                ->where('revisionable_type', "App\Models\Sogetrel\User\Passwork")
                ->where('key', "comment")
                ->where('revisionable_id', $passwork['id'])
                ->get()
                ->last();

            if ($revision) {
                $revision = collect($revision);

                $user = DB::table('addworking_user_users')->find($revision['user_id']);

                if (!$user) {
                    continue;
                }

                DB::table('addworking_common_comments')->insert([
                    'id'                => Str::uuid(),
                    'author_id'         => $revision['user_id'],
                    'created_at'        => $revision['created_at'],
                    'updated_at'        => $revision['updated_at'],
                    'commentable_id'    => $passwork['id'],
                    'commentable_type'  => "App\Models\Sogetrel\User\Passwork",
                    'content'           => $passwork['comment'],
                    'visibility'        => "protected",
                    'deleted_at'        => null,
                ]);
            }
        }

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->text('comment')->nullable();
        });
    }
}
