@th(__('addworking.enterprise.member._table_head.last_name').'|column:lastname')

@can('readMemberRoles', $enterprise)
    @th('Roles|not_allowed')
@endcan

@can('readMemberAccess', $enterprise)
    @th(__('addworking.enterprise.member._table_head.access').'|not_allowed')
@endcan

@th('Actions|not_allowed')
