<fieldset class="mt-5 pt-2">
    <legend class="text-primary h6">@icon('handshake') {{ __('components.contract.contract.application.views.contract_party._form.validators') }} </legend>
    @foreach($selectable_validators as $validator)
        <div class="row validator-container">
            <div class="col-md-1">
                {{$validator['order']}}.
            </div>
            <div class="form-group col-md-10">
                <div class="dropdown bootstrap-select form-control shadow-sm dropup">
                    <select
                        name="validators[{{$validator['order']}}]"
                        data-validator-order="{{$validator['order']}}"
                        class="form-control shadow-sm selectpicker validator-select-id"
                        tabindex="null"
                    >
                        @foreach($available_validators as $available_validator)
                            <option value="{{$available_validator->id}}"
                                    {{$available_validator->id === $validator['id'] ? "selected" : ""}}
                            >
                                {{$available_validator->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <a  href="#" class="remove-validator-btn btn-outline-danger btn text-right">
                    <i class="fas fa-fw fa-trash"></i>
                </a>
            </div>
        </div>
    @endforeach
    <a  href="#" class="btn mb-3 btn-primary btn btn-sm mr-2" id="btn-add-validator">
        <i class="fas fa-fw fa-plus"></i>
        {{ __('components.contract.contract.application.views.contract_party._form.add_validator') }}
    </a>
</fieldset>

@push('scripts')
    <script>
        $(function () {
            const get_validator_select_order = function() {
                var order = 0;
                $('select.validator-select-id').each(function() {
                    if (parseInt($(this).attr('data-validator-order')) > order) {
                        order = parseInt($(this).attr('data-validator-order'));
                    }
                });
                return parseInt(order)+1;
            };

            const upate_add_validator_button = function () {
                if ($('.validator-container').length <= 9) {
                    $('#btn-add-validator').show();
                } else {
                    $('#btn-add-validator').hide();
                }
            };
            upate_add_validator_button();

            const remove_validator_btn_action = function(event, element) {
                event.preventDefault();
                $(element).parent().parent().remove();
                upate_add_validator_button();
            };

            $('.remove-validator-btn').click(function(e) {
                remove_validator_btn_action(e, $(this));
                upate_add_validator_button();
            });

            $('#btn-add-validator').click(function (e) {
                e.preventDefault();
                var order = get_validator_select_order();
                const select_validator_html = '' +
                    '<div class="row validator-container"> ' +
                        '<div class="col-md-1">' +
                            order + '.' +
                        '</div> ' +
                        '<div class="form-group col-md-10"> ' +
                            '<div class="dropdown bootstrap-select form-control shadow-sm dropup"> ' +
                                '<select' +
                                    ' name="validators['+order+']"' +
                                    ' data-validator-order="'+order+'" class="form-control shadow-sm selectpicker validator-select-id" ' +
                                    ' tabindex="null"> ' +
                                    @foreach($available_validators as $available_validator)
                                        ' <option value="{{$available_validator->id}}">{{$available_validator->name}}</option> ' +
                                    @endforeach
                                '</select> ' +
                            '</div> ' +
                        '</div> ' +
                        '<div class="col-md-1"> ' +
                            '<a  href="#" class="remove-validator-btn btn-outline-danger btn text-right"> ' +
                                '<i class="fas fa-fw fa-trash"></i> ' +
                            '</a> ' +
                        '</div> ' +
                    '</div> ';
                var select = $.parseHTML(select_validator_html);
                $(select).insertBefore($(this));
                $(select).find("select").selectpicker("refresh");
                $('.remove-validator-btn').click(function(e) {
                    remove_validator_btn_action(e, $(this));
                });
                upate_add_validator_button();
            });
        });
    </script>
@endpush
