@if ($iban->exists)
    <input type="hidden" name="iban[id]" value="{{ $iban->id }}">
@endif

@if ($iban->enterprise->exists)
    <input type="hidden" name="enterprise[id]" value="{{ $iban->enterprise->id }}">
@endif

<div class="row">
    <div class="col-md-12">
        @form_group([
            'type'        => "file",
            'name'        => "file.content",
            'required'    => true,
            'text'        => __('addworking.enterprise.iban._form.rib_account_statement'),
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        @form_group([
            'name'        => "iban.iban",
            'value'       => optional($iban)->iban,
            'text'        => "IBAN",
            'required'    => true,
            'placeholder' => "XX000 0000 0000 0000 0000 0000 00",
        ])
    </div>
    <div class="col-md-3">
        @form_group([
            'name'        => "iban.bic",
            'value'       => optional($iban)->bic,
            'text'        => __('addworking.enterprise.iban._form.bank_code'),
            'required'    => true,
        ])
    </div>
    <div class="col-md-12">
        @form_group([
            'name'  => "iban.label",
            'value' => optional($iban)->label,
            'text'  => __('addworking.enterprise.iban._form.label'),
            'type'  => "text"
        ])
    </div>
</div>
