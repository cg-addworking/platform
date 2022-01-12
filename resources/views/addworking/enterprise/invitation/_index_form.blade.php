@inject('invitationRepository', 'App\Repositories\Addworking\Enterprise\InvitationRepository')

<div class="row">
    <div class="col-md-2 mb-3">
        <div class="card">
            <div class="card-body @if(! request('filter.status')) bg-primary text-light @endif" data-filter-status="">
                <h2>{{ $invitationRepository->list()->ofCustomer(request('enterprise'))->count() }}</h2>
                <span>{{ __('addworking.enterprise.invitation._index_form.all_invitations') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body @if(request('filter.status') == "accepted") bg-primary text-light @endif" data-filter-status="accepted">
                <h2>{{ $invitationRepository->list()->ofCustomer(request('enterprise'))->ofStatus('accepted')->count() }}</h2>
                <span>{{ __('addworking.enterprise.invitation._index_form.accepted') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card">
            <div class="card-body @if(request('filter.status') == "pending") bg-primary text-light @endif" data-filter-status="pending">
                <h2>{{ $invitationRepository->list()->ofCustomer(request('enterprise'))->ofStatus('pending')->count() }}</h2>
                <span>{{ __('addworking.enterprise.invitation._index_form.pending') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card">
            <div class="card-body @if(request('filter.status') == "in_progress") bg-primary text-light @endif" data-filter-status="in_progress">
                <h2>{{ $invitationRepository->list()->ofCustomer(request('enterprise'))->ofStatus('in_progress')->count() }}</h2>
                <span>{{ __('addworking.enterprise.invitation._index_form.in_progress') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card">
            <div class="card-body @if(request('filter.status') == "rejected") bg-primary text-light @endif" data-filter-status="rejected">
                <h2>{{ $invitationRepository->list()->ofCustomer(request('enterprise'))->ofStatus('rejected')->count() }}</h2>
                <span>{{ __('addworking.enterprise.invitation._index_form.rejected') }}</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('[data-filter-status]').click(function(event) {
                $(':input[name="filter[status]"]').val($(this).attr('data-filter-status')).parents('form').submit();
            }).css('cursor', 'pointer');
        });
    </script>
@endpush
