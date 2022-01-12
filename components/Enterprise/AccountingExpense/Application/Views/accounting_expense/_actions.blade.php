@component('foundation::layout.app._actions')
    @can('edit', [$accounting_expense, $enterprise])
        <a class="dropdown-item" href="{{ route('addworking.enterprise.accounting_expense.edit', [$enterprise, $accounting_expense]) }}">
            @icon('pen|mr:3|color:muted') {{ __('accounting_expense::accounting_expense._actions.edit') }}
        </a>
    @endcan

    @can('delete', [$accounting_expense, $enterprise])
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('accounting_expense::accounting_expense._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('addworking.enterprise.accounting_expense.delete', [$enterprise, $accounting_expense]) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
