@inject('contractModelDocumentTypeRepository', "Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository")
@inject('contractModelDocumentTypeRepository', "Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository")
@inject('contractRepository', "Components\Contract\Contract\Application\Repositories\ContractRepository")
@inject('userRepository', "Components\Contract\Contract\Application\Repositories\UserRepository")

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.owner')])
                            <div class="ml-3">{{ $contract->getEnterprise()->views->link }}</div>
                        @endcomponent    
                    </div>
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.contract_dates')])
                            <div class="ml-3">
                                {{__('components.contract.contract.application.views.contract._html.from')}} @date($contract->getValidFrom())
                                @if (in_array($contract->getState(), [
                                            $contract::STATE_DUE,
                                            $contract::STATE_ACTIVE,
                                            $contract::STATE_SIGNED,
                                        ])
                                        && $contractRepository->getValidUntilDate($contract) != $contract->getValidUntil())
                                    {{__('components.contract.contract.application.views.contract._html.to')}} @date($contractRepository->getValidUntilDate($contract))
                                    ({{__('components.contract.contract.application.views.contract._html.valid_until_date')}} @date($contract->getValidUntil()))
                                @else
                                    {{__('components.contract.contract.application.views.contract._html.to')}} @date($contract->getValidUntil())
                                @endif
                            </div>
                        @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.state')])
                            <div class="ml-3">@include('contract::contract._state')</div>
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    @if(auth()->user()->isSupport() && $contractRepository->hasContractModel($contract))
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.contract_model')])
                                <div class="ml-3"><a href="{{route('support.contract.model.show', $contract->getContractModel())}}">{{$contract->getContractModel()->getDisplayName()}}</a></div>
                            @endcomponent
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.parties')])
                            <ul>
                                @if ($contract_parties)
                                    @forelse($contract_parties->sortBy('order') as $contract_party)
                                        <li>
                                            @if($contract_party->getSignatory())
                                                <b>{{ $contract_party->signatory()->first()->name }}</b>
                                            @else
                                                n/a
                                            @endif
                                            @if($contract_party->getEnterprise())
                                                pour <b><a href="{{ route('enterprise.show', $contract_party->getEnterprise()) }}">{{$contract_party->getEnterprise()->name}}</a></b>
                                            @endif
                                            @if (!is_null($contract_party->getSignedAt()))
                                                <br>
                                                <strong>{{__('components.contract.contract.application.views.contract._html.signed_at')}} </strong> @date($contract_party->getSignedAt())
                                            @endif
                                        </li>
                                    @empty
                                        <li>n/a</li>
                                    @endforelse
                                @endif
                            </ul>
                        @endcomponent
                    </div>
                </div>
                @if (count($validator_parties))
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.validator_parties')])
                            <ul>
                                    @forelse($validator_parties->sortBy('order') as $validator_party)
                                        <li>
                                            @if($validator_party->getSignatory())
                                                <b>{{ $validator_party->signatory()->first()->name }}</b>
                                            @else
                                                n/a
                                            @endif
                                            @if (!is_null($validator_party->getValidatedAt()))
                                                {{__('components.contract.contract.application.views.contract._html.validated_at')}}
                                                {{$validator_party->getValidatedAt()->format('d/m/Y H:m')}}
                                            @endif
                                        </li>
                                    @empty
                                        <li>n/a</li>
                                    @endforelse
                            </ul>
                        @endcomponent
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        @if(!$contract->getAmendments()->isEmpty())
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.amendment_contracts')])
                                <ul>
                                    @foreach($contract->getAmendments() as $contract_amendment)
                                        <li>
                                            <a href="{{route('contract.show', $contract_amendment)}}">{{$contract_amendment->getName()}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endcomponent
                        @endif
                        @if($contractRepository->isAmendment($contract))
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.parent_contract')])
                                <div class="ml-3">
                                    <a href="{{route('contract.show', $contract->getParent())}}">{{$contract->getParent()->getName()}}</a>
                                </div>
                            @endcomponent
                        @endif
                    </div>
                    @if ($contract->getMission())
                    <div class="col-md-12">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.mission')])
                                <a href="{{! is_null($contract->getMission()->getReferent()) ? route('sector.mission.show', $contract->getMission()) : route('mission.show', $contract->getMission())}}"
                                    target="_blank">{{ $contract->getMission()->label }}</a>
                            @endcomponent
                    </div>
                    @endif
                </div>
                @if ($contract->getWorkfield())
                    @can('show', $contract->getWorkfield())
                    <div class="row">
                        <div class="col-md-12">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.workfield')])
                                <a href="{{route('work_field.show', $contract->getWorkfield())}}">{{$contract->getWorkfield()->getDisplayName()}}</a>
                            @endcomponent
                        </div>
                    </div>
                    @endcan
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if($contract->getExternalIdentifier())
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.external_identifier')])
                                <div class="ml-3">{{ $contract->getExternalIdentifier() }}</div>
                            @endcomponent
                        @endif
                    </div>
                </div>
                <div class="row">
                    @support
                        <div class="col-md-6">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.created_at')])
                                <div class="ml-3">@date($contract->created_at)</div>
                            @endcomponent
                        </div>
                        <div class="col-md-6">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.contract._html.updated_at')])
                                <div class="ml-3">@date($contract->updated_at)</div>
                            @endcomponent
                        </div>
                    @endsupport
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="mt-4 col-md-8">

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="contract-part-tab" data-toggle="tab" href="#contract-part" role="tab" aria-controls="contract-part" aria-selected="true">
                    {{__('components.contract.contract.application.views.contract._html.parts')}} {{'('.$contract_parts->count().')'}}
                </a>
            </li>
            @if(count($compliance_documents))
                <li class="nav-item">
                    <a class="nav-link" id="compliance-documents-tab" data-toggle="tab" href="#compliance-documents" role="tab" aria-controls="compliance-documents" aria-selected="true">
                        {{__('components.contract.contract.application.views.contract._html.compliance_documents')}}
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" id="non-body-contract-part-tab" data-toggle="tab" href="#non-body-contract-part" role="tab" aria-controls="non-body-contract-part" aria-selected="false">
                    {{__('components.contract.contract.application.views.contract._html.non_body_contract_parts')}}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="contract-part" role="tabpanel" aria-labelledby="contract-part-tab">
                <div class="card shadow">
                    <div class="card-body">
                        @if(!$contract_parts->isEmpty())
                            <div id="accordion">
                                @foreach ($contract_parts->sortBy('order') as $part)
                                    <div class="card">
                                        <div class="card-header" id="heading-{{$loop->iteration}}">
                                            @can('delete', $part)
                                                <div class="float-right">
                                                    <a class="dropdown-item btn btn-link" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                                        @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.contract.application.views.contract_part._actions.delete') }}</span>
                                                    </a>
                                                    @push('forms')
                                                        <form name="{{ $name }}" action="{{ route('contract.part.delete', [$part->getContract(), $part]) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    @endpush
                                                </div>
                                            @endcan
                                            <h5 class="mb-0">
                                                @can('orderParts', $contract)
                                                    @can('orderUp', $part)
                                                        <a href="#" onclick="document.forms['{{ $name = uniqid('form_') }}'].submit()">@icon('caret-up|color:primary')</a>
                                                        @push('forms')
                                                            <form name="{{ $name }}" action="{{ route('contract.part.order', [$part->getContract(), $part]) }}" method="POST">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="direction" value="up">
                                                            </form>
                                                        @endpush
                                                    @else
                                                        <i class="fas fa-fw fa-caret-up"></i>
                                                    @endcan
                                                    <span class="badge">{{$loop->iteration}}</span>
                                                    @can('orderDown', $part)
                                                        <a href="#" onclick="document.forms['{{ $name = uniqid('form_') }}'].submit()">@icon('caret-down|color:primary')</a>
                                                        @push('forms')
                                                            <form name="{{ $name }}" action="{{ route('contract.part.order', [$part->getContract(), $part]) }}" method="POST">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="direction" value="down">
                                                            </form>
                                                        @endpush
                                                    @else
                                                        <i class="fas fa-fw fa-caret-down"></i>
                                                    @endcan
                                                @endcan
                                                <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#collapse-{{$loop->iteration}}"
                                                        aria-expanded="{{ ($loop->first) ? 'true' : 'false' }}"
                                                        aria-controls="collapse-{{$loop->iteration}}">
                                                    {{ $part->getDisplayName() }}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse-{{$loop->iteration}}" class="collapse {{ ($loop->first || ($loop->last && $contractRepository->checkIfStateIsSigned($contract))) ? 'show' : '' }}"
                                             aria-labelledby="heading-{{$loop->iteration}}" data-parent="#accordion">
                                            <div class="card-body">
                                                {{$part->getFile()->views->iframe(['ratio' => '1by1'])}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="compliance-documents" role="tabpanel" aria-labelledby="compliance-documents-tab">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover">
                            <colgroup>
                                <col width="40%">
                                <col width="30%">
                                <col width="10%">
                                <col width="20%">
                            </colgroup>

                            <thead>
                                <th>{{ __('addworking.enterprise.document.index.document_name') }}</th>
                                <th>{{ __('addworking.enterprise.document.index.enterprise_name') }}</th>
                                <th class="text-center">{{ __('addworking.enterprise.document.index.status') }}</th>
                                <th class="text-right">Actions</th>
                            </thead>

                            <tbody>
                                @foreach($compliance_documents as $key => $contract_model_document_types)
                                    @php
                                        $enterprise = App\Models\Addworking\Enterprise\Enterprise::find($key);
                                    @endphp
                                    @foreach($contract_model_document_types as $contract_model_document_type)
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
                                                            <td>{{$enterprise->name}}</td>
                                                            <td class="text-center">{{ $document->views->status }}</td>
                                                            <td class="text-right">
                                                                @can('create', [document(), $enterprise, $document_type])
                                                                    <a target="_blank" href="{{ $document->routes->create.'?document_type='.$document_type->id.'&contract='.$contract->getId() }}" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></a>
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
                                                        @can('download', $contract_model_document_type->getDocumentModel())<a href="{{ $contract_model_document_type->getDocumentModel()->routes->download }}">({{ __('addworking.enterprise.document_type._summary.download_model') }})</a>@endcan
                                                    @endif<br>
                                                    <small class="text-muted">Document {{__("addworking.enterprise.document_type._summary.contractual")}}</small><br>
                                                    <small class="text-muted">{{ $contract_model_document_type->description }}</small>
                                                </td>
                                                <td>{{$enterprise->name}}</td>
                                                <td class="text-center">@include('addworking.enterprise.document._status', ['document' => $document])</td>
                                                <td class="text-right">
                                                    @can('createSpecificDocument', [get_class($contract), $enterprise, $document])
                                                        <a target="_blank" href="{{ route('contract.party.document.create_without_document_type', ['contract' => $contract->getId(), 'enterprise' => $enterprise->id ]).'?contract_model_document_type='.$contract_model_document_type->id }}" class="btn btn-outline-success btn-sm"><i class="fa fa-plus"></i></a>
                                                    @endcan
                                                    @can('show', $document)
                                                        <a target="_blank" href="{{ $document->routes->show }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                                    @endcan
                                                    @can('replace', $document)
                                                        <a class="btn btn-outline-success btn-sm" href="{{$document->routes->replace}}?contract={{$contract->getId()}}&contract_model_document_type={{$contract_model_document_type->id}}" onclick="return confirm('Confirmer le remplacement du document ?')">
                                                            <i class="fa fa-redo"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="non-body-contract-part" role="tabpanel" aria-labelledby="non-body-contract-part-tab">
                <div class="card shadow">
                    <div class="card-body">
                        @if(!$non_body_contract_parts->isEmpty())
                            <div id="accordion">
                                @foreach ($non_body_contract_parts as $part)
                                    <div class="card">
                                        <div class="card-header" id="heading-{{$loop->iteration}}">
                                            @can('delete', $part)
                                                <div class="float-right">
                                                    <a class="dropdown-item btn btn-link" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                                        @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.contract.application.views.contract_part._actions.delete') }}</span>
                                                    </a>
                                                    @push('forms')
                                                        <form name="{{ $name }}" action="{{ route('contract.part.delete', [$part->getContract(), $part]) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    @endpush
                                                </div>
                                            @endcan
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#collapse-{{$loop->iteration}}"
                                                        aria-expanded="{{ ($loop->first) ? 'true' : 'false' }}"
                                                        aria-controls="collapse-{{$loop->iteration}}">
                                                    {{ $part->getDisplayName() }}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse-{{$loop->iteration}}" class="collapse {{ ($loop->first || ($loop->last && $contractRepository->checkIfStateIsSigned($contract))) ? 'show' : '' }}"
                                             aria-labelledby="heading-{{$loop->iteration}}" data-parent="#accordion">
                                            <div class="card-body">
                                                {{$part->getFile()->views->iframe(['ratio' => '1by1'])}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>{{__('components.contract.contract.application.views.contract._html.non_body_contract_parts_empty')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-4">
        <div class="card shadow">
            <div class="card-body">
                @include('addworking.common.comment._create', ['item' => $contract, 'position' => 'center'])
                {{$contract->comments}}
            </div>
        </div>
        @if(!$contract->actions->isEmpty())
            <div class="card shadow mt-2">
                <div class="card-body">
                    @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.tracking.tracking'), 'icon' => "users"])
                        <ul>
                            @foreach($contract->actions->sortByDesc('created_at') as $action)
                                @if(is_null($action->getUser()) || (!is_null($action->getUser()) && $userRepository->isSupport($action->getUser())))
                                    <li>{{ $action->getCreatedAt()->format('d/m/Y') }} - {{__('components.contract.contract.application.tracking.addworking')}} {{ $action->getMessage() }}</li>
                                @else
                                    <li>{{ $action->getCreatedAt()->format('d/m/Y') }} - {{ $action->getUser()->name }} {{ $action->getMessage() }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endcomponent
                </div>
            </div>
        @endif
        @if(!$document_actions->isEmpty())
            <div class="card shadow mt-2" id="accordionTracking">
                <div class="card-body" id="headingTrackingTwo">
                    <label class="font-weight-bold text-primary border-bottom d-block" data-toggle="collapse" data-target="#collapseTrackingTwo" aria-expanded="false" aria-controls="collapseOne" style="cursor: pointer">
                        <span style="opacity: .4"><i class="fas fa-fw fa-users text-primary"></i></span>
                        {{ __('components.contract.contract.application.tracking.tracking_document') }}
                        <span style="float: right; opacity: .4"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
                    </label>
                </div>
                <div id="collapseTrackingTwo" class="collapse" aria-labelledby="headingTrackingTwo" data-parent="#accordionTracking">
                    <div class="card-body pt-0">
                        <ul>
                            @foreach($document_actions->sortByDesc('created_at') as $action)
                                <li>{{ $action->getCreatedAt()->format('d/m/Y') }} - {{ $action->getMessage() }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
