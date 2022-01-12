<li>
    <a data-toggle="collapse" href="#menu-user-collapse" aria-expanded="false" aria-controls="menu-user-collapse">
        <i class="fa fa-fw fa-building-o"></i> {{ __('layouts.menu.enterprise.enterprise') }}
        <span class="caret"></span>
    </a>

    <ul class="collapse" id="menu-user-collapse">
        <li>
            <a href="{{ route('enterprise.show', auth()->user()->enterprise) }}">
                <i class="fa fa-fw fa-black-tie"></i> {{ __('layouts.menu.enterprise.my_company') }}
            </a>
        </li>

        @if (auth()->user()->enterprise->iban->exists)
            <li>
                <a href="{{ route('enterprise.iban.show', ['enterprise' => auth()->user()->enterprise, 'iban' => auth()->user()->enterprise->iban]) }}">
                    <i class="fa fa-fw fa-credit-card"></i> {{ __('layouts.menu.enterprise.my_iban') }}
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('enterprise.iban.create', auth()->user()->enterprise) }}">
                    <i class="fa fa-fw fa-credit-card"></i> {{ __('layouts.menu.enterprise.my_iban') }}
                </a>
            </li>
        @endif

        @if (auth()->user()->sogetrelPasswork->exists && auth()->user()->enterprise->isVendor() && auth()->user()->can('edit', auth()->user()->sogetrelPasswork))
            <li>
                <a href="{{ route('sogetrel.passwork.edit', auth()->user()->sogetrelPasswork) }}">
                    <i class="fa fa-fw fa-check"></i> {{ __('layouts.menu.enterprise.my_passwork') }}
                </a>
            </li>
        @endcan

        @if(auth()->user()->enterprise->isVendor())
            <li>
                <a href="{{ route('addworking.enterprise.document.index', auth()->user()->enterprise) }}">
                    <i class="fa fa-fw fa-files-o"></i> {{ __('layouts.menu.enterprise.my_certificates') }}
                </a>
            </li>
        @endif
    </ul>
</li>
