<div class="enterprise-finder" data-finder-url="{{ route('enterprise.finder') }}" data-finder-filter="{{ json_encode($filter ?? null) }}" {{ attr($_attributes ?? []) }}>
    <input type="hidden" name="{{ dot_to_input($name ?? 'enterprise[id]') }}" value="{{ $value ?? '' }}">
    <div class="input-group mb-3">
        <input type="text" class="form-control" data-finder="enterprise-name" placeholder="@lang($placeholder ?? __('components.enterprise_finder.enterprise'))">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">
                @icon('search')
            </button>
        </div>
    </div>
    <div class="alert alert-danger" style="display: none" role="alert">
        {{ __('components.enterprise_finder.error_occurred') }}
        <a href="mailto:support+technique{{'@'}}addworking.com">support</a>
    </div>
    <small data-text="{{ __('components.enterprise_finder.companies_found') }}"></small>
    <ul class="list-group mt-1" style="max-height: 250px; overflow-y: auto"></ul>
</div>
