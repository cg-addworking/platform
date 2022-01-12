@inject('documentRepository', "App\Repositories\Addworking\Enterprise\DocumentRepository")

<div class="card shadow">
    <div class="card-body">
        @component('bootstrap::attribute', ['icon' => "calendar", 'label' => __('addworking.enterprise.document._html.created_the')])
            @date($document->created_at)
        @endcomponent

        @if($document->isValidated())
            @component('bootstrap::attribute', ['icon' => "calendar", 'color' => "success", 'label' => __('addworking.enterprise.document._html.valid')])
                @date($document->accepted_at) @support {{ __('addworking.enterprise.document._html.by') }} {{ $document->acceptedBy->views->link }} @endsupport.
            @endcomponent
        @endif

        @if($document->isRejected())
            @component('bootstrap::attribute', ['icon' => "calendar", 'color' => "danger", 'label' => __('addworking.enterprise.document._html.reject_on')])
                @date($document->rejected_at) @support {{ __('addworking.enterprise.document._html.by') }} {{ $document->rejectedBy->views->link }} @endsupport. {{ __('addworking.enterprise.document._html.pattern') }} : {{ $documentRepository->getDocumentRejectReasonText($document->reason_for_rejection) ?? 'n/a' }}
            @endcomponent
        @endif

        @if(! is_null($document->signed_at))
            @component('bootstrap::attribute', ['icon' => "calendar", 'color' => "success", 'label' => __('addworking.enterprise.document._html.signed_at')])
                @date($document->signed_at) {{ __('addworking.enterprise.document._html.by') }} {{ $document->getSignatoryName() }}.
            @endcomponent
        @endif

        @component('bootstrap::attribute', [
                    'icon' => "calendar",
                    'label' => __('addworking.enterprise.document._html.publish_date'),
                    'class' => 'editable-show-attribute',
                    'id' => 'valid_from_attribute_container',
                    ])
            @date($document->valid_from) @support @icon('edit|mr:3|color:muted') @endsupport
            <br>
            <span class='edit_date_error_message' style="color: red; display: none"></span>
            @endcomponent
            <input name="document[valid_from]"
               type="date"
               value="{{optional($document->valid_from)->format('Y-m-d')}}"
               class="form-control shadow-sm editable-show-attribute-input"
               attribute-name-container-id="valid_from_attribute_container"
               style="display: none"
        >

        @component('bootstrap::attribute', [
                    'icon' => "calendar",
                    'label' => __('addworking.enterprise.document._html.expiration_date'),
                    'class' => 'editable-show-attribute',
                    'id' => 'valid_until_attribute_container',
                    ])
            @date($document->valid_until) @support @icon('edit|mr:3|color:muted') @endsupport
            <br>
            <span class='edit_date_error_message' style="color: red; display: none"></span>
            @endcomponent
            <input name="document[valid_until]"
               type="date"
               value="{{optional($document->valid_until)->format('Y-m-d')}}"
               class="form-control shadow-sm editable-show-attribute-input"
               attribute-name-container-id="valid_until_attribute_container"
               style="display: none"
        >

        @if($document->fields->count() > 0)
            @foreach($document->fields as $field)
                @component('bootstrap::attribute', ['icon' => "plus", 'label' => $field->display_name])
                    {{ $field->pivot->content }}
                @endcomponent
            @endforeach
        @endif

        @support
            @component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.enterprise.document._html.document_owner')])
                 <p><a href="{{route('enterprise.show', $document->getEnterprise())}}">{{ $document->getEnterprise()->legalForm->display_name }} - {{$document->getEnterprise()->name }}</a></p>
                 <p>SIRET: {{ $document->getEnterprise()->identification_number }} </p>
                 <p> {{__('addworking.enterprise.document._html.registration_town')}}:
                    @if (! is_null($document->getEnterprise()->registration_town))
                        {{ $document->getEnterprise()->registration_town }}
                    @else
                        n/a
                    @endif
                </p>
                 <p><a href="https://www.societe.com/cgi-bin/search?champs={{ $document->getEnterprise()->siren }}" target="_blank">Société.com</a></p>
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.enterprise.document._html.legal_representative')])
                <ul>
                    @forelse($document->getEnterprise()->legalRepresentatives()->get() as $legal_representative)
                        <li>{{ $legal_representative->name }}
                            @if(! is_null($legal_representative->getJobTitleFor($document->getEnterprise())))
                                {{', '.$legal_representative->getJobTitleFor($document->getEnterprise())}}
                            @endif
                        </li>
                    @empty
                        n/a
                    @endforelse
                </ul>
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "map-marker-alt", 'label' => __('addworking.enterprise.document._html.address')])
                {{ $document->getEnterprise()->views->addresses }}
            @endcomponent

            @attribute(($document->getEnterprise()->main_activity_code ?? 'n/a')."|icon:cog|label:Code APE")

            @component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.enterprise.document._html.customer_attached')])
                <ul>
                    @forelse($document->getEnterprise()->customers()->get() as $customer)
                        <li>{{ $customer->name }}</li>
                    @empty
                        n/a
                    @endforelse
                </ul>
            @endcomponent
        @endsupport
    </div>
