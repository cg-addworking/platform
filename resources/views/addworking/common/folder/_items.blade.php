<table class="table table-hover">
        <colgroup>
            <col width="20%">
            <col width="25%">
            <col width="20%">
            <col width="10%">
        </colgroup>

        <thead>
            @th(__('addworking.common.folder._html.label').'|not_allowed')
            @th(__('addworking.common.folder._html.description').'|not_allowed')
            @th(__('addworking.common.folder._html.created_at').'|not_allowed')
            @th(__('addworking.common.folder._html.actions').'|not_allowed|class:text-right')
        </thead>

        <tbody>
            <tr>
                @foreach ($folder->getItems() as $item)
                    <tr>
                        <td>{{ $item->display_name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>@date($item->created_at)</td>
                        <td class="text-right">
                            <a href="{{ route('file.iframe', $item->document_model_id) }}" class="btn btn-small">
                                <i class="text-muted fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </tbody>
    </table>
