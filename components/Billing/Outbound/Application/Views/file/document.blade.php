@inject('feeRepository', "Components\Billing\Outbound\Application\Repositories\FeeRepository")
@inject('vatRateRepository', "Components\Billing\Outbound\Application\Repositories\VatRateRepository")
@inject('outboundInvoiceFileRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceFileRepository")
@inject('enterpriseRepository', "Components\Billing\Outbound\Application\Repositories\EnterpriseRepository")
@inject('invoiceParameterRepository', "Components\Billing\Outbound\Application\Repositories\InvoiceParameterRepository")

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
            body {
                font-size: 12px;
            }

            .bg-bleu-addworking {
                background-color: #1da5cd;
            }

            .text-bleu-addworking {
                color: #1da5cd;
            }

            @page {
                margin: 120px 50px;
            }

            footer {
                position: fixed;
                bottom: -60px;
                height: 50px;
                font-size: 10px !important;
                margin-left: 20px;
            }

            header {
                position: fixed;
                top: -70px;
                height: 50px;
            }

            .page_break {
                page-break-before: always;
            }
        </style>
    </head>
    <body>
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(505, 755, "Page {PAGE_NUM} / {PAGE_COUNT}", null, 8);
            }
        </script>

        <header>
            @include('outbound_invoice::file._header')
        </header>

        <footer>
            @include('outbound_invoice::file._footer')
        </footer>

        <main>
            @include('outbound_invoice::file._enterprises')
            @include('outbound_invoice::file._lines')
            @include('outbound_invoice::file._summary')
            @include('outbound_invoice::file._legal_notice')

            @if(! empty($lines) || ! empty($linesAddhoc))
                <div class="page_break">
                    @include('outbound_invoice::file._annex')
                </div>
            @endif
        </main>
    </body>
</html>
