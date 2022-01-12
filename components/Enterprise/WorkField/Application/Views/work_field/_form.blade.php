@inject('workFieldContributorRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository')

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('work_field::workfield._form.general_information') }}</legend>
    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'     => __('work_field::workfield._form.display_name'),
                'type'     => "text",
                'name'     => "work_field.display_name",
                'value'    => optional($work_field)->getDisplayName(),
                'required' => true,
            ])
        </div>
        <div class="col-md-6">
            @form_group([
            'text'     => __('work_field::workfield._form.external_id'),
            'type'     => "text",
            'name'     => "work_field.external_id",
            'value'    => optional($work_field)->getExternalId(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @form_group([
            'text'  => __('work_field::workfield._form.started_at'),
            'type'  => "date",
            'name'  => "work_field.started_at",
            'value' => optional($work_field)->getStartedAt(),
            ])
        </div>
        <div class="col-md-6">
            @form_group([
            'text'  => __('work_field::workfield._form.ended_at'),
            'type'  => "date",
            'name'  => "work_field.ended_at",
            'value' => optional($work_field)->getEndedAt(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{__('work_field::workfield._form.departments')}}
                </label>
                <select data-live-search="1" multiple="1" class="form-control shadow-sm selectpicker" name="work_field[departments][]">
                    @foreach($departments as $id => $name)
                        <option value="{{$id}}" @if (isset($selected_departments) && in_array($id, $selected_departments)) selected @endif>{{$name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            @form_group([
            'text'     => __('work_field::workfield._form.address'),
            'type'     => "text",
            'name'     => "work_field.address",
            'value'    => optional($work_field)->getAddress(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @form_group([
            'text'     => __('work_field::workfield._form.project_manager'),
            'type'     => "text",
            'name'     => "work_field.project_manager",
            'value'    => optional($work_field)->getProjectManager(),
            ])
        </div>
        <div class="col-md-6">
            @form_group([
            'text'     => __('work_field::workfield._form.project_owner'),
            'type'     => "text",
            'name'     => "work_field.project_owner",
            'value'    => optional($work_field)->getProjectOwner(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'     => __('work_field::workfield._form.sps_coordinator'),
            'type'     => "text",
            'name'     => "work_field.sps_coordinator",
            'value'    => optional($work_field)->getSpsCoordinator(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'  => __('work_field::workfield._form.estimated_budget'),
            'type'  => "text",
            'name'  => "work_field.estimated_budget",
            'value' => optional($work_field)->getEstimatedBudget(),
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'  => __('work_field::workfield._form.description'),
            'type'  => "textarea",
            'name'  => "work_field.description",
            'value' => optional($work_field)->getDescription(),
            'rows'  => 3,
            ])
        </div>
    </div>
    @if($page == "create")
        <hr/>

        <legend class="text-primary h5">@icon('info') {{ __('work_field::workfield._form.contributor_informations') }}</legend>

        <div class="form-group">
            <label>
                {{__('work_field::workfield._form.contributor_enterprise')}}
                <sup class="text-danger font-italic">*</sup>
            </label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker" id="selected_enterprise" name="enterprise_id">
                @foreach($subsidiaries as $enterprise)
                    <option value="{{$enterprise->id}}">{{$enterprise->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>
                {{__('work_field::workfield._form.contributor')}}
            </label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker" multiple="1" id="selected_contributors"></select>
        </div>

        <div id="contributors-table-container">
            <table class="table table-striped" id="contributors-table">
                <thead>
                    <tr>
                        <th>{{__('work_field::workfield._form.contributor_name')}}</th>
                        <th>{{__('work_field::workfield._form.contributor_role')}}</th>
                        <th class="text-center">{{__('work_field::workfield._form.contributor_is_admin')}}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    @endif
</fieldset>

@push('scripts')
    <script>
        $('.selectpicker').selectpicker('refresh')
        var contributors = [];
        var get_contributors = function(value) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work_field.get_contributors_without_creator') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    enterprise: value
                },
                beforeSend: function () {
                    $('#selected_contributors option').remove();
                    $("#selected_contributors").selectpicker("refresh");
                },
                success: function(response) {
                    var i = 0;
                    $.each(response.data, function(id, name) {
                        $('#selected_contributors').append('<option value="'+id+'">'+name+'</option>');
                        $("#selected_contributors").selectpicker("refresh");

                        contributors[i] = [id, name];
                        i++;
                    });
                },
            });
        }
        $('#selected_enterprise').on('change', function() {
            get_contributors($('#selected_enterprise').val());
        });

        if ($('#selected_enterprise')) {
            get_contributors($('#selected_enterprise').val());
        }

        $('#selected_contributors').bind('changed.bs.select', function(event, index, oldvalue, newvalue) {
            var contributor = contributors[index];
            var contributor_id = contributor[0];
            var contributor_name = contributor[1];
            var contributor_enterprise_id = $('#selected_enterprise option:selected').val();
            var contributor_enterprise_name = $('#selected_enterprise option:selected').text();

            if (oldvalue) {
                if ($("#contributor-tr-"+contributor_id+"").length < 1) {
                    $('#contributors-table').append('' +
                        '<tr id="contributor-tr-'+contributor_id+'">' +
                            '<td>'+contributor_name+' ('+contributor_enterprise_name+')</td>' +
                            '<td>' +
                                '<select class="form-control form-control-sm shadow-sm" name="contributors['+contributor_id+'][role]">' +
                                    '<option value={{null}}></option>' +
                                    '@foreach($workFieldContributorRepository->getAvailableRoles(true) as $role => $translation)' +
                                        '<option value="{{$role}}">{{$translation}}</option>' +
                                    '@endforeach' +
                                '</select>' +
                            '</td>' +
                            '<td class="text-center">' +
                                '<input type="checkbox" name="contributors['+contributor_id+'][is_admin]" value="1">' +
                                '<input type="hidden" name="contributors['+contributor_id+'][contributor_id]" value="'+contributor_id+'">' +
                                '<input type="hidden" name="contributors['+contributor_id+'][enterprise_id]" value="'+contributor_enterprise_id+'">' +
                            '</td>' +
                            '<td class=text-right>' +
                                '<button class="btn btn-outline-danger btn-sm contributor-delete"><i class="fa fa-trash"></i></button>' +
                            '</td>' +
                        '</tr>'
                    );
                }
            } else {
                $('#contributor-tr-'+contributor_id).remove();
            }
        });

        $("#contributors-table").on('click', '.contributor-delete', function () {
            $(this).closest('tr').remove();
        });
    </script>
@endpush
