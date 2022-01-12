<div class="wizard">
    @if ($stacked ?? false)
        <div class="row">
            <div class="col-md-3 wizard-header">
                <ul class="nav nav-pills nav-stacked">
                    {{ $nav }}
                </ul>
            </div>
            <div class="col-md-9 wizard-content">
                {{ $slot }}
            </div>
        </div>
    @else
        <div class="wizard-header">
            <ul class="nav nav-pills nav-justified thumbnail">
                {{ $nav }}
            </ul>
        </div>

        <div class="wizard-content">
            {{ $slot }}
        </div>
    @endif
</div>
