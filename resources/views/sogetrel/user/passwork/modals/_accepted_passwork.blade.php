@component('components.form.modal', [
    'id'     => 'passwork-accepted-modal',
    'action' => route('sogetrel.passwork.status', $passwork),
])
    @slot('title')
        {{ __('sogetrel.user.passwork.modals._accepted_passwork.title') }}
    @endslot

    @csrf
    @method('put')

    <input type="hidden" name="status" value="{{ sogetrel_passwork()::STATUS_ACCEPTED }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $passwork->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($passwork)) }}">
    <input type="hidden" name="comment[visibility]" value="public">

    @component('components.form.group', [
        'type'     => "checkbox_list",
        'name'     => "contract_types.",
        'values'   => sogetrel_contract_type()::orderBy('order')->pluck('display_name', 'id'),
        'height'   => '30em',
        'required' => true,
    ])
        @slot('label')
            {{ __('sogetrel.user.passwork.modals._accepted_passwork.label_1') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "date",
        'name'     => 'work_starts_at',
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel.user.passwork.modals._accepted_passwork.label_2') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "date",
        'name'     => 'date_due_at',
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel.user.passwork.modals._accepted_passwork.label_3') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'operational_manager',
        'options'  => Auth::user()->enterprise->users->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel.user.passwork.modals._accepted_passwork.label_4') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'administrative_assistant',
        'options'  => Auth::user()->enterprise->users->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel.user.passwork.modals._accepted_passwork.label_5') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'administrative_manager',
        'options'  => Auth::user()->enterprise->users->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            {{ __('sogetrel.user.passwork.modals._accepted_passwork.label_6') }}
        @endslot
    @endcomponent

    @component('components.form.group', [
        'type'     => "select",
        'name'     => 'contract_signatory',
        'options'  => Auth::user()->enterprise->signatories->pluck('name', 'id'),
        'required' => true
    ])
        @slot('label')
            Signataire
        @endslot
    @endcomponent

    @form_group([
        'text'        => __('sogetrel.user.passwork.modals._accepted_passwork.comments'),
        'type'        => "textarea",
        'name'        => "comment.content",
        'placeholder' => __('sogetrel.user.passwork.modals._accepted_passwork.label_7'),
        'required'    => false,
        'rows'        => 10
    ])
@endcomponent
