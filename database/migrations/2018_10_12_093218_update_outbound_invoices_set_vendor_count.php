<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOutboundInvoicesSetVendorCount extends Migration
{
    /**
     * @var array
     */
    protected $noodles = [
        '212db212-4cdb-4015-8d13-6a1a0ecac2ec' => 38,
        '043ddcf8-df70-45ef-8326-efe838572d1c' => 25,
        '12d7aadd-92d9-4b3b-b7fb-3256038b5964' => 35,
        'b4fb11d5-4b93-4078-a52c-c516441461b0' => 23,
        '8dbd74ed-80e1-468a-aed2-34df78e1e072' => 23,
        'eec65d94-bb75-4e0b-961a-3ab0bb0cc784' => 35,
        '9825f2b4-0c85-4960-a630-78f4dbe6442f' => 24,
        '20f4db8b-2b5c-4ed9-81dc-46ebca86dbb7' => 36,
        '1b846259-6f4c-481d-bcf5-a8097bdc3ef3' => 37,
        '3cbcbbb2-d19e-4103-8004-d469471f0d03' => 26,
        '92f80bf4-8a66-4586-b923-0037ee6eee74' => 31,
        'bb181bdf-6510-46fe-b035-0f3b54f8ab94' => 29,
        'c8e3a377-600f-43ea-b021-b04717283b45' => 31,
        'f3bfd94a-5b88-410f-8436-e8485b57f52f' => 30,
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->noodles as $id => $vendor_count) {
            DB::table('outbound_invoices')->where('id', $id)->update(@compact('vendor_count'));
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
