@php
    $enterprise = $contract_party->getEnterprise();
@endphp
@foreach($items as $contract_model_document_type)
    @if ($contract_model_document_type->getDocumentType())
        @php
            $document_type = $contract_model_document_type->getDocumentType();
            $documents = $document_type->documents()->ofEnterprise($enterprise)->latest()->get();
            if (! $documents->count()) {
                $documents = document([])->newCollection([
                    document([])->enterprise()->associate($enterprise)->documentType()->associate($document_type)
                ]);
            }
        @endphp
        @if($enterprise->legalForm()->first() !== null)
            @if(in_array(
                $enterprise->legalForm()->first()->id,
                $document_type->legalForms()->get()->pluck('id')->toArray()
            ))
                @foreach ($documents as $document)
                    <tr>
                        <td>
                            {{ $document_type->display_name }} @can('download', $document_type->file)<a href="{{ $document_type->file->routes->download }}">({{ __('addworking.enterprise.document_type._summary.download_model') }})</a>@endcan<br>
                            <small class="text-muted">Document {{__("addworking.enterprise.document_type._summary.{$document_type->type}")}}</small><br>
                            <small class="text-muted">{{ $document_type->description }}</small>
                        </td>
                        <td>@date(isset($document) ? $document->created_at : '')</td>
                        <td>@date(isset($document) ? $document->valid_until : '')</td>
                        <td class="text-center">@include('addworking.enterprise.document._status', ['document' => $document])</td>
                        <td class="text-right">
                            @can('create', [document(), $enterprise, $document_type])
                                @button(__('addworking.enterprise.document_type._table_row.add')."|icon:plus|sm|color:success|outline|href:{$document->routes->create}?document_type={$document_type->id}&contract_party={$contract_party->getId()}")
                            @endif
                            @can('replace', $document)
                                <a class="btn btn-outline-success btn-sm" href="{{$document->routes->replace}}?contract_party={{$contract_party->getId()}}" onclick="return confirm('Confirmer le remplacement du document ?')">
                                    <i class="fa fa-redo"></i> {{ __('addworking.enterprise.document_type._table_row.replace') }}
                                </a>
                            @endif
                            @can('download', $document)
                                <a href="{{ $document->routes->download }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-download"></i></a>
                            @endcan
                            @can('show', $document)
                                <a target="_blank" href="{{ $document->routes->show }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @endif
        @endif
    @else
        @php
            $document = App\Models\Addworking\Enterprise\Document::whereHas('contractModelPartyDocumentType', function ($query) use ($contract_model_document_type) {
                return $query->where('id', $contract_model_document_type->id);
            })->whereHas('contract', function ($query) use ($contract) {
                return $query->where('id', $contract->getId()); 
            })->whereHas('enterprise', function ($query) use ($enterprise) {
                return $query->where('id', $enterprise->id);
            })->latest()->first();
        @endphp
        <tr>
            <td>
                {{ $contract_model_document_type->display_name }} 
                @if(! is_null($contract_model_document_type->getDocumentModel()))
                    @can('download', $contract_model_document_type->getDocumentModel()->file)<a href="{{ $contract_model_document_type->getDocumentModel()->file->routes->download }}">({{ __('addworking.enterprise.document_type._summary.download_model') }})</a>@endcan
                @endif<br>
                <small class="text-muted">Document {{__("addworking.enterprise.document_type._summary.contractual")}}</small><br>
                <small class="text-muted">{{ $contract_model_document_type->description }}</small>
            </td>
            <td>@date(isset($document) ? $document->created_at : '')</td>
            <td>@date(isset($document) ? $document->valid_until : '')</td>
            <td class="text-center">@include('addworking.enterprise.document._status', ['document' => $document])</td>
            <td class="text-right">
                @can('createSpecificDocument', [get_class($contract), $enterprise, $document])
                    <a target="_blank" href="{{ route('contract.party.document.create_without_document_type', ['contract' => $contract->getId(), 'enterprise' => $enterprise->id ]).'?contract_model_document_type='.$contract_model_document_type->id }}" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></a>
                @endcan
                @can('replace', $document)
                    <a class="btn btn-outline-success btn-sm" href="{{$document->routes->replace}}?contract={{$contract->getId()}}&contract_model_document_type={{$contract_model_document_type->id}}" onclick="return confirm('Confirmer le remplacement du document ?')">
                        <i class="fa fa-redo"></i>
                    </a>
                @endif
                @can('download', $document)
                    <a href="{{ $document->routes->download }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-download"></i></a>
                @endcan
                @can('show', $document)
                    <a target="_blank" href="{{ $document->routes->show }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></a>
                @endcan
            </td>
        </tr>
    @endif
@endforeach