<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-header">
            <div class="user-pic">
              <img class="img-responsive img-rounded" src="" alt="User picture">
            </div>
            <div class="user-info">
                <span class="user-name">John<strong>Doe</strong></span>
                <span class="user-role">@badge('Admin')</span>
            </div>
            <div id="close-sidebar" class="d-flex justify-content-end">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-search">
            <div>
                <div class="input-group">
                    <input type="text" class="form-control search-menu" placeholder="Rechercher...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="#">@icon('desktop')<span>{{ __('layouts.dashboard._sidebar.dashboard') }}</span></a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">@icon('users')<span>{{ __('layouts.dashboard._sidebar.users') }}</span></a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>@anchor('Membres')</li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">@icon('check-square')<span>{{ __('layouts.dashboard._sidebar.contracts') }}</span></a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>@anchor('Contrats')</li>
                            <li>@anchor('Maquettes')</li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">@icon('building')<span>{{ __('layouts.dashboard._sidebar.enterprise') }}</span></a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>@anchor('Entreprises')</li>
                            <li>@anchor('Documents')</li>
                            <li>@anchor('Filliales')</li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">@icon('handshake')<span>{{ __('layouts.dashboard._sidebar.missions') }}</span></a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>@anchor('Offres')</li>
                            <li>@anchor('Propositions')</li>
                            <li>@anchor('Missions')</li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#">@icon('address-card')<span class="menu-text">{{ __('layouts.dashboard._sidebar.passwork') }}</span></a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">@icon('file-invoice')<span>{{ __('layouts.dashboard._sidebar.bills') }}</span></a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>@anchor('Factures entrantes')</li>
                            <li>@anchor('Factures sortantes')</li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">@icon('file')<span>{{ __('layouts.dashboard._sidebar.documents') }}</span></a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>@anchor('Documents')</li>
                            <li>@anchor('Gestion des documents')</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
