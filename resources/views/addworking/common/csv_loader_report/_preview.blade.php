@php
    $loader = $csv_loader_report->loader;
    $errors = [];

    foreach ($loader->getErrors() as $key => $item) {
        $errors[$key] = $loader->getError($item);
    }
@endphp

<div class="table-responsive">
    <table class="table table-lg csv-report">
        <thead>
            <tr>
                <th style="width: 50px" class="text-center border-top-0"></th>
                @foreach ($loader->headers() as $header)
                    <th class="border-top-0">{{ str_replace('_', ' ', title_case($header)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="max-height: 250px">
            @foreach ($loader->cursor() as $key => $item)
                <tr @isset($errors[$key]) class="error" @endisset>
                    <td style="width: 50px" class="text-center">
                        @isset($errors[$key])
                            <a style="cursor: pointer" tabindex="0" role="button" data-toggle="popover" title="Erreur" data-content="<div style='max-heigh: 250px'>{{ nl2br($errors[$key]->getMessage()) }}</div>" data-html="true">@icon('times|color:danger')</a>
                        @endisset
                    </td>
                    @foreach ($item as $key => $value)
                        <td title="{{ $value }}">{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('stylesheets')
    <style type="text/css">
        .table-lg {
            table-layout: fixed;
        }

        .table-lg th, .table-lg td {
            width: 200px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .csv-report .error {
            background: rgb(220,53,69,.1);
            color: rgb(220,53,69);
        }

        .csv-report .error td {
            border-top: 1px solid rgb(220,53,69) !important;
            border-bottom: 1px solid rgb(220,53,69) !important;
        }
    </style>
@endpush
