<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class MigrationOldOutboundInvoiceCommentInNewSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $i = 0;

        foreach (DB::table('addworking_billing_outbound_invoices')->get() as $outbound_invoice) {
            $comments = db::table('addworking_billing_outbound_invoice_comments')
                ->where('outbound_invoice_id', $outbound_invoice->id)
                ->get();

            if (!$comments) {
                continue;
            }

            foreach ($comments as $comment) {
                $user = DB::table('addworking_user_users')->find($comment->author_id);

                if (!$user) {
                    continue;
                }

                DB::table('addworking_common_comments')->insert([
                    'id'                => Str::uuid(),
                    'author_id'         => $user->id,
                    'created_at'        => $comment->created_at,
                    'updated_at'        => $comment->updated_at,
                    'commentable_id'    => $outbound_invoice->id,
                    'commentable_type'  => "App\Models\Addworking\Billing\OutboundInvoice",
                    'content'           => $comment->content,
                    'visibility'        => "public",
                    'deleted_at'        => null,
                ]);

                $i++;
            }
        }

        logger()->debug("[MigrationOldOutboundInvoiceComments] $i message(s) were retrieved");
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
