@inject('enterpriseMemberRepository', "App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository")
<div class="row">
    <div class="col-md-8">
        @if($enterprise->isCustomer())
            @component('bootstrap::attribute', ['icon' => "image", 'label' => "Logo"])
                <div class="col-md-3">
                    @if ($enterprise->logo->exists)
                        <img src="{{ $enterprise->logo->common_url }}"  class=" picture person img-thumbnail">
                    @else
                        {{ __('addworking.enterprise.enterprise._html.no_logo') }} ? <a href="{{$enterprise->routes->edit}}">{{ __('addworking.enterprise.enterprise._html.add_one') }}</a>
                    @endif

                </div>
            @endcomponent
        @endif

        @component('bootstrap::attribute', ['icon' => "building", 'label' => __('addworking.enterprise.enterprise._html.social_reason')])
            {{ strtoupper($enterprise->legalForm->name) }} - {{ $enterprise->name }}
            @if ($enterprise->parent->exists)
                <small>{{ __('addworking.enterprise.enterprise._html.affiliate') }} {{ $enterprise->parent->views->link }}</small>
            @endif
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "cog", 'label' => __('addworking.enterprise.enterprise._html.type')])
            {{ $enterprise->views->type }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.enterprise.enterprise._html.legal_representative')])
            {{ $enterprise->views->legal_representatives }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "map-marker-alt", 'label' => __('addworking.enterprise.enterprise._html.address')])
            {{ $enterprise->views->addresses }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "phone", 'label' => __('addworking.enterprise.enterprise._html.phone_number')])
            {{ $enterprise->views->phones }}
        @endcomponent

        @can('viewIbanInfo', $enterprise)
            @component('bootstrap::attribute', ['icon' => "money-check", 'label' => __('addworking.enterprise.enterprise._html.iban')])
                {{ $enterprise->views->iban }}
            @endcomponent
        @endcan

        @can('viewCustomersInfo', $enterprise)
            @component('bootstrap::attribute', ['icon' => "building", 'label' => __('addworking.enterprise.enterprise._html.customer')])
                {{ $enterprise->views->customers }}
            @endcomponent
        @endcan
        @can('viewShowMember', $enterprise)
            @component('bootstrap::attribute', ['icon' => "building", 'label' => __('addworking.enterprise.enterprise._html.customer')])
                <ul style="list-style:none">
                    @foreach($enterprise->customers as $customer)
                        @if($enterpriseMemberRepository->isMember($customer, Auth::user()))
                            <li> <a href="{{ route('enterprise.show', $customer->id) }}" target="_blank">{{ $customer->name }}</a> </li>
                        @endif
                    @endforeach
                </ul>
            @endcomponent
        @endcan
        @component('bootstrap::attribute', ['icon' => "cog", 'label' => __('addworking.enterprise.enterprise._html.activity')])
            {{ $enterprise->views->activities }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "city", 'label' => __('addworking.enterprise.enterprise._html.activity_department')])
            {{ $enterprise->views->departments }}
        @endcomponent

        @support
            @component('bootstrap::attribute', ['icon' => "info", 'label' => __('addworking.enterprise.enterprise._html.sectors')])
                <ul>
                    @forelse ($enterprise->sectors()->get() as $sector)
                        <li>{{$sector->getDisplayName()}}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            @endcomponent
        @endsupport
    </div>
    <div class="col-md-4">
        @can('viewIdInfo', $enterprise)
            @attribute("{$enterprise->id}|icon:key|label:".__('addworking.enterprise.enterprise._html.id'))
        @endcan
        @can('viewNumberInfo', $enterprise)
            @attribute("{$enterprise->number}|icon:hashtag|label:".__('addworking.enterprise.enterprise._html.number'))
        @endcan
        @can('viewClientIdInfo', $enterprise)
            @attribute(($enterprise->external_id ?? 'n/a')."|icon:hashtag|label:".__('addworking.enterprise.enterprise._html.client_id'))
        @endcan
        @attribute("{$enterprise->identification_number}|icon:hashtag|label:".__('addworking.enterprise.enterprise._html.siret'))
        @attribute(($enterprise->tax_identification_number ?? 'n/a')."|icon:hashtag|label:".__('addworking.enterprise.enterprise._html.vat_number'))

        @component('bootstrap::attribute', ['icon' => "cog", 'label' => __('addworking.enterprise.enterprise._html.applicable_vat')])
            @percentage($enterprise->vat_rate)
        @endcomponent

        @attribute(($enterprise->main_activity_code ?? 'n/a')."|icon:cog|label:".__('addworking.enterprise.enterprise._html.main_activity_code'))
        @attribute("{$enterprise->registration_town}|icon:city|label:".__('addworking.enterprise.enterprise._html.registration_town'))

        @can('viewTimestampInfo', $enterprise)
            @component('bootstrap::attribute', ['icon' => "calendar-alt", 'label' => __('addworking.enterprise.enterprise._html.created_the')])
                @date($enterprise->created_at)
            @endcomponent
            @component('bootstrap::attribute', ['icon' => "calendar-alt", 'label' => __('addworking.enterprise.enterprise._html.modified')])
                @date($enterprise->updated_at)
            @endcomponent
        @endcan
        @can('viewTagsInfo', $enterprise)
            @component('bootstrap::attribute', ['icon' => "tags", 'label' => "Tags"])
                {{ $enterprise->views->tags }}
            @endcomponent
        @endcan
    </div>
</div>
