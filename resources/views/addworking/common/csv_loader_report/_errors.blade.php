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
            @foreach ($loader->getErrors() as $item)
                <tr @isset($errors[$item->name]) class="error" @endisset>
                    <td style="width: 50px" class="text-center">
                        @isset($errors[$item->name])
                            <a style="cursor: pointer" tabindex="0" role="button" data-toggle="popover" title="Erreur" data-content="<div style='max-heigh: 250px'>{{ nl2br($errors[$item->name]->getMessage()) }}</div>" data-html="true">@icon('times|color:danger')</a>
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
