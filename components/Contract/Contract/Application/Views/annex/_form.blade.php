<div class="offset-3 col-lg-6">
    @form_group([
        'text'        => __('components.contract.contract.application.views.annex._form.name'),
        'type'        => "text",
        'name'        => "annex.name",
        'required'    => true,
    ])

    @form_group([
        'text'     => __('components.contract.contract.application.views.annex._form.description'),
        'type'     => "textarea",
        'rows'     => 8,
        'name'     => "annex.description",
        'value'    => optional($annex)->getDescription(),
        'required' => false,
    ])

    <div class="form-group mb-3" id="div-file">
        @form_group([
            'type'        => "file",
            'name'        => "annex.file",
            'required'    => true,
            'id'          => 'input-group-file',
            'accept'      => 'application/pdf',
            'text'        => __('components.contract.contract.application.views.annex._form.file'),
        ])
    </div>


    <div class="form-group">
        <label>
            {{__('components.contract.contract.application.views.annex._form.enterprise')}}
            <sup class=" text-danger font-italic">*</sup>
        </label>
        <select data-live-search="1" class="form-control shadow-sm selectpicker" id="enterprise_dropdown" name="annex[enterprise]">
        </select>
    </div>


@push('scripts')
    <script>
        function getEnterprises() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('support.annex.ajax_get_enterprise') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    var selected_enterprise = {{optional(optional($annex)->getEnterprise())->id}}
                    $.each(response.data, function(id, name) {
                        $("#enterprise_dropdown").append('<option value="'+id+'" ' + (id === selected_enterprise ? 'selected' : '') + '>'+name+'</option>');
                    });
                    $("#enterprise_dropdown").selectpicker("refresh");
                },
            });
        }
        getEnterprises()
    </script>
@endpush