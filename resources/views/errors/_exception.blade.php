<textarea id="{{ $id = uniqid('error_') }}" class="clipboard form-control mb-4" data-clipboard-target="#{{ $id }}" title="Copier dans le presse-papier" data-toggle="tooltip" readonly rows="10" cols="55" style="font-family: monospace">{{--
    --}}@can('debug', user()){{--
        --}}{{ (string) $exception }}{{--
    --}}@else{{--
        --}}{{ base64_encode((string) $exception) }}{{--
    --}}@endcan{{--
--}}</textarea>
