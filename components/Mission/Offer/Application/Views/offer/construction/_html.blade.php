<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.customer'), 'class' => "col-md-6"])
                        <a href="{{ route('enterprise.show', $offer->getCustomer()) }}" target="_blank">{{ $offer->getCustomer()->name }}</a>
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.referent'), 'class' => "col-md-6"])
                        {{$offer->getReferent()->name}}
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.location'), 'class' => "col-md-6", 'icon' => "map-marker"])
                        @if (count($offer->getDepartments()) <= 10)
                            {{ implode(',', $departments) }}
                        @else
                            <a href="#" data-toggle="popover" data-placement="right" data-trigger="focus" title="Départements" data-content="{{ implode(', ', $departments) }}">
                                {{ count($offer->departments) }} {{ __('offer::offer.construction._html.departments') }}
                            </a>
                        @endif
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.status'), 'class' => "col-md-6", 'icon' => "info-circle"])
                        @include('offer::offer._status')
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.start_date'), 'class' => "col-md-6", 'icon' => "calendar-check"])
                        @date($offer->getStartsAtDesired())
                    @endcomponent
                    
                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.end_date'),'class' => "col-md-6", 'icon' => "calendar-times"])
                        @date($offer->getEndsAt())
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.response_deadline'), 'class' => "col-md-12", 'icon' => "info"])
                        @date($offer->getResponseDeadline())
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.description'), 'class' => "col-md-12", 'icon' => "info"])
                        {!! $offer->getDescriptionHtml() ?: 'n/a' !!}
                    @endcomponent
                </div>
            </div>
        </div>
        <div class="mt-4">
            <ul class="nav nav-tabs" role="tablist">
                @can('viewProtectedDatas', $offer)
                    <li class="nav-item">
                        <a class="nav-link active" id="nav-recipients-tab" data-toggle="tab" href="#nav-recipients" role="tab" aria-controls="nav-recipients" aria-selected="true">
                            {{__('offer::offer.construction._html.tabs.recipients')}} <span class="badge badge-pill badge-primary">{{ count($recipients) }}</span>
                        </a>
                    </li>
                @endcan
                @if(count($offer->getFiles()))
                    <li class="nav-item">
                        <a class="nav-link" id="nav-additional-documents-tab" data-toggle="tab" href="#nav-additional-documents" role="tab" aria-controls="nav-additional-documents" aria-selected="false">
                            {{__('offer::offer.construction._html.tabs.additional_documents')}} <span class="badge badge-pill badge-primary">{{ count($offer->getFiles()) }}</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                @can('viewProtectedDatas', $offer)
                    @if(count($recipients))
                        <div class="tab-pane fade show active" id="nav-recipients" role="tabpanel" aria-labelledby="nav-recipients-tab">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <ul class="list-group">
                                            @forelse($recipients as $recipient)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('enterprise.show', $recipient->getVendor()) }}" target="_blank">{{ $recipient->getVendor()->name }}</a>
                                                    <div class="d-flex justify-content-between">
                                                        @if($responseRepository->hasResponseFor($recipient->getVendor(), $offer))
                                                            <span class="badge badge-success badge-pill ml-3">{{ __('offer::offer.construction._html.have_response') }}</span>
                                                        @else
                                                            <span class="badge badge-primary badge-pill ml-3">{{ __('offer::offer.construction._html.waiting_response') }}</span>
                                                        @endif
                                                        <small class="ml-3">{{ __('offer::offer.construction._html.sended_at') }} @date($recipient->getCreatedAt())</small>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span class="text-center">{{__('offer::offer.construction._html.no_recipients')}}</span>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan
                @if(count($offer->getFiles()))
                    <div class="tab-pane fade show" id="nav-additional-documents" role="tabpanel" aria-labelledby="nav-additional-documents-tab">
                        <div class="card shadow">
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($offer->getFiles() as $file)
                                        <li class="list-group-item">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('file.download', $file) }}"><i class="fa fa-fw fa-download"></i></a>
                                            <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                                @icon('trash|mr-3')
                                            </a>
                                            <span class="ml-2">{{ $file->name ?? basename($file->path) }}</span><small class="text-muted ml-2">({{ human_filesize($file->size) }})</small>
                                        </li>
                                        @push('forms')
                                            <form name="{{ $name }}" action="{{ route('sector.offer.delete_file', [$offer, $file]) }}" method="POST">
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
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                @can('viewProtectedDatas', $offer)
                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.workfield'), 'class' => "col-md-12"])
                        <a href="{{ route('work_field.show', $offer->getWorkField()) }}" target="_blank">{{$offer->getWorkField()->getDisplayName()}}</a>
                    @endcomponent

                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.external_id'), 'class' => "col-md-12", 'icon' => "user"])
                        {{ $offer->getExternalId() ?: 'n/a' }}
                    @endcomponent
                    @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.analytical_code'), 'class' => "col-md-12", 'icon' => "info"])
                        {{ $offer->getAnalyticCode() ?: 'n/a' }}
                    @endcomponent
                @endcan

                @component('bootstrap::attribute', ['label' => __('offer::offer.construction._html.skills'), 'class' => "col-md-12", 'icon' => "user-tie"])
                    <ul>
                        @foreach($offer->getSkills() as $skill)
                            <li>{{$skill->display_name}}</li>
                        @endforeach
                    </ul>
                @endcomponent
            </div>
        </div>
    </div>
</div>
