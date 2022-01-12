<div class="tab-pane fade show" id="nav-vendor" role="tabpanel" aria-labelledby="nav-vendor-tab">
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('addworking.enterprise.enterprise.tabs._vendor.company') }}</th>
            <th>{{ __('addworking.enterprise.enterprise.tabs._vendor.legal_representative') }}</th>
            <th class="text-right">{{ __('addworking.enterprise.enterprise.tabs._vendor.provide_since') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($enterprise->vendors()->orderBy('name')->get() as $vendor)
            <tr>
                <td>{{ $vendor->views->link }}</td>
                <td>{{ optional(optional($vendor->legalRepresentatives()->first())->views)->link }}</td>
                <td class="text-right">@date($vendor->pivot->created_at)</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
