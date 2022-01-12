@inject('contract', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('enterprise', 'Components\Contract\Contract\Application\Repositories\EnterpriseRepository')

<div class="row" role="filter">
    <div class="col-md-3">
        @form_group([
        'text'     => __('components.contract.contract.application.views.contract._filters.state'),
        'type'     => "select",
        'name'     => "filter.states.",
        'options'  => $contract->getFilterAvailableStates(true),
        'value'    => request()->input('filter.states'),
        'multiple' => true,
        'selectpicker' => true,
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract._filters.enterprise'),
            'type'     => "select",
            'name'     => "filter.enterprises.",
            'value'    => request()->input('filter.enterprises'),
            'multiple' => true,
            'selectpicker' => true,
            'search' => true,
            'id' => "contract-owner-enterprises"
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract._filters.party'),
            'type'     => "select",
            'name'     => "filter.parties.",
            'value'    => request()->input('filter.parties'),
            'multiple' => true,
            'selectpicker' => true,
            'search' => true,
            'id' => "contract-parties"
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract._filters.created_by'),
            'type'     => "select",
            'name'     => "filter.creators.",
            'value'    => request()->input('filter.creators'),
            'multiple' => true,
            'selectpicker' => true,
            'search' => true,
            'id' => 'contract-creator-users'
        ])
    </div>
</div>
<div class="row" role="filter">
    <div class="col-md-6">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract._filters.model'),
            'type'     => "select",
            'name'     => "filter.models.",
            'value'    => request()->input('filter.models'),
            'multiple' => true,
            'selectpicker' => true,
            'id' => 'contract-models'
        ])
    </div>
    <div class="col-md-6">
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract._filters.work_field'),
            'type'     => "select",
            'name'     => "filter.work_fields.",
            'value'    => request()->input('filter.work_fields'),
            'multiple' => true,
            'selectpicker' => true,
            'search' => true,
            'id' => 'workfields'
        ])
    </div>
    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('addworking.components.billing.inbound.index.filters.filter') }}</button>
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('addworking.components.billing.inbound.index.filters.reset') }}</a>
        @endif
    </div>
</div>

@push('scripts')
    <script>

        $(function () {
            let user = "{{ request()->user()->id }}";

            get_contract_owner_enterprises();
            get_contract_parties();
            get_contract_creator_users();
            get_contract_models();
            get_workfields();

            function get_contract_owner_enterprises() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_contract_owner_enterprises') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $("#contract-owner-enterprises").selectpicker('refresh');
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#contract-owner-enterprises").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#contract-owner-enterprises").selectpicker("refresh");
                    },
                });
            }

            function get_contract_parties() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_contract_parties') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $("#contract-parties").selectpicker('refresh');
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#contract-parties").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#contract-parties").selectpicker("refresh");
                    },
                });
            }

            function get_contract_creator_users() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_contract_creator_users') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $("#contract-creator-users").selectpicker('refresh');
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#contract-creator-users").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#contract-creator-users").selectpicker("refresh");
                    },
                });
            }

            function get_contract_models() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_list_contract_models') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $("#contract-models").selectpicker('refresh');
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#contract-models").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#contract-models").selectpicker("refresh");
                    },
                });
            }

            function get_workfields() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_workfields') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $("#workfields").selectpicker('refresh');
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#workfields").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#workfields").selectpicker("refresh");
                    },
                });
            }
        })
    </script>
@endpush