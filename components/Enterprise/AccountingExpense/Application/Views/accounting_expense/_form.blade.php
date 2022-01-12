<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('accounting_expense::accounting_expense._form.general_information') }}</legend>

    <div class="col-md-6">
        @form_group([
            'text'     => __('accounting_expense::accounting_expense._form.display_name'),
            'type'     => "text",
            'name'     => "accounting_expense.display_name",
            'value'    => optional($accounting_expense)->getDisplayName(),
            'required' => true,
        ])
    </div>

    <div class="col-md-6">
        @form_group([
            'text'  => __('accounting_expense::accounting_expense._form.analytical_code'),
            'type'  => "text",
            'name'  => "accounting_expense.analytical_code",
            'value' => optional($accounting_expense)->getAnalyticalCode(),
        ])
    </div>
</fieldset>
