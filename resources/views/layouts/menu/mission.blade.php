<li>
    <a data-toggle="collapse" href="#menu-mission-collapse" aria-expanded="false" aria-controls="menu-mission-collapse">
        <i class="fa fa-fw fa-handshake-o"></i> {{ __('layouts.menu.mission.missions') }}
        <span class="caret"></span>
    </a>

    <ul class="collapse" id="menu-mission-collapse">
        @can('index', mission_offer())
        <li>
            <a href="{{ route('mission.offer.index') }}">
                <i class="fa fa-fw fa-users"></i> {{ __('layouts.menu.mission.mission_offers') }}
            </a>
        </li>
        @endcan

        @can('index', mission_proposal())
        <li>
            <a href="{{ route('mission.proposal.index') }}">
                <i class="fa fa-fw fa-handshake-o"></i> {{ __('layouts.menu.mission.mission_proposal') }}
            </a>
        </li>
        @endcan

        @can('index', mission_tracking())
            <li>
                <a href="{{ route('mission.tracking.index') }}">
                    <i class="fa fa-fw fa-handshake-o"></i> {{ __('layouts.menu.mission.mission_monitoring') }}
                </a>
            </li>
        @endcan

        @can('index', mission())
        <li>
            <a href="{{ route('mission.index') }}">
                <i class="fa fa-fw fa-handshake-o"></i> {{ __('layouts.menu.mission.missions') }}
            </a>
        </li>
        @endcan
    </ul>
</li>