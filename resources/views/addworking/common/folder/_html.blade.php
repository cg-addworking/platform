<div class="row">
    <div class="col-md-8">
        @attribute("{$folder}|icon:tag|label:".__('addworking.common.folder._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$folder->id}|icon:id-card-alt|label:".__('addworking.common.folder._html.username'))
        @component('bootstrap::attribute', ['icon' => 'id-card-alt','label' => __('addworking.common.folder._html.owner')])
            {{ $folder->createdBy->views->link }}
        @endcomponent
        @attribute("{$folder->created_at}|icon:calendar-plus|label:".__('addworking.common.folder._html.created_at'))
        @attribute("{$folder->updated_at}|icon:calendar-check|label:".__('addworking.common.folder._html.last_modified_date'))
        @attribute(__('addworking.common.folder.'.$folder->shared_with_vendors)."|icon:share|label:".__('addworking.common.folder._html.folder_shared_with_service_providers'))
    </div>
</div>
