@extends('foundation::layout.app.index')

@section('title', __('addworking.user.log.index.user_logs'))

@section('toolbar')
    @can('export', \App\Models\Addworking\User\UserLog::class)
        @button(__('addworking.user.log.index.export_sogetrel_user_activities')."|href:".route('log.user.export')."?enterprise=OGETR|icon:file-export|color:outline-success|outline|sm")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.log.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.log.index.user_logs')."|active")
@endsection

@section('table.head')
    @th(__('addworking.user.log.index.email')."|not_allowed")
    @th(__('addworking.user.log.index.http_method')."|not_allowed")
    @th(__('addworking.user.log.index.rout')."|not_allowed")
    @th(__('addworking.user.log.index.url')."|not_allowed")
    @th(__('addworking.user.log.index.ip')."|not_allowed")
    @th(__('addworking.user.log.index.impersonating')."|not_allowed")
    @th(__('addworking.user.log.index.date')."|not_allowed")
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse($items as $log)
        <tr>
            <td>{{ \App\Models\Addworking\User\User::find($log->user_id)->email }}</td>
            <td>{{ $log->http_method }}</td>
            <td>{{ $log->route }}</td>
            <td>{{ $log->url }}</td>
            <td>{{ $log->ip }}</td>
            <td>{{ $log->impersonating ? 'OUI' : 'NON' }}</td>
            <td>@datetime($log->created_at)</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">
                <div class="p-5">
                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                </div>
            </td>
        </tr>
    @endforelse
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).on('click', '.btn-log-details', function () {
            var modal = $('#detailModal');
            var inputs = $(this).data('inputs');
            var headers = $(this).data('headers');
            var html = '';

            if (inputs && inputs.length !== 0) {
                html += '<p class="text-uppercase"><strong>Information input</strong></p>';
                html += '<p style="word-wrap: break-word">' + JSON.stringify(inputs) + '</p>'
            }

            if (headers && headers.length !== 0) {
                html += '<p class="text-uppercase"><strong>Information Header</strong></p>';
                html += '<p style="word-wrap: break-word">' + JSON.stringify(headers) + '</p>'
            }

            modal.find('.modal-body').html(html);
            modal.find('.modal-dialog').addClass('modal-lg');
            modal.modal('show');
        });
    </script>
@endpush
