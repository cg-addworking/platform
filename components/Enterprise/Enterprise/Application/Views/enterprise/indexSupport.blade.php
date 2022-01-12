@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.enterprise.index.enterprise'))

@section('toolbar')
    @button(__('addworking.enterprise.enterprise.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('addworking.enterprise.enterprise.index.create')."|href:".route('enterprise.add')."|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.enterprise.index.enterprise')."|active")
@endsection

@section('form')
    @include('enterprise::enterprise._index_see_groups')
    <hr>
    @include('enterprise::enterprise._filters')
@endsection

@section('table.head')
    @th(__('addworking.enterprise.enterprise.index.name')."|column:name")
    @th(__('addworking.enterprise.enterprise.index.type')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.legal_representative')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.phone')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.main_activity_code')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.actions')."|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $enterprise)
        <tr>
            <td><a href="{{route('enterprise.show', $enterprise)}}">{{ $enterprise->legalForm->display_name }} - {{ $enterprise->name }}</a></td>
            <td>@include('addworking.enterprise.enterprise._badges')</td>
            <td>{{ optional(optional($enterprise->legalRepresentatives->first())->views)->link }}</td>
            <td>{{ $enterprise->primary_phone_number }}</td>
            <td>{{ $enterprise->main_activity_code }} ({{ $enterprise->activity->field }})</td>
            <td class="text-right">{{ $enterprise->views->actions }}</td>
        </tr>
    @endforeach
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('[role=filter] :input').not('select[multiple]').change(function () {
                $(this).parents('form').first().submit();
            });

            $(document).on('changed.bs.select', '.bootstrap-select', function () {
                $(this).data('has-changed', true);
            })

            $(document).on('hidden.bs.select', '.bootstrap-select', function () {
                if ($(this).data('has-changed')) {
                    $(this).parents('form').first().submit();
                }
            });
        })
    </script>
@endpush