<div id="{{ $iban->id }}">
    <p>
        <b>Libellé:</b> {{ $iban->formatted_label }}<br>
        <b>IBAN:</b> {{ $iban->iban }}<br>
        <b>BIC:</b> {{ $iban->bic }}<br>
        @if($iban->iban_pending)
            <b>{{ __('addworking.enterprise.iban._html.status') }}:</b> @lang("messages.iban.status_{$iban->iban_pending}")
        @endif
    </p>
</div>
@if ($iban->file->exists)
    <a href="{{ route('file.download', $iban->file) }}" class="btn btn-default" title="{{ __('addworking.enterprise.iban._html.download') }}" data-toggle="tooltip">
        <i class="fa fa-download"></i> {{ __('addworking.enterprise.iban._html.download') }}
    </a>

    @if(auth()->user()->isSupport())
        {{ $iban->file->views->link }}
    @endif
@endif
