<a style="cursor: pointer" tabindex="0" role="button" data-trigger="focus" data-toggle="popover" title="{{ __('addworking.enterprise.member._member_accesses.access') }}" data-content="
    @foreach(user()::getAvailableAccess(true) as $access => $name)
        <i class='fa fa-fw fa-{{ $user->hasAccessFor($enterprise, $access) ? "check text-success" : "times text-danger" }}'></i> {{ $name }}
        @unless($loop->last) <br> @endunless
    @endforeach
" data-html="true">{{ count($user->getAccessesFor($enterprise)) }} / {{ count($user->getAvailableAccess()) }}</a>
