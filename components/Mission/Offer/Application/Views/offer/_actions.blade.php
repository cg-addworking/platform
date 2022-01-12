@component('foundation::layout.app._actions')
    @can('show', $offer)
        <a class="dropdown-item" href="{{ route('sector.offer.show', $offer) }}">
            @icon('eye|mr:3|color:muted') {{ __('offer::offer._actions.show') }}
        </a>
    @endcan
    @can('edit', $offer)
        <a class="dropdown-item" href="{{ route('sector.offer.edit', $offer) }}">
            @icon('pen|mr:3|color:muted') {{ __('offer::offer._actions.edit') }}
        </a>
    @endcan
    @can('delete', $offer)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('offer::offer._actions.delete') }}</span>
        </a>
        @push('forms')
            <form name="{{ $name }}" action="{{ route('sector.offer.delete', $offer) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
