<div id="{{ $file->id }}">
    <p>
        <b>{{ __('addworking.common.file._summary.file') }}</b> {{ basename($file->path) }} <small class="text-muted">{{ human_filesize($file->size) }}</small>
    </p>

    <a href="{{ route('file.download', $file) }}" class="btn btn-default">
        <i class="fa fa-fw fa-download"></i> @lang('messages.download')
    </a>

    <a href="{{ route('file.destroy', $file) }}" class="btn btn-danger" @tooltip("Supprimer")>
        <i class="fa fa-fw fa-trash"></i>
    </a>
</div>
