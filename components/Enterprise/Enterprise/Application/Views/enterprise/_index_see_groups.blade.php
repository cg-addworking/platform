@inject('repo', 'Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository')
@inject('family', 'App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository')

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body @if(! request('filter.type')) bg-primary text-light @endif" data-filter-type="">
                <h2>{{ enterprise([])->count() }}</h2>
                <span>{{ __('addworking.enterprise.enterprise._index_form.all_companies') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body @if(request('filter.type') == "customer") bg-primary text-light @endif" data-filter-type="customer">
                <h2>{{ enterprise([])->ofType('customer')->count() }}</h2>
                <span>Clients</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body @if(request('filter.type') == "vendor") bg-primary text-light @endif" data-filter-type="vendor">
                <h2>{{ enterprise([])->ofType('vendor')->count() }}</h2>
                <span>{{ __('addworking.enterprise.enterprise._index_form.providers') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body @if(request('filter.type') == "customer+vendor") bg-primary text-light @endif" data-filter-type="customer+vendor">
                <h2>{{ enterprise([])->ofType('customer')->ofType('vendor')->count() }}</h2>
                <span>{{ __('addworking.enterprise.enterprise._index_form.hybrid') }}</span>
            </div>
        </div>
    </div>
</div>

@if(request('filter.type') == "customer")
    <div class="row">
        @foreach($family->getCustomerGroups() as $name => $group)
            <div class="col-md-3 mb-3">
                <div class="card @if(request('filter.family') == $name) bg-primary text-light @endif" data-filter-family="{{ $name }}">
                    <div class="card-body">
                        <h2>{{ $group->count() }} <small>{{ __('addworking.enterprise.enterprise._index_form.subsidiaries') }}</small></h2>
                        <span>{{ $name }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <input type="hidden" name="filter[family]" value="{{ request('filter.family') }}">
@endif

@push('scripts')
    <script>
        $(function() {
            $('[data-filter-type]').click(function(event) {
                $(':input[name="filter[type]"]').val($(this).attr('data-filter-type')).parents('form').submit();
            }).css('cursor', 'pointer');

            $('[data-filter-family]').click(function(event) {
                $(':input[name="filter[family]"]').val($(this).attr('data-filter-family')).parents('form').submit();
            }).css('cursor', 'pointer');
        });
    </script>
@endpush
