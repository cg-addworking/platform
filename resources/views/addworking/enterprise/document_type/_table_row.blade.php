@php
    $documents = $document_type->documents()->ofEnterprise($vendor)->latest()->get();

    if (! $documents->count()) {
        $documents = document([])->newCollection([
            document([])->enterprise()->associate($vendor)->documentType()->associate($document_type)
        ]);
    }
@endphp

@foreach ($documents as $document)
    <tr>
        <td>{{ $document_type->views->summary }}</td>
        <td>@date($document->created_at)</td>
        <td>
            @date($document->valid_until)
            @if($document->expires_in !== 0 && $document->expires_in < 31)<br><span class="small text-success">Expire dans {{ $document->expires_in }} jour(s)</span>@endif
            @if($document->expired_since !== 0 && $document->expired_since < 30)<br><span class="small text-danger">Expiré depuis {{ $document->expired_since }} jour(s)</span>@endif
            @if(! is_null($document->valid_until) && $document->expired_since == 0 && $document->expires_in == 0)<br><span class="small text-success">Expire ce jour</span>@endif
        </td>
        <td>{{ $document->views->status }}</td>
        <td class="text-right">
            @can('create', [document(), $vendor, $document_type])
                @button(__('addworking.enterprise.document_type._table_row.add')."|icon:plus|sm|color:success|outline|href:{$document->routes->create}?document_type={$document_type->id}")
            @endcan

            @can('replace', $document)
                <a class="btn btn-outline-success btn-sm" href="{{ $document->routes->replace }}" onclick="return confirm('{{__('addworking.enterprise.document_type._table_row.replacement_of_document')}}')">
                    <i class="fa fa-redo"></i> {{ __('addworking.enterprise.document_type._table_row.replace') }}
                </a>
            @endcan

            @can('showHistory', $document)
                <a href="{{ route('addworking.enterprise.document.history', [$vendor, $document_type])}}" class="btn btn-outline-warning btn-sm"><i class="fa fa-history"></i></a>
            @endcan

            @can('download', $document)
                <a href="{{ $document->routes->download }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-download"></i></a>
            @endcan

            @can('show', $document)
                <a href="{{ $document->routes->show }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></a>
            @endcan
        </td>
    </tr>
@endforeach
