<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' =>__('work_field::workfield._html.enterprise_owner')])
                            <a href="{{ route('enterprise.show', $data['enterprise_owner_id']) }}">{{ $data['enterprise_owner'] }}</a>
                        @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' =>__('work_field::workfield._html.created_by')])
                            {{-- temporary for the api (workfield creation by api) --}}
                            @if(is_null($data['created_by_id']))
                                {{ $data['created_by'] }}
                            @else
                                <a href="{{ route('user.show', $data['created_by_id']) }}">{{ $data['created_by'] }}</a>
                            @endif
                        @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.estimated_budget')])
                            <div>@money($data['estimated_budget'])</div>
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.started_at')])
                            <div>@date($data['started_at'])</div>
                        @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.ended_at')])
                            <div>@date($data['ended_at'])</div>
                        @endcomponent
                    </div>
                    @if(!is_null($data['archived_at']))
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.state')])
                                <span class="badge rounded-pill bg-warning text-dark">{{ __('work_field::workfield._table_row.archive') }}</span>
                            @endcomponent
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.departments'), 'icon' => "map-marker"])
                            @if (count($data['departments']) <= 10 && count($data['departments']) > 0)
                                {{ implode(', ', $data['departments']) }}
                            @endif
                        @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.address'), 'icon' => "map-marker"])
                            {{$data['address'] ?? 'n/a'}}
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.project_manager'), 'icon' => "user"])
                            {{$data['project_manager'] ?? 'n/a'}}
                        @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.project_owner'), 'icon' => "user"])
                            {{$data['project_owner'] ?? 'n/a'}}
                        @endcomponent
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.sps_coordinator'), 'icon' => "user-shield"])
                            {{$data['sps_coordinator'] ?? 'n/a'}}
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.description')])
                            @if($data['description'])
                                @if(strlen($data['description']) > 255)
                                    <div class="truncated">
                                @endif
                                    {!! $data['description'] !!}
                                @if(strlen($data['description']) > 255)
                                    </div>
                                    <a href="#" class="readMore">{{ __('addworking.mission.proposal.show.read_more') }}</a>
                                @endif
                            @else
                                <small class="text-secondary">n/a</small>
                            @endif
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.contributors')])
                            <ul>
                                @foreach($data['contributors'] as $contributor)
                                    <li style="list-style-type: none;">
                                        <a href="{{ route('user.show', $contributor['contributor_user_id']) }}">{{ $contributor['contributor_user'] }}</a> ({{ $contributor['contributor_enterprise'] }})
                                        @if(! is_null($contributor['contributor_role'])) <span> - {{__('work_field::workfield.manage.roles.' . $contributor['contributor_role'])}}</span>
                                        @endif
                                        @if($contributor['contributor_is_admin'] == true) <span> - <b>{{__('work_field::workfield._html.contributors_is_admin')}}</b></span>
                                        @endif
                                     </li>
                                @endforeach
                            </ul>
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.offers')])
                            <ul>
                                @forelse($data['offers'] as $offer)
                                    <li style="list-style-type: none;">
                                        <a href="{{ route('sector.offer.show', $offer['offer_id']) }}" target="_blank">{{ $offer['offer_label'] }}</a>
                                    </li>
                                @empty
                                    n/a
                                @endforelse
                            </ul>
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.created_date')])
                            <div>@date($data['created_at'])</div>
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('work_field::workfield._html.last_modified_date')])
                            <div>@date($data['updated_at'])</div>
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
            var charLimit = 255;

        function truncate(el) {
            var text = el.html();
            el.attr("data-originalText", text);
            el.html(text.substring(0, charLimit) + "...");
        }

        function reveal(el) {
            el.html(el.attr("data-originalText"));
        }

        $(".truncated").each(function() {
            truncate($(this));
        });

        $("a.readMore").on("click", function(e) {
            e.preventDefault();
            if ($(this).text() === "Voir plus") {
                $(this).text("Masquer");
                reveal($(this).prev());
            } else {
                $(this).text("Voir plus");
                truncate($(this).prev());
            }
        });
    </script>
@endpush
