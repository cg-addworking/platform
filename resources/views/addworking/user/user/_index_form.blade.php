@inject('repo', "App\Repositories\Addworking\User\UserRepository")

<div class="row">
    <div class="col-md-3">
        <div class="card @if(! request('filter.type')) bg-primary text-light @endif" data-filter-type="">
            <div class="card-body">
                <h2>{{ $repo->list()->count() }}</h2>
                <span>{{ __('addworking.user.user._index_form.all') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card @if(request('filter.type') == "vendor") bg-primary text-light @endif" data-filter-type="vendor">
            <div class="card-body">
                <h2>{{ $repo->list()->ofType('vendor')->count() }}</h2>
                <span>{{ __('addworking.user.user._index_form.providers') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card @if(request('filter.type') == "customer") bg-primary text-light @endif" data-filter-type="customer">
            <div class="card-body">
                <h2>{{ $repo->list()->ofType('customer')->count() }}</h2>
                <span>{{ __('addworking.user.user._index_form.clients') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card @if(request('filter.type') == "support") bg-primary text-light @endif" data-filter-type="support">
            <div class="card-body">
                <h2>{{ $repo->list()->ofType('support')->count() }}</h2>
                <span>{{ __('addworking.user.user._index_form.support') }}</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('[data-filter-type]').click(function(event) {
                $(':input[name="filter[type]"]').val($(this).attr('data-filter-type')).parents('form').submit();
            }).css('cursor', 'pointer');
        });
    </script>
@endpush
