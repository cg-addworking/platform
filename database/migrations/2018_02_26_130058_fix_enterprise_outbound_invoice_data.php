<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEnterpriseOutboundInvoiceData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = json_decode($this->json);

        if (is_null($data)) {
            throw new RuntimeException("Unable to decode json");
        }

        foreach ($data as $invoice) {
            $vendor_id = DB::table('enterprises')
                ->select('id')
                ->where('id', $invoice->outbound_invoice_id)
                ->orWhere('id', $invoice->vendor_id)
                ->get()[0]->id ?? null;

            $outbound_invoice_id = DB::table('outbound_invoices')
                ->select('id')
                ->where('id', $invoice->outbound_invoice_id)
                ->orWhere('id', $invoice->vendor_id)
                ->get()[0]->id ?? null;

            if (!isset($vendor_id, $outbound_invoice_id)) {
                continue;
            }

            $exists = (bool) DB::table('enterprise_outbound_invoice')
                ->where('vendor_id', $vendor_id)
                ->where('outbound_invoice_id', $outbound_invoice_id)
                ->count();

            if ($exists) {
                continue;
            }

            DB::table('enterprise_outbound_invoice')->insert([
                'vendor_id'           => $vendor_id,
                'outbound_invoice_id' => $outbound_invoice_id,
                'status'              => $invoice->status,
                'comment'             => $invoice->comment,
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
        //
    }

    protected $json = <<< EOF
[
    {
        "vendor_id": "e9727596-4e31-4589-b56b-aed906267c0f",
        "outbound_invoice_id": "c502ea5c-4377-4abb-bfd4-c6e9cf12bf66",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "927a76ba-ef9c-4ec3-8336-763b5126a95d",
        "outbound_invoice_id": "c502ea5c-4377-4abb-bfd4-c6e9cf12bf66",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "outbound_invoice_id": "c502ea5c-4377-4abb-bfd4-c6e9cf12bf66",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "c1721e68-6ceb-43a3-9650-faf3af76d30b",
        "outbound_invoice_id": "b2685608-2e07-4ba9-97bb-fff506602d2d",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "197cc233-0818-4199-ab27-4e8ff0b17c0c",
        "outbound_invoice_id": "d05352be-92dc-4258-9e21-2c8b06eb52e8",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "outbound_invoice_id": "45955c3a-849c-4854-8890-fa2edc8d397d",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "4aef325b-4a42-40be-b29f-9505e7650205",
        "outbound_invoice_id": "73c3ca8d-e349-4741-a00c-b52e5bba36b0",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "outbound_invoice_id": "73c3ca8d-e349-4741-a00c-b52e5bba36b0",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "cc6d4cff-9410-4795-acc5-6348b7f5a0fb",
        "outbound_invoice_id": "57fadbca-7fa3-4f0c-bdff-34b8fb3cc26d",
        "status": "validated",
        "comment": "--> pb sur REN252CS : 4 jours compt\\u00e9s par le syst\\u00e8me TSE alors que le PRESTA n'en facture que 3 --> Vu avec TSE, il faut compter 3 jours au lieu de 4 pour le fichier de Nov-2017",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "1d3c15d6-4833-4beb-9729-f17ac9f2d150",
        "outbound_invoice_id": "57fadbca-7fa3-4f0c-bdff-34b8fb3cc26d",
        "status": "validated",
        "comment": "--> pb : le syst\\u00e8me TSE remonte 21 jours factur\\u00e9s alors que le Presta en facture 22\\r--> OK ... facture modifi\\u00e9e par le Presta",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "d54a94e4-fc98-4a5e-b789-a371d31f1027",
        "outbound_invoice_id": "57fadbca-7fa3-4f0c-bdff-34b8fb3cc26d",
        "status": "validated",
        "comment": "pb :\\r--> pour code : GRE408CS --> le syst\\u00e8me TSE remonte 4 jours alors que le Presta n'en facture que 3 --> Vu avec TSE, il faut compter 3 jours au lieu de 4 pour le fichier de Nov-2017\\r--> pour code : GRE100CS --> le syst\\u00e8me TSE remonte 4 jours alors que le Presta n'en facture que 3 --> Vu avec TSE, il faut compter 3 jours au lieu de 4 pour le fichier de Nov-2017\\r--> pour code : GRE500CS --> le syst\\u00e8me TSE remonte 4 jours alors que le Presta n'en facture que 3 --> Vu avec TSE, il faut compter 3 jours au lieu de 4 pour le fichier de Nov-2017",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "d54a94e4-fc98-4a5e-b789-a371d31f1027",
        "outbound_invoice_id": "9a9c8c13-538b-4401-8b85-fdf3e03b0a1e",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "ddb7345c-4fd9-475a-b5f9-e085a86ffba9",
        "outbound_invoice_id": "9a9c8c13-538b-4401-8b85-fdf3e03b0a1e",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "3582ae39-49c0-4d7c-b01e-1bf722179664",
        "outbound_invoice_id": "9a9c8c13-538b-4401-8b85-fdf3e03b0a1e",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "b57bd432-d789-4395-9d0b-53ecefac341c",
        "outbound_invoice_id": "9a9c8c13-538b-4401-8b85-fdf3e03b0a1e",
        "status": "validated",
        "comment": "Le PRESTA signale qu'il n'a pas r\\u00e9alis\\u00e9 de mission le 26\/12 .... il faut donc compter 19 jours travaill\\u00e9s au lieu de 20. \\rValid\\u00e9 par Florence DUBREUIL.",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "4aef325b-4a42-40be-b29f-9505e7650205",
        "outbound_invoice_id": "9a880452-8b74-4094-acb8-f19d7142d5c5",
        "status": "to_validate",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "1c39ed7b-6226-4c8d-b695-176fa76dfab6",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "862f2a8a-dd24-4204-a255-cb15e07604e0",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "9431ca66-bdd2-4672-99fe-c456f5100cee",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "e1b5376b-c849-4ff2-8143-8f3b978968e6",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "00ad19dd-1a95-4be1-a6a1-cae792ba2e5d",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "57b81362-7a75-4253-8b4e-07059787bed1",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "5484e203-472b-4bc2-afc1-76ca3b2f66de",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "8243e499-b024-49b2-ae55-6868709200c3",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "54bfe5cb-886e-4000-88aa-8c21abc164fa",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "3cea4612-b07e-4d6b-8758-46e4b776efcd",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2664bbd6-b944-4435-b5e1-ce209cf6a136",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "9040404a-d300-4b7c-9a07-9ebb532b47fe",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "995440c3-01e3-47f3-b1cd-40ee7c1e8b4c",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "6f6f4e24-5ffb-4494-823a-b1dfce5f7e66",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "4afcab4a-b01e-4792-b640-2b63da72a230",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "3 probl\\u00e8mes : \\r- tourn\\u00e9e CHI186CS -- le Presta facture 5 jours \\u00e0 120 euros alors que le fichier TSE remonte 5 jours \\u00e0 60 euros\\r- tourn\\u00e9e CHI421C  -- le Presta facture 20 jours \\u00e0 145 euros alors que le fichier TSE remonte 20 jours \\u00e0 125 euros\\r- tourn\\u00e9e CHI185C  -- le Presta facture 20 jours \\u00e0 60 euros alors que le fichier TSE ne remonte rien\\r\\r-> OK valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2ff48ecb-485b-4bdd-8d28-e8c3b4808bad",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "3 probl\\u00e8mes : \\r- tourn\\u00e9e CHI430C -- le Presta facture 4 jours \\u00e0 200 euros alors que le fichier TSE remonte 4 jours \\u00e0 0 euros\\r\\rA voir avec le Presta : \\r- les totaux TTC de la facture du PRESTA sont faux --> facture \\u00e0 refaire\\r\\r--> @oceane : contacter le Presta pour lui demander de refaire sa facture (les totaux TTC sont faux)",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "52f448f8-3df9-457e-a283-7644dda2b406",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "-- Tourn\\u00e9e ANY089C \\u00e0 valider car pas de remont\\u00e9e dans le fichier TSE\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "bcdf6f6b-892f-431b-9039-632713d0dbf5",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "probl\\u00e8mes : \\r- tourn\\u00e9e BEA079C -- le Presta facture 7 jours \\u00e0 250 euros ET  13 jours \\u00e0 315 euros alors que le fichier TSE ne remonte que 20 jours \\u00e0 250 euros\\r- Taxe Gasoil : montant \\u00e0 valider\\r-> OK",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "f4bc7970-0e14-4bda-97cf-988d4d5b8060",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Eligibilit\\u00e9 \\u00e0 la TAXE_GASOIL \\u00e0 confirmer\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "09b29a97-2e80-430b-b533-7a9ed9ca93ac",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "probl\\u00e8me : \\r--> le fichier TSE fait remonter la tourn\\u00e9e LYN017 (4 jours \\u00e0 165 euros) alors que le PRESTA ne la facture pas. \\r--> probl\\u00e8me de nom de Tourn\\u00e9e : fichier TSE remonte Tourn\\u00e9e ANY101SCS (pour 5 \\u00e0 331 euros) alors que le PRESTA facture la tourn\\u00e9e LYN101CS pour le m\\u00eame montant\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "54ce1730-c4f9-4c29-b8f2-ed2531df8932",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "probl\\u00e8me : \\r--> Tourn\\u00e9e VAL022C : 9 jours \\u00e0 30 euros + 1 jour \\u00e0 30 euros remont\\u00e9s par le fichier TSE alors que le PRESTA ne le facture pas.\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "d388b613-5872-4f8a-80bc-092bf94c51db",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Facture \\u00e0 valider : \\r- pas de remont\\u00e9e par le fichier TSE\\r- pas de Code fournisseur \\r- pas de code analytique\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "1d3c15d6-4833-4beb-9729-f17ac9f2d150",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "--> Tourn\\u00e9e POI310C : le PRESTA facture 21 jours alors que le syst\\u00e8me TSE remonte 20 jours\\r--> OK ... facture modifi\\u00e9e par le Presta",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2fb03c6d-8bf3-48a0-a015-ebb42c56321b",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "--> tourn\\u00e9e STD25CS : le syst\\u00e8me TSE remonte 5 jours \\u00e0 75 euros, le PRESTA facture 2 jours \\u00e0 125 + 3 jours \\u00e0 135 \\r--> tourn\\u00e9e STD509 : le syst\\u00e8me TSE remonte 1 jours \\u00e0 0 euros, le PRESTA facture 1 jour \\u00e0 205 \\r--> tourn\\u00e9e STD504 : le syst\\u00e8me TSE remonte 1 jours \\u00e0 0 euros, le PRESTA facture 6 jours \\u00e0 190\\r\\r--> OK, valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "305d360d-b949-4ead-bd6f-58f42aa3f3c7",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Remont\\u00e9es du fichier TSE non visible dans l'interface mais conforme \\u00e0 la facture du PRESTA",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "0c3636de-0a14-4977-a942-8824d653cb5d",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Facture PRESTA \\u00e0 confirmer : aucune donn\\u00e9es remont\\u00e9es par le fichier TSE\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "df224ebd-467f-4edd-9394-1b20c93b1fd0",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Factures \\u00e0 valider - aucune remont\\u00e9e par le fichier TSE\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "b57bd432-d789-4395-9d0b-53ecefac341c",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "pending",
        "comment": "probl\\u00e8mes : \\r-- Tourn\\u00e9e STR132C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r-  Tourn\\u00e9e STR500C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r-  Tourn\\u00e9e STR501C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r-  Tourn\\u00e9e STR502C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r-  Tourn\\u00e9e STR562C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r-  Tourn\\u00e9e STR550C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r-  Tourn\\u00e9e STR552C : le Presta facture 19 jours alors que le syst\\u00e8me TSE remonte 20 jours \\r\\r- Tourn\\u00e9e STR551CS : le Presta facture 1.125 euros (15 jours ?) alors que le syst\\u00e8me TSE remonte 5 jours \\u00e0 75 euros soit 375 euros",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "05b86643-0a6d-4a93-b987-ab748ff80fb3",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Facture \\u00e0 valider : aucune donn\\u00e9e ne remonte du syst\\u00e8me TSE\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "04035c4f-1dcd-4dab-a300-90c896bcf8b8",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "- Tourn\\u00e9e AMI111 \\u00e0 valider (1 jour \\u00e0 163 euros) car non remont\\u00e9 dans le fichier TSE\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "ddb7345c-4fd9-475a-b5f9-e085a86ffba9",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "pending",
        "comment": "Facture \\u00e0 valider car non remont\\u00e9e dans le syst\\u00e8me de TSE",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "b3f9ff9c-e105-4c7d-a105-22f67ac6162d",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "Facture PRESTA : 71200580 (montant : 1020 euros) \\u00e0 valider car non remont\\u00e9e par le syst\\u00e8me TSE\\r--> OK Valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "3582ae39-49c0-4d7c-b01e-1bf722179664",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "pending",
        "comment": "Tourn\\u00e9e BEL493CS : le PRESTA facture 4 jours alors que le fichier TSE remonte 5 jours",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "c8218e66-745a-4414-a720-2fac1b834e00",
        "outbound_invoice_id": "dc327cc4-5c6c-4334-a0fc-27ef5734daf7",
        "status": "validated",
        "comment": "--> OK valid\\u00e9 par Florence DUBREUIL",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "927a76ba-ef9c-4ec3-8336-763b5126a95d",
        "outbound_invoice_id": "93d50f70-4dd6-495f-a838-5b65d76ce3bf",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "295d6852-7939-4972-880e-20335f2a1865",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "d2762c52-5e51-409a-a16c-22ba9071f6ac",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "4019094d-ec1b-435c-b0e0-c0f40b090c42",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2002f311-bdf0-4a2d-bd5e-36e952e0a00a",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "6cb19dc4-c3b8-4834-acf0-9438ef331038",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "21aa7925-7481-430e-a6fe-2b6ca0ab422c",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "3633349f-fb80-40e8-9c71-4ef201a5c498",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "44c4796f-3a6a-49a3-96ee-9ec17ea1f4fb",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "ac96f0b3-db41-4c63-b643-7d2a92cf933d",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "- en attente de la 2\\u00e8me facture qui n'est pas \"a r\\u00e9ception\" --> OK",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "76d82286-dd25-4f92-ac17-339a696503d6",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "- facture de 32.930 \\u20ac HT ne correspondant pas au fichier remont\\u00e9 par STAR'S SERVICE (32.745 \\u20ac HT) --> pour Amazon Logistics Bonneuil --> le ficher STAR'S SERVICE a \\u00e9t\\u00e9 mis \\u00e0 jour avec le bon montant \\u00e0 facturer (soit 32.930 HT) --> OK pour validation\\r\\r- facture de 18.605 \\u20ac HT ne correspondant pas au fichier remont\\u00e9 par STAR'S SERVICE (18.685 \\u20ac HT) --> pour Amazon Logistics Blanc Mesnil --> le ficher STAR'S SERVICE a \\u00e9t\\u00e9 mis \\u00e0 jour avec le bon montant \\u00e0 facturer (soit 18.315 HT) --> la facture du PRESTATAIRE a \\u00e9t\\u00e9 \\u00e9galement mise \\u00e0 jour --> OK pour validation",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "d4a5c046-d6ed-4b56-9f6c-45b15a916e35",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "montant de facturation \\u00e0 valider car pas de remont\\u00e9es dans le fichier STAR'S SERVICE\\rMontant valid\\u00e9 dans le dernier fichier MAJ par STAR'S SERVICE.",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "69ca679b-44ed-493b-a4b3-89883cc08d55",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "Code Analytique \\u00e0 compl\\u00e9ter",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "e6650ad0-4501-4234-891e-9b76b6b3a3fe",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "- facture de 29.045 \\u20ac HT ne correspondant pas au fichier remont\\u00e9 par STAR'S SERVICE (29.230 \\u20ac HT) --> pour AMAZON LOGISTIQUE BLANC MESNIL --> nouveau montant mis \\u00e0 jour par STAR SERICE (27.935,00 \\u00e0 facturer) --> en attente de la nouvelle facture du client",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "-- facture ADS ON BOARD (01L1P0042000)  \\u00e0 confirmer  (2.500 \\u20ac HT) car non remont\\u00e9e dans le fichier STAR'S SERVICE --> Montant remont\\u00e9 dans la MAJ du ficher STARS SERVICE -->  OK pour validation",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "e16f6e70-db0b-468d-b804-a16dfcc80047",
        "outbound_invoice_id": "bb09d854-90e3-4dd6-90a9-5be84cee75c4",
        "status": "validated",
        "comment": "-- Facture de 17.760 \\u20ac HT pour AMAZON LOGISTIQUE BLANC MESNIL (01N1AL002000) : montant \\u00e0 v\\u00e9rifier car ficher STAR'S SERVICE affiche 18.130 \\u20ac HT  --> nouvelle MAJ du fichier de STARS SERVICE affiche un montant de 17.575 --> attente de la facture mise \\u00e0 jour du PRESTATAIRE ... \\ril y a bien eu 96 livraisons, la facture du prestataire est correcte\\r\\r-- Code analytique pour facture de 6.140 \\u20ac HT \\u00e0 fournir = 01N1PN001000 AMAZON PRIME NOW",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "a5f5ec55-da82-4855-a4b1-5a7a0c4b7cbb",
        "outbound_invoice_id": "dd2a9dde-0f09-4211-ae8d-02827ecf87ab",
        "status": "validated",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "outbound_invoice_id": "dd2a9dde-0f09-4211-ae8d-02827ecf87ab",
        "status": "validated",
        "comment": "--> conforme au fichier STAR'S SERVICE",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "outbound_invoice_id": "dd2a9dde-0f09-4211-ae8d-02827ecf87ab",
        "status": "validated",
        "comment": "--> conforme au fichier de STAR'S SERVICE",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "ac96f0b3-db41-4c63-b643-7d2a92cf933d",
        "outbound_invoice_id": "dd2a9dde-0f09-4211-ae8d-02827ecf87ab",
        "status": "pending",
        "comment": "--> paiement \\u00e0 r\\u00e9ception \\u00e0 confirmer ?",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "d4a5c046-d6ed-4b56-9f6c-45b15a916e35",
        "outbound_invoice_id": "dd2a9dde-0f09-4211-ae8d-02827ecf87ab",
        "status": "pending",
        "comment": "--> pas pr\\u00e9sent dans le fichier STAR'S SERVICE \\r\\u00e0 confirmer :\\r- le montant ?\\r- condition de paiement \\u00e0 r\\u00e9ception ?",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "e16f6e70-db0b-468d-b804-a16dfcc80047",
        "outbound_invoice_id": "dd2a9dde-0f09-4211-ae8d-02827ecf87ab",
        "status": "pending",
        "comment": "\\u00e0 confirmer :\\r- condition de paiement \\u00e0 r\\u00e9ception ? \\r- le montant de la 1ere facture (le Presta remonte 17.760 \\u20ac HT \/ le fichier STARS SERVICE indique 18.130 \\u20ac HT",
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "outbound_invoice_id": "160212db-aba8-4399-afd7-e4172ab280f1",
        "status": "pending",
        "comment": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "vendor_id": "9a880452-8b74-4094-acb8-f19d7142d5c5",
        "outbound_invoice_id": "4aef325b-4a42-40be-b29f-9505e7650205",
        "status": "validated",
        "comment": null,
        "created_at": "2018-01-31 17:28:12",
        "updated_at": "2018-01-31 17:28:12"
    },
    {
        "vendor_id": "5cc872bc-f32e-43bc-b64c-4d9fb2374335",
        "outbound_invoice_id": "5addda76-dfeb-42bc-8832-955c0486ae68",
        "status": "pending",
        "comment": null,
        "created_at": "2018-02-05 16:25:31",
        "updated_at": "2018-02-05 16:26:34"
    },
    {
        "vendor_id": "48e7883e-6fee-4a69-ad6b-38cf32eade43",
        "outbound_invoice_id": "5addda76-dfeb-42bc-8832-955c0486ae68",
        "status": "pending",
        "comment": null,
        "created_at": "2018-02-05 16:29:07",
        "updated_at": "2018-02-05 16:29:07"
    },
    {
        "vendor_id": "71da877a-2d09-45a9-9dd5-7ddc103c1ee6",
        "outbound_invoice_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-07 11:21:02",
        "updated_at": "2018-02-07 11:21:02"
    },
    {
        "vendor_id": "8c2afa02-1f2e-44fe-a9d6-99400261faed",
        "outbound_invoice_id": "c1721e68-6ceb-43a3-9650-faf3af76d30b",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-07 18:52:14",
        "updated_at": "2018-02-07 18:52:14"
    },
    {
        "vendor_id": "b64805c2-de22-483a-8b1d-d8b79d79293b",
        "outbound_invoice_id": "fa828165-ba0d-4a8f-a08f-0ffb2cb20d89",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 15:11:24",
        "updated_at": "2018-02-08 15:11:24"
    },
    {
        "vendor_id": "b2685608-2e07-4ba9-97bb-fff506602d2d",
        "outbound_invoice_id": "c1721e68-6ceb-43a3-9650-faf3af76d30b",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-07 19:01:01",
        "updated_at": "2018-02-07 19:01:01"
    },
    {
        "vendor_id": "71da877a-2d09-45a9-9dd5-7ddc103c1ee6",
        "outbound_invoice_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "status": "validated",
        "comment": "Prestations non remont\\u00e9es dans les tableaux de suivi ... \\u00e0 confirmer pour facturation",
        "created_at": "2018-02-07 11:18:30",
        "updated_at": "2018-02-07 14:37:15"
    },
    {
        "vendor_id": "45d326d8-7f0e-4fbf-aa0d-76a948b7410d",
        "outbound_invoice_id": "6c323493-d6d2-4fc0-8324-082d719f6437",
        "status": "pending",
        "comment": null,
        "created_at": "2018-02-07 19:11:32",
        "updated_at": "2018-02-07 19:11:32"
    },
    {
        "vendor_id": "45d326d8-7f0e-4fbf-aa0d-76a948b7410d",
        "outbound_invoice_id": "c1721e68-6ceb-43a3-9650-faf3af76d30b",
        "status": "pending",
        "comment": null,
        "created_at": "2018-02-07 19:12:21",
        "updated_at": "2018-02-07 19:12:21"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "ac96f0b3-db41-4c63-b643-7d2a92cf933d",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 17:40:53",
        "updated_at": "2018-02-08 17:40:53"
    },
    {
        "vendor_id": "71da877a-2d09-45a9-9dd5-7ddc103c1ee6",
        "outbound_invoice_id": "a5f5ec55-da82-4855-a4b1-5a7a0c4b7cbb",
        "status": "validated",
        "comment": "Prestations non remont\\u00e9es dans les tableaux de suivi ... \\u00e0 confirmer pour facturation",
        "created_at": "2018-02-07 11:14:44",
        "updated_at": "2018-02-08 10:42:03"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "44c4796f-3a6a-49a3-96ee-9ec17ea1f4fb",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 17:49:33",
        "updated_at": "2018-02-08 17:49:33"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "d2762c52-5e51-409a-a16c-22ba9071f6ac",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 17:54:50",
        "updated_at": "2018-02-08 17:54:50"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "4019094d-ec1b-435c-b0e0-c0f40b090c42",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 17:59:40",
        "updated_at": "2018-02-08 17:59:40"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "54bfe5cb-886e-4000-88aa-8c21abc164fa",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 16:03:33",
        "updated_at": "2018-02-09 16:03:33"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "e16f6e70-db0b-468d-b804-a16dfcc80047",
        "status": "validated",
        "comment": "Facture de 13 240.00 euros \\u00e0 valider (ne remontent pas dans les tableaux)",
        "created_at": "2018-02-08 18:03:01",
        "updated_at": "2018-02-08 18:04:14"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "6cb19dc4-c3b8-4834-acf0-9438ef331038",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 18:05:42",
        "updated_at": "2018-02-08 18:05:42"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "21aa7925-7481-430e-a6fe-2b6ca0ab422c",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 18:07:01",
        "updated_at": "2018-02-08 18:07:01"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "3633349f-fb80-40e8-9c71-4ef201a5c498",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-08 18:07:56",
        "updated_at": "2018-02-08 18:07:56"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "c3e611e0-0f9e-413b-93e4-24692015ad50",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 09:20:29",
        "updated_at": "2018-02-09 09:20:29"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "3582ae39-49c0-4d7c-b01e-1bf722179664",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 16:57:49",
        "updated_at": "2018-02-09 16:57:49"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "3cea4612-b07e-4d6b-8758-46e4b776efcd",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-13 16:31:01",
        "updated_at": "2018-02-13 16:31:01"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "2664bbd6-b944-4435-b5e1-ce209cf6a136",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 16:15:06",
        "updated_at": "2018-02-09 16:15:06"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "d388b613-5872-4f8a-80bc-092bf94c51db",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 14:51:35",
        "updated_at": "2018-02-16 17:12:26"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "f4bc7970-0e14-4bda-97cf-988d4d5b8060",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 11:11:41",
        "updated_at": "2018-02-09 15:22:09"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "09b29a97-2e80-430b-b533-7a9ed9ca93ac",
        "status": "validated",
        "comment": "Tourn\\u00e9e LYN017 : TSE compte 4 jours \\u00e0 165 euros \/ le PRESTA compte 8 jours \\u00e0 157 euros\\r\\rDonn\\u00e9es valid\\u00e9es par les op\\u00e9rationnels : 8 jours \\u00e0 157 \\u20ac",
        "created_at": "2018-02-09 15:26:34",
        "updated_at": "2018-02-15 09:40:36"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "1c39ed7b-6226-4c8d-b695-176fa76dfab6",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 15:27:18",
        "updated_at": "2018-02-09 15:27:19"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "862f2a8a-dd24-4204-a255-cb15e07604e0",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 15:28:10",
        "updated_at": "2018-02-09 15:28:10"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "9040404a-d300-4b7c-9a07-9ebb532b47fe",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 16:15:46",
        "updated_at": "2018-02-09 16:15:46"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "9431ca66-bdd2-4672-99fe-c456f5100cee",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 13:59:52",
        "updated_at": "2018-02-09 15:37:18"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "e1b5376b-c849-4ff2-8143-8f3b978968e6",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 15:38:52",
        "updated_at": "2018-02-09 15:38:52"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "00ad19dd-1a95-4be1-a6a1-cae792ba2e5d",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 15:39:27",
        "updated_at": "2018-02-09 15:39:27"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "995440c3-01e3-47f3-b1cd-40ee7c1e8b4c",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 16:16:17",
        "updated_at": "2018-02-09 16:16:17"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "54ce1730-c4f9-4c29-b8f2-ed2531df8932",
        "status": "validated",
        "comment": "Manque sur la facture du PRESTA : VAL022C \/ 22 jours \\u00e0 30 = 660\\rCette tourn\\u00e9e est arr\\u00eat\\u00e9e - erreur syst\\u00e8me 4D",
        "created_at": "2018-02-09 15:35:17",
        "updated_at": "2018-02-09 15:41:35"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "57b81362-7a75-4253-8b4e-07059787bed1",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 15:42:52",
        "updated_at": "2018-02-09 15:42:52"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "1d3c15d6-4833-4beb-9729-f17ac9f2d150",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 15:43:27",
        "updated_at": "2018-02-09 15:43:27"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "df224ebd-467f-4edd-9394-1b20c93b1fd0",
        "status": "validated",
        "comment": "Aucune information sur le fichier TSE : \\u00e0 confirmer",
        "created_at": "2018-02-09 14:51:52",
        "updated_at": "2018-02-09 17:07:44"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "295d6852-7939-4972-880e-20335f2a1865",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-13 16:37:00",
        "updated_at": "2018-02-13 16:37:00"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "6337115a-e040-44da-ad6f-e81817229f4d",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-15 10:15:25",
        "updated_at": "2018-02-16 13:23:35"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "2002f311-bdf0-4a2d-bd5e-36e952e0a00a",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-13 16:38:18",
        "updated_at": "2018-02-13 16:38:18"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "6f6f4e24-5ffb-4494-823a-b1dfce5f7e66",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 16:39:57",
        "updated_at": "2018-02-09 16:39:57"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "5484e203-472b-4bc2-afc1-76ca3b2f66de",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-13 17:58:07",
        "updated_at": "2018-02-13 17:58:07"
    },
    {
        "vendor_id": "f892f85b-0a18-45a4-979d-78a324084759",
        "outbound_invoice_id": "2664bbd6-b944-4435-b5e1-ce209cf6a136",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-14 10:15:51",
        "updated_at": "2018-02-14 10:15:51"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "8243e499-b024-49b2-ae55-6868709200c3",
        "status": "validated",
        "comment": "Le PRESTA compte une location de mat\\u00e9riel sur la TOURNE ORL494C pour 40 euros.\\rC'est normal",
        "created_at": "2018-02-09 14:07:28",
        "updated_at": "2018-02-09 17:08:12"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "e6650ad0-4501-4234-891e-9b76b6b3a3fe",
        "status": "pending",
        "comment": "Presta pour AMAZON LOGISTIQUE BLANC MESNIL : Tableau STARS SERVICES remonte 29.970 euros HT \\u00e0 facturer \/ Le PRESTA a une facture de 28.505 euros HT .... \\u00e0 valider",
        "created_at": "2018-02-12 10:38:51",
        "updated_at": "2018-02-16 14:31:35"
    },
    {
        "vendor_id": "7354ad6c-003e-4be1-ab4f-26e2fc31e649",
        "outbound_invoice_id": "e9727596-4e31-4589-b56b-aed906267c0f",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-09 17:41:56",
        "updated_at": "2018-02-09 17:41:56"
    },
    {
        "vendor_id": "47845659-f365-4efc-845f-f69fae85862d",
        "outbound_invoice_id": "305d360d-b949-4ead-bd6f-58f42aa3f3c7",
        "status": "validated",
        "comment": "TSE ne compte que 22 jours \/ le PRESTA compte 23 jours\\r\\rPresta eu en ligne le 15\/02: ok renvoie la facture modifi\\u00e9e dans la matin\\u00e9e",
        "created_at": "2018-02-09 16:00:10",
        "updated_at": "2018-02-15 10:39:55"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "fa828165-ba0d-4a8f-a08f-0ffb2cb20d89",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-14 15:10:30",
        "updated_at": "2018-02-16 14:12:57"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "1a4e88f5-0de9-4e84-a097-7cbc907b1b76",
        "status": "validated",
        "comment": "Facture \\u00e0 refaire : pas d'ent\\u00eate, aucun mention....",
        "created_at": "2018-02-12 10:33:07",
        "updated_at": "2018-02-16 10:39:53"
    },
    {
        "vendor_id": "2837e270-5084-4721-8ba2-f816906580c8",
        "outbound_invoice_id": "6337115a-e040-44da-ad6f-e81817229f4d",
        "status": "pending",
        "comment": null,
        "created_at": "2018-02-14 15:19:39",
        "updated_at": "2018-02-14 15:19:39"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "status": "pending",
        "comment": "Il manquerait une facture de nomm\\u00e9e \"FAST & GO FORFAIT\" dans le fichier remont\\u00e9 par STARS Services d'un montant de : 12.350 HT euros\\rLA FACTURE DU FORFAIT EST BIEN DANS LE TABLEAU POUR NESPRESSO",
        "created_at": "2018-02-08 17:43:23",
        "updated_at": "2018-02-16 14:33:49"
    },
    {
        "vendor_id": "72068256-cb9a-404a-b323-7bec34f7a77f",
        "outbound_invoice_id": "76d82286-dd25-4f92-ac17-339a696503d6",
        "status": "pending",
        "comment": "PRESTA : AMAZON LOGISTIQUE BLANC MESNIL : le fichier STARS SERVICES remonte 19.795 euros \\u00e0 facturer \/ Le PRESTA remonte un montant de 19.240 euros\\r\\rOc\\u00e9ane: eu en ligne le 16\/02: ok renvoi la facture dans l'apr\\u00e8s-midi",
        "created_at": "2018-02-14 10:56:44",
        "updated_at": "2018-02-16 14:29:56"
    },
    {
        "vendor_id": "74a98577-e22e-4e13-beb6-9e4ef965a471",
        "outbound_invoice_id": "b3f9ff9c-e105-4c7d-a105-22f67ac6162d",
        "status": "validated",
        "comment": "A valider car pas de donn\\u00e9es dans le fichier TSE",
        "created_at": "2018-02-09 17:07:54",
        "updated_at": "2018-02-19 13:11:56"
    },
    {
        "vendor_id": "0d5e7df6-4a51-4904-8aa2-fccd6bef3575",
        "outbound_invoice_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-05 10:13:59",
        "updated_at": "2018-03-05 14:28:59"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "bcdf6f6b-892f-431b-9039-632713d0dbf5",
        "status": "validated",
        "comment": "Tourn\\u00e9e BEA079C : TSE compte un prix \\u00e0 315 euros la journ\\u00e9e \/ le PRESTA compte 250 euros la journ\\u00e9e\\rMontant TAXE_GASOIL \\u00e0 valider\\r\\rLe prestataire doit refaire sa facture avec un tarif \\u00e0 315 \\u20ac.\\r\\rPresta eu en ligne le 15\/02: a bien modifi\\u00e9 et ret\\u00e9l\\u00e9charger sa facture le 12\/02\\r\\rIl n'y a plus que la TAXE_GASOIL \\u00e0 valider par TSE",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 10:33:36"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "c8218e66-745a-4414-a720-2fac1b834e00",
        "status": "validated",
        "comment": "Tourn\\u00e9e REI450C : TSE compte 5 jours \\u00e0 0 \/ le PRESTA compte 4 jours \\u00e0 226 euros",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 10:18:27"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "2ff48ecb-485b-4bdd-8d28-e8c3b4808bad",
        "status": "validated",
        "comment": "TSE - CHI431 \\u00e0 0\\u20ac\/jour\\rASN - CHI431 \\u00e0 200\\u20ac\/jour",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 15:33:23"
    },
    {
        "vendor_id": "6f031dad-50c1-4b5c-b7d1-ac10ed4cae60",
        "outbound_invoice_id": "e6650ad0-4501-4234-891e-9b76b6b3a3fe",
        "status": "validated",
        "comment": "Presta pour AMAZON LOGISTIQUE BLANC MESNIL : Tableau STARS SERVICES remonte 29.970 euros HT \\u00e0 facturer \/ Le PRESTA a une facture de 28.505 euros HT .... \\u00e0 valider\\r#Patrick : demand\\u00e9 par mail le 19\/02\/2018\\r#Patrick : facture corrig\\u00e9e par le prestataire.",
        "created_at": "2018-02-16 14:31:26",
        "updated_at": "2018-02-20 16:37:52"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "b3f9ff9c-e105-4c7d-a105-22f67ac6162d",
        "status": "validated",
        "comment": "TOURNEE FTY123C : TSE compte 19 jours \\u00e0 190 euros \/ le PRESTA en compte 22 \\u00e0 190\\rFacture 80100010 de 1520 euros HT \\u00e0 valider\\r\\rPourquoi la valeur affich\\u00e9e sur la premi\\u00e8re facture est en TTC au lieu du HT ? --> OK c'est corrig\\u00e9",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 15:38:34"
    },
    {
        "vendor_id": "6f031dad-50c1-4b5c-b7d1-ac10ed4cae60",
        "outbound_invoice_id": "1a4e88f5-0de9-4e84-a097-7cbc907b1b76",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-16 14:49:18",
        "updated_at": "2018-02-16 14:49:18"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "ddb7345c-4fd9-475a-b5f9-e085a86ffba9",
        "status": "validated",
        "comment": "\\u00e0 confirmer car pas de donn\\u00e9es TSE",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 10:43:05"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "b57bd432-d789-4395-9d0b-53ecefac341c",
        "status": "validated",
        "comment": "Tourn\\u00e9e STR550C : TSE compte 22 jours \\u00e0 225 euros = 4950 euros  \/ le PRESTA compte 6102 euros .... \/Modification_OK vu avec op\\u00e9rationnel TSE\\rTourn\\u00e9e STR551CS : TSE compte 4 jours \\u00e0 75 euros = 300 euros  \/ le PRESTA compte 900 euros .... \/ Modification_OK\\rTourn\\u00e9e STR553CS : TSE compte 4 jours \\u00e0 95 euros = 380 euros  \/ le PRESTA compte 444 euros .... \/ + 60\\u20ac vu avec op\\u00e9rationnel TSE_OK\\r\\rFacture modifi\\u00e9e par le prestataire et valid\\u00e9e par son op\\u00e9rationnel TSE ... \\u00e0 faire confirmer par Florence ou V\\u00e9ronique",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-20 16:43:32"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "d54a94e4-fc98-4a5e-b789-a371d31f1027",
        "status": "validated",
        "comment": "Merci de faire refaire la facture en date de 2018\\r#Patrick : demand\\u00e9 par mail le 19\/02\/2018",
        "created_at": "2018-02-19 10:56:07",
        "updated_at": "2018-02-20 11:51:42"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "04035c4f-1dcd-4dab-a300-90c896bcf8b8",
        "status": "validated",
        "comment": "Tourn\\u00e9e AMI110 : TSE compte 2 jours \\u00e0 0 \/ le PRESTA compte 5 jours \\u00e0 240 euros \\rTourn\\u00e9e AMI11 :  TSE compte 1 jours \\u00e0 0 \/ le PRESTA compte 4 jours \\u00e0 163 euros",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 10:01:09"
    },
    {
        "vendor_id": "6f031dad-50c1-4b5c-b7d1-ac10ed4cae60",
        "outbound_invoice_id": "76d82286-dd25-4f92-ac17-339a696503d6",
        "status": "validated",
        "comment": "PRESTA : AMAZON LOGISTIQUE BLANC MESNIL : le fichier STARS SERVICES remonte 19.795 euros \\u00e0 facturer \/ Le PRESTA remonte un montant de 19.240 euros\\rOc\\u00e9ane: eu en ligne le 16\/02: ok renvoi la facture dans l'apr\\u00e8s-midi\\r#Patrick : demand\\u00e9 par mail le 19\/02\/2018\\r#Patrick : nouvelle facture de 19795\\u20ac OK transmis par le presta.",
        "created_at": "2018-02-16 14:30:17",
        "updated_at": "2018-02-20 16:34:00"
    },
    {
        "vendor_id": "176cccff-fb34-4b4d-9de1-f64add9ddcc6",
        "outbound_invoice_id": "2fb03c6d-8bf3-48a0-a015-ebb42c56321b",
        "status": "pending",
        "comment": "Tourn\\u00e9e CHI250 : TSE compte 1 jour \\u00e0 0 \/ Le Presta Compte 1 jour \\u00e0 190\\rTourn\\u00e9e STD509 : TSE compte 2 jours \\u00e0 0 \/ Le Presta Compte 2 jours \\u00e0 205\\rTourn\\u00e9e STD504 : TSE compte 2 jours \\u00e0 0 \/ Le Presta Compte 2 jours \\u00e0 190\\rTourn\\u00e9e STD510 : TSE compte 4 jours \\u00e0 0 \/ Le Presta Compte 4 jours \\u00e0 215\\rTourn\\u00e9e STD440 : TSE compte 3 jours \\u00e0 0 \/ Le Presta Compte 3 jours \\u00e0 210\\rTourn\\u00e9e STD450 : TSE compte 4 jours \\u00e0 0 \/ Le Presta Compte 4 jours \\u00e0 215\\r#Patrick : NE PLUS REGLER CE PRESTATAIRE SANS NOUVELLE INFORMATION.",
        "created_at": "2018-02-20 17:33:23",
        "updated_at": "2018-02-20 17:33:23"
    },
    {
        "vendor_id": "0d5e7df6-4a51-4904-8aa2-fccd6bef3575",
        "outbound_invoice_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-05 09:57:32",
        "updated_at": "2018-03-05 14:29:14"
    },
    {
        "vendor_id": "0922b07d-525d-4610-a9be-d93f658da023",
        "outbound_invoice_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "status": "validated",
        "comment": null,
        "created_at": "2018-02-22 11:35:58",
        "updated_at": "2018-02-22 11:35:58"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "05b86643-0a6d-4a93-b987-ab748ff80fb3",
        "status": "validated",
        "comment": "Facture \\u00e0 valider par TSE car aucune donn\\u00e9es dans le fichier remont\\u00e9.",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-20 16:20:18"
    },
    {
        "vendor_id": "e26e8028-e4c5-42c7-a4d5-b80aac81f4fe",
        "outbound_invoice_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 09:01:57",
        "updated_at": "2018-03-07 09:01:57"
    },
    {
        "vendor_id": "6f031dad-50c1-4b5c-b7d1-ac10ed4cae60",
        "outbound_invoice_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "status": "validated",
        "comment": "Il manque une facture de 12.350 euros mentionn\\u00e9e \"FAST & GO FORFAIT\" dans le tableau de STARS SERVICES ... il faut demander au PRESTA de faire la facture.\\r#Patrick : demand\\u00e9 par mail le 19\/02\/2018\\r#Patrick : suite entretien prestataire par t\\u00e9l, cette facture n'est pas d'actualit\\u00e9 \\u00e0 ce jour.",
        "created_at": "2018-02-16 14:48:23",
        "updated_at": "2018-02-20 16:40:48"
    },
    {
        "vendor_id": "96199061-f79a-43f6-b240-7e490e7a5cee",
        "outbound_invoice_id": "52f448f8-3df9-457e-a283-7644dda2b406",
        "status": "validated",
        "comment": "En attente de validation par TSE car ne remonte pas dans le fichier",
        "created_at": "2018-02-16 17:06:31",
        "updated_at": "2018-02-19 11:25:39"
    },
    {
        "vendor_id": "82c8b324-7887-4789-943d-e8c697d7e8ec",
        "outbound_invoice_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "status": "pending",
        "comment": null,
        "created_at": "2018-03-07 21:17:35",
        "updated_at": "2018-03-07 21:20:27"
    },
    {
        "vendor_id": "eef477f1-f71f-41d6-a209-0c1abc3470dd",
        "outbound_invoice_id": "4aef325b-4a42-40be-b29f-9505e7650205",
        "status": "pending",
        "comment": null,
        "created_at": "2018-03-06 11:23:31",
        "updated_at": "2018-03-07 21:21:57"
    },
    {
        "vendor_id": "0d5e7df6-4a51-4904-8aa2-fccd6bef3575",
        "outbound_invoice_id": "a5f5ec55-da82-4855-a4b1-5a7a0c4b7cbb",
        "status": "validated",
        "comment": "#Oc\\u00e9ane: infos transmises par le prestataire - \\rPour les bacs:      -Villejuif:50 bacs.\\r                    -becon les bruy\\u00e8res:130 bacs.\\r                    -Asni\\u00e8res marche:120 bacs.",
        "created_at": "2018-03-01 17:31:09",
        "updated_at": "2018-03-05 11:06:02"
    },
    {
        "vendor_id": "a27c3b4c-f284-4c8b-bd58-23f20f27292d",
        "outbound_invoice_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-06 11:22:41",
        "updated_at": "2018-03-07 21:25:05"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "ac96f0b3-db41-4c63-b643-7d2a92cf933d",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:30:31",
        "updated_at": "2018-03-07 08:30:31"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "cddda9bf-dc11-4191-9579-bf5e5605f56b",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:30:54",
        "updated_at": "2018-03-07 08:30:54"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "76d82286-dd25-4f92-ac17-339a696503d6",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:32:08",
        "updated_at": "2018-03-07 08:32:08"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "e6650ad0-4501-4234-891e-9b76b6b3a3fe",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:32:31",
        "updated_at": "2018-03-07 08:32:31"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "f086d15f-a5df-472d-8937-42d00130014f",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:33:01",
        "updated_at": "2018-03-07 08:33:01"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "44c4796f-3a6a-49a3-96ee-9ec17ea1f4fb",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:33:18",
        "updated_at": "2018-03-07 08:33:18"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "d2762c52-5e51-409a-a16c-22ba9071f6ac",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:33:38",
        "updated_at": "2018-03-07 08:33:38"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "fa828165-ba0d-4a8f-a08f-0ffb2cb20d89",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:33:57",
        "updated_at": "2018-03-07 08:33:57"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "e16f6e70-db0b-468d-b804-a16dfcc80047",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:34:17",
        "updated_at": "2018-03-07 08:34:17"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "6cb19dc4-c3b8-4834-acf0-9438ef331038",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:34:38",
        "updated_at": "2018-03-07 08:34:38"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "21aa7925-7481-430e-a6fe-2b6ca0ab422c",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:34:53",
        "updated_at": "2018-03-07 08:34:53"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "3633349f-fb80-40e8-9c71-4ef201a5c498",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-07 08:35:07",
        "updated_at": "2018-03-07 08:35:07"
    },
    {
        "vendor_id": "913e3332-1c26-4f1f-8e02-9a8a47579b73",
        "outbound_invoice_id": "6337115a-e040-44da-ad6f-e81817229f4d",
        "status": "pending",
        "comment": "les conditions de r\\u00e8glement pour ce prestataire est \\u00e0 30 jours date de facture",
        "created_at": "2018-03-07 08:51:18",
        "updated_at": "2018-03-07 08:51:18"
    },
    {
        "vendor_id": "7cdb151b-9a0d-4dca-972a-0eecffc9b42a",
        "outbound_invoice_id": "2be53613-38db-4a9a-ad74-c5f8a6a44165",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-06 11:24:12",
        "updated_at": "2018-03-07 21:27:19"
    },
    {
        "vendor_id": "043ddcf8-df70-45ef-8326-efe838572d1c",
        "outbound_invoice_id": "4019094d-ec1b-435c-b0e0-c0f40b090c42",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-08 15:47:14",
        "updated_at": "2018-03-08 15:47:14"
    },
    {
        "vendor_id": "d1c04728-37c6-49c7-864d-59ed2aa4eb78",
        "outbound_invoice_id": "e9727596-4e31-4589-b56b-aed906267c0f",
        "status": "validated",
        "comment": null,
        "created_at": "2018-03-06 11:19:07",
        "updated_at": "2018-03-07 21:06:59"
    },
    {
        "vendor_id": "913e3332-1c26-4f1f-8e02-9a8a47579b73",
        "outbound_invoice_id": "1a4e88f5-0de9-4e84-a097-7cbc907b1b76",
        "status": "pending",
        "comment": "Cette facture est \\u00e0 r\\u00e9gler  \\u00e0 30 jours et non \\u00e0 r\\u00e9ception",
        "created_at": "2018-03-08 15:48:28",
        "updated_at": "2018-03-08 15:48:28"
    }
]
EOF;
}
