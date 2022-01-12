<div id="{{ $id }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog{{ $large ?? false ? ' modal-lg' : '' }}" {{ attr_if($xlarge ?? false, ['style' => "width: 80%"]) }} role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ $title ?? "" }}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            @if ($show_footer ?? true)
                <div class="modal-footer">
                    @if (isset($footer))
                        {{ $footer }}
                    @else
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('components.modal2.to_close') }}</button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
