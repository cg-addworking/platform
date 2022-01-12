<!-- DataLayer -->
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        environment: '{{ env('APP_ENV') }}',
    });
    @if (auth()->check())
        window.dataLayer.push({
            addworking: {
                isSupport: '{{ (optional(auth()->user())->isSupport() || optional(auth()->user())->isImpersonated()) ? '1' : '0' }}',
                isVendor: '{{ optional(auth()->user())->enterprise->isVendor() ? '1' : '0' }}',
                isCustomer: '{{ optional(auth()->user())->enterprise->isCustomer() ? '1' : '0' }}'
            }
        });
    @endif
</script>
<!-- DataLayer -->