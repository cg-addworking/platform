<div class="row" role="filter">
    <div class="col-md-3">
        @form_group([
        'text'         => __('components.contract.contract.application.views.annex._filters.enterprise'),
        'type'         => "select",
        'name'         => "filter.enterprises.",
        'value'        => request()->input('filter.enterprises'),
        'multiple'     => true,
        'selectpicker' => true,
        'id'           => "enterprises-with-annex",
        'search'       => true,
        ])
    </div>
</div>

<div class="row" role="filter">
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
            get_enterprises_with_annex();

            function get_enterprises_with_annex() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('support.annex.get_enterprises_with_annex') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    beforeSend: function () {
                        $("#enterprises-with-annex").selectpicker('refresh');
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#enterprises-with-annex").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#enterprises-with-annex").selectpicker("refresh");
                    },
                });
            }
        })
    </script>
@endpush