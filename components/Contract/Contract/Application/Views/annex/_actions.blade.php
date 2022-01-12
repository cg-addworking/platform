@component('foundation::layout.app._actions', ['model' => $annex])
    @can('show', $annex)
        <a class="dropdown-item" href="{{ route('annex.show', $annex) }}">
            @icon('eye|mr:3|color:muted') {{ __('components.contract.contract.application.views.annex._actions.show') }}
        </a>
    @endcan

    @can('delete', $annex)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.contract.application.views.annex._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.annex.delete', $annex) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
