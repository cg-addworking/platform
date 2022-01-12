@extends('foundation::layout.app.show')

@section('title', __('addworking.enterprise.document.index.document')." {$enterprise->name}")

@section('toolbar')
    @can('zip', $enterprise)
        @button(__('addworking.enterprise.document.index.download_validated_documents')."|icon:archive|color:primary|outline|sm|href:".route('addworking.enterprise.download_documents', @compact('enterprise')))
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.index.company')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.index.documents')."|active")
@endsection

@section('tabs')
    @foreach ($types as $name => $document_types)
        @if((auth()->user()->enterprise->isCustomer() && $name != "Documents Contractuels Spécifiques") 
            || (auth()->user()->enterprise->isVendor() && count($document_types)) 
            || auth()->user()->isSupport())
            <a class="nav-item nav-link @if ($loop->first) active @endif" id="nav-{{ remove_accents(kebab_case($name)) }}-tab" data-toggle="tab" href="#nav-{{ remove_accents(kebab_case($name)) }}" role="tab" aria-controls="nav-preview" aria-selected="true"> {{ __('addworking.enterprise.document.index.'.remove_accents(snake_case($name)))}}<span class="badge badge-pill badge-primary ml-2">{{ count($document_types) }}</span></a>
        @endif
    @endforeach
@endsection

@section('content')
    @foreach ($types as $name => $document_types)
        <div class="tab-pane fade @if ($loop->first) active show @endif" id="nav-{{ remove_accents(kebab_case($name)) }}" role="tabpanel" aria-labelledby="nav-{{ remove_accents(kebab_case($name)) }}-tab">
            <table class="table table-hover">
                <colgroup>
                    <col width="45%">
                    <col width="10%">
                    <col width="10%">
                    <col width="20%">
                    <col width="25%">
                </colgroup>

                <thead>
                    <th>{{ __('addworking.enterprise.document.index.document_name') }}</th>
                    <th>{{ __('addworking.enterprise.document.index.deposit_date') }}</th>
                    <th>{{ __('addworking.enterprise.document.index.expiration_date') }}</th>
                    <th>{{ __('addworking.enterprise.document.index.status') }}</th>
                    <th class="text-right">{{ __('addworking.enterprise.document.index.action') }}</th>
                </thead>

                <tbody>
                    <tr>
                        @if($name != "Documents Contractuels Spécifiques")
                            @forelse($document_types as $type)
                                @can('showDocumentInIndex', [document(), $type])
                                    {{ $type->views->table_row(['vendor' => $enterprise]) }}
                                @endcan
                            @empty
                                <td colspan="5" class="text-center" style="line-height: 5em">@icon('frown-open|color:muted') {{ __('addworking.enterprise.document.index.no_document') }}</td>
                            @endforelse
                        @else
                            @forelse($document_types as $contract_model_document_type)
                                @php
                                    $document = App\Models\Addworking\Enterprise\Document::whereHas('contractModelPartyDocumentType', function ($query) use ($contract_model_document_type) {
                                        return $query->where('id', $contract_model_document_type->id);
                                    })->whereHas('enterprise', function ($query) use ($enterprise) {
                                        return $query->where('id', $enterprise->id);
                                    })->latest()->first();

                                    if (is_null($document)) {
                                        $document = document([])->enterprise()->associate($enterprise);
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        {{ $contract_model_document_type->display_name }} 
                                        @if(! is_null($contract_model_document_type->getDocumentModel()))
                                            @can('download', $contract_model_document_type->getDocumentModel())<a href="{{ $contract_model_document_type->getDocumentModel()->routes->download }}">({{ __('addworking.enterprise.document_type._summary.download_model') }})</a>@endcan
                                        @endif<br>
                                        <small class="text-muted"> {{__('addworking.enterprise.document.index.documents')}} {{ __("addworking.enterprise.document_type._summary.contractual")}}</small><br>
                                        <small class="text-muted">{{ $contract_model_document_type->description }}</small><br>
                                        @if($document->contract()->count())
                                            <small class="text-muted">{{__('addworking.enterprise.document.index.contract')}} <a href="{{route('contract.show', $document->contract()->first())}}" target="_blank"> {{ $document->contract()->first()->getName() }} ({{ $document->contract()->first()->getEnterprise()->name }})</a></small>
                                        @endif
                                    </td>
                                    <td>@date($document->created_at)</td>
                                    <td>@date($document->valid_until) @if(! is_null($document->expire_in) && $document->expire_in > 0 && $document->expire_in < 31)<br><span class="small text-danger">{{ __('addworking.enterprise.document.index.expire_in', ['days' => $document->expire_in])}}</span>@endif</td>
                                    <td>@include('addworking.enterprise.document._status', ['document' => $document])</td>
                                    <td class="text-right">
                                        @can('show', $document)
                                            <a target="_blank" href="{{ $document->routes->show }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <td colspan="5" class="text-center" style="line-height: 5em">@icon('frown-open|color:muted') {{ __('addworking.enterprise.document.index.no_document') }}</td>
                            @endforelse
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
