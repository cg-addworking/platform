<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.vendor')])
                            <a href="{{ route('enterprise.show', $response->getEnterprise()) }}" target="_blank">{{$response->getEnterprise()->name}}</a>
                        @endcomponent
                    </div>

                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.offer')])
                            <a href="{{ route('sector.offer.show', $response->getOffer()) }}" target="_blank">{{$response->getOffer()->getLabel()}}</a>
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.status')])
                           @include('offer::response._status', $response)
                        @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.amount_before_taxes')])
                            <div>@money($response->getAmountBeforeTaxes())</div>
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.starts_at'),'icon' => "calendar-check"])
                            @date($response->getStartsAt())
                        @endcomponent
                    </div>
                     <div class="col-md-6">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.ends_at'),'icon' => "calendar-check"])
                            @date($response->getEndsAt())
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.argument'), 'icon' => "info"])
                            @if(strlen($response->getArgument()) > 255)
                                <div class="truncated">
                            @endif
                                {{ $response->getArgument() }}
                            @if(strlen($response->getArgument()) > 255)
                                </div>
                                <a href="#" class="readMore">{{ __('addworking.mission.proposal.show.read_more') }}</a>
                            @endif
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
       <div class="card shadow mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @component('bootstrap::attribute', ['label' => __('offer::response.construction._html.file'), 'class' => "col-md-12", 'icon' => "info"])
                            {{ $response->getFile()->views->iframe(['ratio' => '1by1'])}}
                        @endcomponent
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                @include('addworking.common.comment._create', ['item' => $response, 'position' => 'center'])
                {{ $response->comments }}
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