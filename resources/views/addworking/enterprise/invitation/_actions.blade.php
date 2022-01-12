@component('foundation::layout.app._actions')
    @can('showInvitation', $enterprise)
        @action_item(__('addworking.enterprise.invitation._actions.consult')."|icon:eye|href:".route('addworking.enterprise.invitation.show', compact('enterprise', 'invitation')))
    @endcan

    @can('relaunchInvitation', [$enterprise, $invitation])
        @action_item(__('addworking.enterprise.invitation._actions.revive')."|icon:redo-alt|href:".route('addworking.enterprise.invitation.relaunch', compact('enterprise', 'invitation')))
    @endcan

    @can('deleteInvitation', $enterprise)
        @action_item("icon:trash|destroy|href:".route('addworking.enterprise.invitation.destroy', compact('enterprise', 'invitation')))
    @endcan
@endcomponent
