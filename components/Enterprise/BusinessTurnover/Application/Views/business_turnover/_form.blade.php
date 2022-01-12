<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('business_turnover::business_turnover._form.general_information') }}</legend>

    <div class="col-md-6">
        @form_group([
            'id'   => "business-turnover-amount",
            'text' => __('business_turnover::business_turnover._form.amount', ['year' => $year]),
            'type' => "number",
            'name' => "business_turnover.amount",
            'step' => "0.01",
            'min'  => "0",
         ])
    </div>

    <div class="col-md-6" id="business-turnover-amount-sentence"></div>

    <br/>

    <div class="col-md-6">
        @form_control([
            'id'       => "business-turnover-no-activity",
            'text'     => __('business_turnover::business_turnover._form.no_activity', ['year' => $year]),
            'type'     => "checkbox",
            'name'     => "business_turnover.no_activity",
            'inline'   => true,
            'value'    => true,
        ])
    </div>



    <div class="col-md-6 pb-3">
        @form_control([
            'id'       => "business-turnover-confirm",
            'class'    => "pt-1 font-weight-bold",
            'text'     => __('business_turnover::business_turnover._form.confirm'),
            'type'     => "checkbox",
            'name'     => "business_turnover.confirm",
            'inline'   => true,
            'value'    => true,
        ])
    </div>

</fieldset>

@push('scripts')
    <script>
            $('#business-turnover-amount').keyup(function () {
                @if(app()->getLocale() == 'de')
                    $('#business-turnover-amount-sentence').empty().append('' +
                        '<span>Sie geben einen Umsatz für das Jahr {{$year}} von : ' + $(this).val() + '€ an</span>'
                    );
                @else
                    $('#business-turnover-amount-sentence').empty().append('' +
                        '<span>Vous allez déclarer un CA pour l\'année {{$year}} de : ' + $(this).val() + '€</span>'
                    );
                @endif
            });
        $("#business-turnover-no-activity").on('change', function () {

            if($('input[name="business_turnover[no_activity]"]:checked').val()) {
                $('#business-turnover-amount').val('');
                $('#business-turnover-amount-sentence').empty();
                $('#business-turnover-amount').attr('disabled', 'disabled');
            } else {
                $('#business-turnover-amount').removeAttr('disabled');
            }
        });

        $("#business-turnover-confirm").on('change', function () {
            console.log($('input[name="business_turnover[confirm]"]:checked').val());

            if($('input[name="business_turnover[confirm]"]:checked').val()) {
                $('.submit-business-turnover').removeAttr('disabled');

            } else {
                $('.submit-business-turnover').attr('disabled', 'disabled');
            }
        });
    </script>
@endpush

