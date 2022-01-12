@if($user->isOperatorFor($enterprise))
    <span class="badge badge-pill badge-primary">{{ __('member.type.operator') }}</span>
@endif

@if($user->isReadonlyFor($enterprise))
    <span class="badge badge-pill badge-warning">{{ __('member.type.observer') }}</span>
@endif

@if($user->isAdminFor($enterprise))
    <span class="badge badge-pill badge-success">{{ __('member.type.admin') }}</span>
@endif
