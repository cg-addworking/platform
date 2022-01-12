@component('foundation::layout.app._actions')
    @can('show', $enterprise)
        @action_item(__('addworking.enterprise.member._actions.consult')."|icon:eye|href:".route('addworking.enterprise.member.show', compact('enterprise', 'user')))
    @endcan

    @can('editMember', $enterprise)
        @action_item(__('addworking.enterprise.member._actions.edit')."|icon:edit|href:".route('addworking.enterprise.member.edit', compact('enterprise', 'user')))
    @endcan

    @can('assignVendors', $enterprise)
        @action_item(__('addworking.enterprise.member._actions.assign_provider')."|icon:user-friends|href:".route('addworking.enterprise.referent.assigned_vendor.edit', compact('enterprise', 'user')))
    @endcan

    @can('removeMember', [$enterprise, $user])
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="confirm('{{ __('addworking.enterprise.member._actions.confirm_delisting_of_member') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('unlink|color:danger|mr:3') <span class="text-danger">{{ __('addworking.enterprise.member._actions.dereference') }}</span>
        </a>

        @push('modals')
            <form name="{{ $name }}" action="{{ route('addworking.enterprise.member.remove', compact('enterprise', 'user')) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent
