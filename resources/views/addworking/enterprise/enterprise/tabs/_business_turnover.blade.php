<div class="tab-pane fade show" id="nav-business-turnover" role="tabpanel" aria-labelledby="nav-business-turnover-tab">
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('addworking.enterprise.enterprise.tabs._business_turnover.year') }}</th>
            <th>{{ __('addworking.enterprise.enterprise.tabs._business_turnover.amount') }}</th>
            <th>{{ __('addworking.enterprise.enterprise.tabs._business_turnover.created_by_name') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($enterprise->businessTurnovers()->get() as $business_turnover)
            <tr>
                <td>{{ $business_turnover->getYear() }}</td>
                <td>
                    @money($business_turnover->getAmount())
                    @if($business_turnover->getNoActivity())
                        {{__('addworking.enterprise.enterprise.tabs._business_turnover.no_activity_message')}}
                    @endif
                </td>
                <td>{{ $business_turnover->getCreatedByName() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
