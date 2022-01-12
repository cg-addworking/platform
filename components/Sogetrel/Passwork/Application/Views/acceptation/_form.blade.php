<fieldset class="offset-2 col-md-8 mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('sogetrel_passwork::acceptation._form.general_information') }}</legend>
    <input type="hidden" name="passwork_id" value="{{ $passwork->id }}">
    <input type="hidden" name="status" value="{{ sogetrel_passwork()::STATUS_ACCEPTED }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $passwork->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($passwork)) }}">
    <input type="hidden" name="comment[visibility]" value="public">

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'contract_types.',
        'options'  => sogetrel_contract_type()::orderBy('order')->pluck('display_name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel_passwork::acceptation._form.contract_types') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'  => __('sogetrel_passwork::acceptation._form.contract_starting_at'),
                'type'  => "date",
                'name'  => "work_starts_at",
                'required' => true,
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'  => __('sogetrel_passwork::acceptation._form.contract_ending_at'),
                'type'  => "date",
                'name'  => "date_due_at",
                'required' => true,
            ])
        </div>
    </div>

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'operational_manager',
        'options'  => Auth::user()->enterprise->users->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel_passwork::acceptation._form.operational_manager') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'administrative_assistant',
        'options'  => Auth::user()->enterprise->users->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel_passwork::acceptation._form.administrative_assistant') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'administrative_manager',
        'options'  => $vendor_compliance_managers,
        'required' => true,
    ])
        @slot('label')
            {{ __('sogetrel_passwork::acceptation._form.administrative_manager') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'contract_signatory',
        'options'  => Auth::user()->enterprise->signatories->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel_passwork::acceptation._form.signatory') }}
        @endslot
    @endcomponent

    <div class="form-group">
        <label>
            {{ __('sogetrel_passwork::acceptation._form.needs_decennial_insurance') }}
            <sup class=" text-danger font-italic">*</sup>
        </label>
        @form_control([
            'text'  => __('sogetrel_passwork::acceptation._form.needs_decennial_insurance_yes'),
            'type'  => "radio",
            'name'  => "needs_decennial_insurance",
            'value' => "yes",
        ])

        @form_control([
            'text'  => __('sogetrel_passwork::acceptation._form.needs_decennial_insurance_no'),
            'type'  => "radio",
            'name'  => "needs_decennial_insurance",
            'value' => "no",
        ])
    </div>

    @form_group([
        'text'        => __('sogetrel_passwork::acceptation._form.applicable_price_slip'),
        'type'        => "text",
        'name'        => "applicable_price_slip",
        'placeholder' => __('sogetrel_passwork::acceptation._form.applicable_price_slip_placeholder'),
        'required'    => true,
    ])

    @form_group([
        'text'        => __('sogetrel_passwork::acceptation._form.bank_guarantee_amount'),
        'type'        => "text",
        'name'        => "bank_guarantee_amount",
        'placeholder' => __('sogetrel_passwork::acceptation._form.bank_guarantee_amount_placeholder'),
        'required'    => true,
    ])

    @form_group([
        'text'        => __('sogetrel_passwork::acceptation._form.comment'),
        'type'        => "textarea",
        'name'        => "comment.content",
        'placeholder' => __('sogetrel_passwork::acceptation._form.comment_placeholder'),
        'required'    => false,
        'rows'        => 10
    ])
</fieldset>

