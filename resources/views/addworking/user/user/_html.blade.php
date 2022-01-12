@inject('enterpriseMemberRepository', "App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository")

<div class="col-md-8">
    <div class="card shadow">
        <div class="card-body">
            @attribute("{$user->name}|icon:user|label:".__('addworking.user.user._html.identity'))
            @attribute("{$user->email}|icon:envelope-open-text|label:".__('addworking.user.user._html.email'))
            @attribute(optional($user->created_at)->format('d/m/Y')."|icon:calendar|label:".__('addworking.user.user._html.registration_date'))

            @component('bootstrap::attribute', ['icon' => "phone-alt", 'label' => __('addworking.user.user._html.phone_number')])
                @forelse($user->phoneNumbers as $phone_number)
                    <a href="tel:{{ $phone_number->number }}">{{ $phone_number->number }}</a>
                    @unless ($loop->last)
                        --
                    @endunless
                @empty
                    n/a
                @endforelse
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "phone-alt", 'label' => __('addworking.user.user._html.enterprises')
                                . ' ('. count($enterpriseMemberRepository->getEnterprisesOf($user)) .')' ])
                <ul style="list-style:none">
                    @forelse($enterpriseMemberRepository->getEnterprisesOf($user)->sortBy('name') as $enterprise)
                        <li> <a href="{{ route('enterprise.show', $enterprise->id) }}" target="_blank">{{ $enterprise->name }}</a> </li>
                    @empty
                        n/a
                    @endforelse
                </ul>
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "tags", 'label' => __('addworking.user.user._html.tags')])
                {{ $user->views->tags }}
            @endcomponent
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card shadow">
        <div class="card-body">
            @component('bootstrap::attribute', ['label' => "UUID", 'icon' => "hashtag"])
                <span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $user->id }}" title="Copier dans le presse-papier" data-toggle="tooltip">{{ $user->id }}</span>
            @endcomponent

            @attribute("{$user->number}|icon:hashtag|label:".__('addworking.user.user._html.number'))

            @component('bootstrap::attribute', ['icon' => "power-off", 'label' => __('addworking.user.user._html.activation')])
                @bool($user->is_active) {{ $user->is_active ? __('addworking.user.user._html.active') : __('addworking.user.user._html.inactive') }}
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "clock", 'label' => __('addworking.user.user._html.last_authentication')])
                {{ optional($user->last_login)->diffForHumans() ?? 'n/a' }}
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "clock", 'label' => __('addworking.user.user._html.last_activity')])
                {{ optional($user->last_activity)->diffForHumans() ?? 'n/a' }}
            @endcomponent
        </div>
    </div>
</div>



