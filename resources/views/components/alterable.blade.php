<div class="alterable" data-save-to="{{ $action }}">
    <div class="alterable-content">
        <span class="alterable-value">{{ $slot }}</span>
        <span class="alterable-button"><i class="text-muted fa fa-fw fa-pencil"></i></span>
    </div>

    <div class="alterable-input input-group input-group-sm hidden">
        @include('components.form.control', ['name' => "value", 'value' => $value ?? trim($slot)])

        <div class="input-group-btn">
            <button class="alterable-button alterable-button-save btn btn-default">
                <span class="text-success"><i class="fa fa-check"></i> {{ __('components.alterable.save') }}</span>
            </button>
            <button class="alterable-button alterable-button-cancel btn btn-default">
                <span class="text-muted"><i class="fa fa-times"></i></span>
            </button>
        </div>
    </div>
    
    <div class="alterable-errors"></div>
</div>
