@component('foundation::layout.app._actions', ['model' => $legal_form])
    @support()
    <a class="dropdown-item" href="{{ route('support.enterprise.legal_form.show', $legal_form) }}">
        @icon('eye|color:muted|mr:3') {{ __('addworking.enterprise.legal_form._actions.show') }}
    </a>
    @endsupport()

    @support()
        <a class="dropdown-item" href="{{ route('support.enterprise.legal_form.edit', $legal_form) }}">
            @icon('edit|color:muted|mr:3') {{ __('addworking.enterprise.legal_form._actions.edit') }}
        </a>
    @endsupport()

@endcomponent
