<div class="tab-pane fade show" id="nav-phone-number" role="tabpanel" aria-labelledby="nav-phone-number-tab">
    <div class="table-responsive">
        <table class="table table-hover">
            <colgroup>
                <col width="20%">
                <col width="50%">
                <col width="20%">
                <col width="10%">
            </colgroup>
            <thead>
            <th>{{ __('addworking.enterprise.enterprise.tabs._phone_number.phone_number') }}</th>
            <th>{{ __('addworking.enterprise.enterprise.tabs._phone_number.note') }}</th>
            <th>{{ __('addworking.enterprise.enterprise.tabs._phone_number.date_added') }}</th>
            <th>{{ __('addworking.enterprise.enterprise.tabs._phone_number.action') }}</th>
            </thead>
            <tbody>
            @forelse ($enterprise->phoneNumbers as $phone_number)
                <tr>
                    <td><a href="tel:{{$phone_number->number}}">{{ $phone_number->number }}</a></td>
                    <td>{{ $phone_number->pivot->note }}</td>
                    <td>@datetime($phone_number->created_at)</td>
                    <td>
                        @can('removePhoneNumbers', $enterprise)
                            <a href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">Supprimer</span>
                            </a>
                            <form name="{{ $name }}" action="{{ route('addworking.enterprise.phone_number.destroy', ['enterprise' => $enterprise, 'phone_number'=> $phone_number]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td>@lang('messages.empty')</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="text-right my-5">
        @button(__('addworking.enterprise.enterprise.tabs._phone_number.add')."|href:".route('addworking.enterprise.phone_number.create', $enterprise)."|icon:plus|color:outline-success|outline|sm")
    </div>
</div>