</div>

<div class="card shadow mt-2">
    <div class="card-body">
        @include('addworking.common.comment._create', ['item' => $document, 'position' => 'center'])
        {{ $document->comments }}
    </div>
</div>

@support
    @if(!$document->actions->isEmpty())
        <div class="card shadow mt-2" id="accordionTracking">
            <div class="card-body" id="headingTrackingTwo">
                <label class="font-weight-bold text-primary border-bottom d-block" data-toggle="collapse" data-target="#collapseTrackingTwo" aria-expanded="false" aria-controls="collapseOne" style="cursor: pointer">
                    <span style="opacity: .4"><i class="fas fa-fw fa-users text-primary"></i></span>
                    {{ __('addworking.enterprise.document._html.tracking_document') }}
                    <span style="float: right; opacity: .4"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
                </label>
            </div>
            <div id="collapseTrackingTwo" class="collapse" aria-labelledby="headingTrackingTwo" data-parent="#accordionTracking">
                <div class="card-body pt-0">
                    <ul>
                        @foreach($document->actions->sortByDesc('created_at') as $action)
                            <li>{{ $action->getCreatedAt()->format('d/m/Y') }} - {!! $action->getMessage() !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsupport

@support
    @push('scripts')
        <script>
            $(function () {
                $('.editable-show-attribute').click(function () {
                    var displayed_value_html_tag = $(this).find('p');
                    displayed_value_html_tag.hide();
                    var input = $("input[attribute-name-container-id='"+$(this).attr('id')+"']").first();
                    input.show();
                    input.trigger('focus');
                });

                $('.editable-show-attribute-input').focusout(function () {
                    getValueAndSendIt($(this));
                });
                $('.editable-show-attribute-input').keyup(function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        getValueAndSendIt($(this));
                        return false;
                    }
                });

                $(document).keyup(function(e) {
                    if (e.shiftKey && e.keyCode == 17) {
                        e.preventDefault();
                        changeNextDate($(this));
                    }
                });

                var changeNextDate = function (element) {
                    var other_attribute_id = null;
                    if ($(':focus').hasClass('editable-show-attribute-input')) {
                        var id = $(':focus').attr('attribute-name-container-id');
                        if (id === "valid_until_attribute_container") {
                            other_attribute_id = 'valid_from_attribute_container';
                        } else {
                            other_attribute_id = 'valid_until_attribute_container';
                        }
                    } else {
                        var id = 'valid_until_attribute_container';
                        other_attribute_id = 'valid_from_attribute_container';
                    }
                    var inputDate = $("input[attribute-name-container-id='"+id+"']").first();
                    var html_p = $('#'+id).find('p');
                    var otherInputDate = $("input[attribute-name-container-id='"+other_attribute_id+"']").first();
                    var other_html_p = $('#'+other_attribute_id).find('p');
                    otherInputDate.show();
                    otherInputDate.trigger('focus');
                    html_p.show();
                    other_html_p.hide();
                    inputDate.hide();
                    inputDate.trigger('focus');
                }

                var getValueAndSendIt = function (element) {
                    element.hide();
                    if(element.val()) {
                        var iconElement = $('#'+element.attr('attribute-name-container-id')).find('p').find('i');
                        var url = "{{ route('addworking.enterprise.document.update', [$document->getEnterprise(), $document]) }}";
                        var error_span = $('#'+element.attr('attribute-name-container-id')).find('span.edit_date_error_message');

                        $.ajax({
                            method: "PUT",
                            url: url,
                            data: element.serialize(),
                            success: function(responseJson) {
                                error_span.hide();
                                iconElement.removeClass('fa-edit');
                                iconElement.removeClass('fa-bug');
                                iconElement.removeClass('fa-check');
                                iconElement.addClass('fa-check');
                                iconElement.attr('style', 'color: green !important;');
                            },
                            error: function(response) {
                                var errorMessage = response.responseJSON.message;
                                error_span.html(errorMessage);
                                error_span.show();
                                iconElement.removeClass('fa-edit');
                                iconElement.removeClass('fa-bug');
                                iconElement.removeClass('fa-check');
                                iconElement.addClass('fa-bug');
                                iconElement.attr('style', 'color: red !important;');
                            }});
                    }
                    var valueTagSelector = '#'+element.attr('attribute-name-container-id');
                    $(valueTagSelector).find('p').find('span').html(new Date(Date.parse(element.val())).toLocaleDateString("fr-FR"));
                    $(valueTagSelector).find('p').show();
                };
            })
        </script>
    @endpush
@endsupport