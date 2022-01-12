<div class="tab-pane fade show" id="nav-sogetrel-metadata" role="tabpanel" aria-labelledby="nav-sogetrel-metadata-tab">
    <div class="row mb-4">
        @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "key", 'label' => 'Oracle ID'])
            {{ optional($enterprise->sogetrelData)->oracle_id }}
            @can('editOracleId', $enterprise)
                <i class="fas fa-edit" data-toggle="modal" data-target="#edit_oracle_id"></i>
            @endcan
        @endcomponent

        <div class="modal fade" id="edit_oracle_id" tabindex="-1" role="dialog" aria-labelledby="editOracleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> {{__('addworking.enterprise.enterprise.tabs._sogetrel_data.edit_oracle_id')}} </h5>
                    </div>
                    <div class="modal-body">
                        <fieldset class="pt-2">
                            @form_group([
                                'text'        => "Oracle ID ",
                                'type'        => "text",
                                'name'        => "sogetrel.oracle_id",
                                'id'          => 'modal_input_oracle_id',
                                'value'       => optional($enterprise->sogetrelData)->oracle_id,
                            ])
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="modal_edit_oracle_id_send_button"> {{__('addworking.enterprise.enterprise.tabs._sogetrel_data.record')}} </button>
                    </div>
                </div>
            </div>
        </div>

        @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "key", 'label' => 'Navibat ID'])
            {{ optional($enterprise->sogetrelData)->navibat_id }}
        @endcomponent

        @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "hashtag", 'label' => __('addworking.enterprise.enterprise.tabs._sogetrel_data.group_counted_march')])
            {{ optional($enterprise->sogetrelData)->compta_marche_group }}
        @endcomponent

        @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "hashtag", 'label' => __('addworking.enterprise.enterprise.tabs._sogetrel_data.vat_group_accounting')])
            {{ optional($enterprise->sogetrelData)->compta_marche_tva_group }}
        @endcomponent

        @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "hashtag", 'label' => __('addworking.enterprise.enterprise.tabs._sogetrel_data.product_accounting_group')])
            {{ optional($enterprise->sogetrelData)->compta_produit_group }}
        @endcomponent

        @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "cog", 'label' => __('addworking.enterprise.enterprise.tabs._sogetrel_data.sent_navibat')])
            {{ optional($enterprise->sogetrelData)->navibat_sent ? __('addworking.enterprise.enterprise.tabs._sogetrel_data.yes') : __('addworking.enterprise.enterprise.tabs._sogetrel_data.no') }}
        @endcomponent
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('#modal_edit_oracle_id_send_button').bind('click', function () {
            var value = $('#modal_input_oracle_id').val();
            var enterprise_id_value = '{{ $enterprise->id }}';

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('enterprise.set_oracle_id') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    oracle_id: value,
                    enterprise_id: enterprise_id_value,
                },
                success: function(response) {
                    $('#edit_oracle_id').modal('hide');
                    location.reload(true);
                },
            });
            });
        });
    </script>
@endpush