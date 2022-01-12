<form id="{{ $id }}" action="{{ $action ?? '#' }}" method="POST" class="modal fade {{ $class ?? '' }}" tabindex="-1" role="dialog" {{ $enctype ?? '' }}>
    @method($method ?? 'post')
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ $title ?? "" }}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                @csrf
                {{ $slot }}
            </div>

            @if ($show_footer ?? true)
                <div class="modal-footer">
                    @if (isset($footer))
                        {{ $footer }}
                    @else
                        <button type="submit" class="btn btn-success">
                            <i class="mr-2 fa fa-save"></i> {{ $submit ?? __('components.form.modal.register') }}
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</form>
