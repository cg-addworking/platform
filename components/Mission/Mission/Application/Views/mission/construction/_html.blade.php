<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.customer'), 'class' => "col-md-6"])
                        <a href="{{ route('enterprise.show', $mission->getCustomer()) }}" target="_blank">{{ $mission->getCustomer()->name }}</a>
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.referent'), 'class' => "col-md-6"])
                        {{ optional($mission->getReferent())->name ?? 'n/a' }}
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.vendor'), 'class' => "col-md-12"])
                        <a href="{{ route('enterprise.show', $mission->getVendor()) }}" target="_blank">{{ $mission->getVendor()->name }}</a>
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.location'), 'class' => "col-md-6", 'icon' => "map-marker"])
                        @if (count($departments) <= 10)
                            {{ implode(',', $departments) }}
                        @else
                            <a href="#" data-toggle="popover" data-placement="right" data-trigger="focus" title="Départements" data-content="{{ implode(', ', $departments) }}">
                                {{ count($departments) }} {{ __('mission::mission.construction._html.departments') }}
                            </a>
                        @endif
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.status'), 'class' => "col-md-6", 'icon' => "info-circle"])
                        @include('mission::mission._status')
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.start_date'), 'class' => "col-md-6", 'icon' => "calendar-check"])
                        @date($mission->getStartsAt())
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.end_date'),'class' => "col-md-6", 'icon' => "calendar-times"])
                        @date($mission->getEndsAt())
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.description'), 'class' => "col-md-12", 'icon' => "info"])
                        {!! $mission->getDescriptionHtml() ?: 'n/a' !!}
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.amount'), 'class' => "col", 'icon' => "info"])
                        @money($mission->getAmount())
                    @endcomponent

                    @if($mission->getCostEstimation())
                        @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.cost_estimation.amount_before_taxes'), 'class' => "col"])
                            {{ $mission->getCostEstimation()->getAmountBeforeTaxes() }}
                        @endcomponent
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-4">
            <ul class="nav nav-tabs" role="tablist">
                @if(count($mission->getFiles()))
                    <li class="nav-item">
                        <a class="nav-link active" id="nav-additional-documents-tab" data-toggle="tab" href="#nav-additional-documents" role="tab" aria-controls="nav-additional-documents" aria-selected="false">
                            {{__('mission::mission.construction._html.tabs.additional_documents')}} <span class="badge badge-pill badge-primary">{{ count($mission->getFiles()) }}</span>
                        </a>
                    </li>
                @endif
                @if($mission->getCostEstimation() && $mission->getCostEstimation()->getFile())
                    <li class="nav-item">
                        <a class="nav-link" id="nav-cost-estimation-documents-tab" data-toggle="tab" href="#nav-cost-estimation-documents" role="tab" aria-controls="nav-cost-estimation-documents" aria-selected="false">
                            {{__('mission::mission.construction._html.tabs.cost_estimation_document')}} <span class="badge badge-pill badge-primary">1</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                @if(count($mission->getFiles()))
                    <div class="tab-pane fade show active" id="nav-additional-documents" role="tabpanel" aria-labelledby="nav-additional-documents-tab">
                        <div class="card shadow">
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($mission->getFiles() as $file)
                                        <li class="list-group-item">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('file.download', $file) }}"><i class="fa fa-fw fa-download"></i></a>
                                            <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                                @icon('trash|mr-3')
                                            </a>
                                            <span class="ml-2">{{ $file->name ?? basename($file->path) }}</span><small class="text-muted ml-2">({{ human_filesize($file->size) }})</small>
                                        </li>
                                        @push('forms')
                                            <form name="{{ $name }}" action="{{ route('sector.mission.file.delete', [$mission, $file]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endpush
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if($mission->getCostEstimation() && $mission->getCostEstimation()->getFile())
                    <div class="tab-pane fade show" id="nav-cost-estimation-documents" role="tabpanel" aria-labelledby="nav-cost-estimation-documents-tab">
                        <div class="card shadow">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('file.download', $mission->getCostEstimation()->getFile()) }}"><i class="fa fa-fw fa-download"></i></a>
                                        <span class="ml-2">{{ $mission->getCostEstimation()->getFile()->name ?? basename($mission->getCostEstimation()->getFile()->path) }}</span><small class="text-muted ml-2">({{ human_filesize($mission->getCostEstimation()->getFile()->size) }})</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                @if($mission->getWorkField())
                    @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.workfield'), 'class' => "col-md-12"])
                        <a href="{{ route('work_field.show', $mission->getWorkField()) }}" target="_blank">{{$mission->getWorkField()->getDisplayName()}}</a>
                    @endcomponent
                @endif
                @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.external_id'), 'class' => "col-md-12", 'icon' => "user"])
                    {{ $mission->getExternalId() ?: 'n/a' }}
                @endcomponent
                @component('bootstrap::attribute', ['label' => __('mission::mission.construction._html.analytical_code'), 'class' => "col-md-12", 'icon' => "info"])
                    {{ $mission->getAnalyticCode() ?: 'n/a' }}
                @endcomponent
            </div>
        </div>
    </div>
</div>
