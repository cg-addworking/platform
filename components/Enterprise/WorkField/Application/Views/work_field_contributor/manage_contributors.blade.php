@inject('workFieldContributorRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository')

@extends('foundation::layout.app.show')

@section('title', __('work_field::workfield.manage.title'))

@section('toolbar')
    @button(__('work_field::workfield.manage.return')."|href:".route('work_field.show', $work_field)."|icon:arrow-left|color:secondary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @include('work_field::work_field._breadcrumb', ['page' => "manageContributors"])
@endsection

@section('content')
    <div id="alert-message"></div>
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('work_field::workfield._form.contributor_informations') }}</legend>
        <div id="contributors-table-container">
            <table class="table table-striped" id="contributors-table">
                <thead>
                    <tr>
                        <th> {{ __('work_field::workfield._form.contributor_name') }}</th>
                        <th class="text-center">{{__('work_field::workfield._form.contributor_role') }}</th>
                        <th class="text-center">{{ __('work_field::workfield._form.contributor_is_admin') }}</th>
                        <th class="text-center">{{ __('work_field::workfield._form.contributor_is_contract_validator') }}</th>
                        <th class="text-center">{{ __('work_field::workfield._form.contract_validation_order') }}</th>
                        <th class="text-right">{{ __('work_field::workfield.manage.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($work_field->workFieldContributors()->cursor() as $contributor)
                        <tr id="contributor-tr-{{$contributor->id}}">
                            <input type="hidden" name="work_field_contributor_id" value="{{ $contributor->getId() }}">
                            <td>{{$contributor->getContributor()->name}} ({{$contributor->getEnterprise()->name}})</td>
                            <td class="text-center">
                                <select class="form-control form-control-sm shadow-sm set-role" name="contributors[{{$contributor->id}}][role]" id="select-role">
                                    <option value={{null}}></option>
                                    @foreach($workFieldContributorRepository->getAvailableRoles(true) as $role => $translation)
                                        <option value="{{$role}}" @if($role === $contributor->role) selected @endif>{{$translation}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="contributors[{{$contributor->id}}][is_admin]" class="is-admin" @if($contributor->getIsAdmin()) checked="true" @endif>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="contributors[{{$contributor->id}}][is_contract_validator]"
                                       class="is-contract-validator" @if($contributor->getIsContractValidator()) checked @endif>
                            </td>
                            <td class="text-center rank-validator">
                                @if($contributor->getIsContractValidator())
                                    <select class="form-control form-control-sm contract_validation_order" name="contributors[{{$contributor->id}}][contract_validation_order]">
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" @if($contributor->getContractValidationOrder() == $i) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                @endif
                            </td>
                            <td class="text-right">
                                <button class="btn btn-outline-danger btn-sm contributor-delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="text-right">
            <button class="btn btn-outline-success btn-sm mb-2" type="button" data-toggle="collapse" data-target="#collapseAdd" aria-expanded="false" aria-controls="collapseAdd">
                {{__('work_field::workfield.manage.add')}}
            </button>
        </div>
        <div class="collapse" id="collapseAdd">
            <div class="card card-body">
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
                        <sup class="text-danger font-italic">*</sup>
                    </label>
                    <select data-live-search="1" class="form-control shadow-sm selectpicker" multiple="1" id="selected_contributors"></select>
                </div>
            </div>
        </div>
    </fieldset>
@endsection

@push('scripts')
    <script>
        var contributors = [];
        var get_contributors = function(value) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work_field.get_contributors') }}",
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
            var contributor_id_to_add = contributor[0];
            var contributor_name = contributor[1];
            var contributor_enterprise_id = $('#selected_enterprise option:selected').val();
            var contributor_enterprise_name = $('#selected_enterprise option:selected').text();
            
            if ($("#contributor-tr-"+contributor_id_to_add+"").length < 1) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('work_field.attach_contributor') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        work_field_id: "{{ $work_field->getId() }}",
                        contributor_id: contributor_id_to_add,
                        enterprise_id: contributor_enterprise_id
                    },
                    success: function(response) {
                        $('#contributors-table').append('' +
                            '<tr id="contributor-tr-'+contributor_id_to_add+'">' +
                                '<input type="hidden" name="work_field_contributor_id" value="'+response.work_field_contributor_id+'">' +
                                '<td>'+contributor_name+' ('+contributor_enterprise_name+')</td>' +
                                '<td>' +
                                    '<select class="form-control form-control-sm shadow-sm" name="contributors['+contributor_id_to_add+'][role]">' +
                                        '<option value={{null}}></option>' +
                                        '@foreach($workFieldContributorRepository->getAvailableRoles(true) as $role => $translation)' +
                                            '<option value="{{$role}}">{{$translation}}</option>' +
                                        '@endforeach' +
                                    '</select>' +
                                '</td>' +
                                '<td class="text-center">' +
                                    '<input type="checkbox" name="contributors['+contributor_id_to_add+'][is_admin]" class="is-admin" value="1">' +
                                    '<input type="hidden" name="contributors['+contributor_id_to_add+'][contributor_id]" value="'+contributor_id_to_add+'">' +
                                    '<input type="hidden" name="contributors['+contributor_id_to_add+'][enterprise_id]" value="'+contributor_enterprise_id+'">' +
                                '</td>' +
                                '<td class="text-center">' +
                                    '<input type="checkbox" name="contributors['+contributor_id_to_add+'][is_contract_validator]"' + 'class="is-contract-validator">' +
                                '</td>' +
                                '<td class="text-center rank-validator"></td>'+
                                '<td class=text-right>' +
                                    '<button class="btn btn-outline-danger btn-sm contributor-delete"><i class="fa fa-trash"></i></button>' +
                                '</td>' +
                            '</tr>'
                        );
                    },
                });
            };
        });

        $("#contributors-table").on('click', '.contributor-delete', function () {
            if (!confirm('Confirmer la suppression ?')) {
                return false
            };
            var closest_tr = $(this).closest('tr');
            var work_field_contributor_id = closest_tr.find('input').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work_field.detach_contributor') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: work_field_contributor_id
                },
                success: function(response) {
                    closest_tr.remove();
                },
            });
        });


        $("#contributors-table").on('change', '.is-admin', function () {
            var closest_tr = $(this).closest('tr');
            var work_field_contributor_id = closest_tr.find('input').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work_field.set_administrator', $work_field) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: work_field_contributor_id,
                },
            });
        });

        var set_contract_validator = function (work_field_contributor_id) {
            var result;
            $.ajax({
                type: "POST",
                async: false,
                global: false,
                dataType: "json",
                url: "{{ route('work_field.set_contract_validator', $work_field) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: work_field_contributor_id,
                },
                success: function(response) {
                    result = response.order;
                },
            });

            return result;
        }

        $("#contributors-table").on('change', '.is-contract-validator', function () {
            var closest_tr = $(this).closest('tr');
            var work_field_contributor_id = closest_tr.find('input').val();
            var new_order = set_contract_validator(work_field_contributor_id);

            if ($(this).prop('checked') === true) {
                $(this).closest('tr').find('.rank-validator').append('' +
                    '<select class="form-control form-control-sm contract_validation_order" name="contributors['+work_field_contributor_id+'][contract_validation_order]">' +
                    '@for($i = 1; $i <= 10; $i++)' +
                    '<option value="{{ $i }}">{{ $i }}</option>'+
                    '@endfor' +
                    '</select>');

                $(this).closest('tr').find('.rank-validator select option').each(function(){
                    if ($(this).text() == new_order) {
                        $(this).prop("selected", true);
                    }
                });
            } else {
                $(this).closest('tr').find('.rank-validator select').remove();
            }

        });

        $("#contributors-table").on('change', 'select.contract_validation_order', function () {
            var closest_tr = $(this).closest('tr');
            var work_field_contributor_id = closest_tr.find('input').val();
            var order = $(this).val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work_field.contract_validation_order', $work_field) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: work_field_contributor_id,
                    order: order,
                },
            });
        });

        $("#contributors-table").on('change', '.set-role', function () {
            var closest_tr = $(this).closest('tr');
            var work_field_contributor_id = closest_tr.find('input').val();
            var work_field_contributor_role = $(this).val();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('work_field.set_contributoer_role') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: work_field_contributor_id,
                    role: work_field_contributor_role,
                },
            });
        });
    </script>
@endpush
