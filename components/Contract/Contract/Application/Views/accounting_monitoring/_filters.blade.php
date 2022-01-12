<div class="row" role="filter">
    <div class="col-md-3">
        @form_group([
        'text'     => __('components.contract.contract.application.views.contract.accounting_monitoring.index.filters.enterprise'),
        'type'     => "select",
        'name'     => "filter.enterprises.",
        'value'    => request()->input('filter.enterprises'),
        'multiple' => true,
        'selectpicker' => true,
        'id' => "contract-owner-enterprises"
        ])
    </div>
    <div class="col-md-3">
        @form_group([
        'text'     => __('components.contract.contract.application.views.contract.accounting_monitoring.index.filters.work_field'),
        'type'     => "select",
        'name'     => "filter.work_fields.",
        'value'    => request()->input('filter.work_fields'),
        'multiple' => true,
        'selectpicker' => true,
        'search' => true,
        'id' => 'workfields'
        ])
    </div>
</div>
<div class="row" role="filter">
    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('components.contract.contract.application.views.contract.accounting_monitoring.index.filters.filter') }}</button>
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('components.contract.contract.application.views.contract.accounting_monitoring.index.filters.reset') }}</a>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            get_contract_owner_enterprises();
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
