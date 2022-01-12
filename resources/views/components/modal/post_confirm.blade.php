<form id="{{ $id }}" action="{{ $action ?? '#' }}" method="POST" class="modal fade {{ $class ?? '' }}" tabindex="-1" role="dialog">
    @csrf
    @method($method ?? 'post')
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header pull-left">
                <h4 class="modal-title" id="{{ $id ?? "" }}-label">
                    {{ $title ?? "" }}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('components.modal.post_confirm.no') }}</button>
                <button type="submit" class="btn btn-success">{{ $submit ?? __('components.modal.post_confirm.yes') }}</button>
            </div>
        </div>
    </div>
</form>
