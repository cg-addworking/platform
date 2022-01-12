@attribute("{$file->id}|icon:key|label:".__('addworking.common.file._html.username'))

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.created_at'), 'icon' => "calendar-check"])
    @date($file->created_at)
@endcomponent

@support
    @component('bootstrap::attribute', ['label' => __('addworking.common.file._html.url'), 'icon' => "external-link-alt"])
        <a href="{{ $file->common_url }}" target="_blank">Ouvrir dans le navigateur</a>
    @endcomponent
@endsupport

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.name'), 'icon' => "file"])
    {{ $file->name ?? 'n/a' }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.path'), 'icon' => "file"])
    {{ $file->path }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.extension'), 'icon' => "folder-open"])
    {{ strtoupper($file->extension) }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.mime_type'), 'icon' => "file"])
    {{ $file->mime_type }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.cut'), 'icon' => "expand"])
    {{ $file->size_for_humans }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.common.file._html.owner'), 'icon' => "user"])
    {{ $file->owner->views->link }}
@endcomponent
