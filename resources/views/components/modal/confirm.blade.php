<div class="modal fade" id="{{ $id ?? "" }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id ?? "" }}-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="{{ $id ?? "" }}-label">
                    {{ $title ?? "" }}
                </h4>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('components.modal.confirm.no') }}</button>
                <button type="button" class="btn btn-primary" id="{{ $btnYesId }}">{{ __('components.modal.confirm.yes') }}</button>
            </div>
        </div>
    </div>
</div>