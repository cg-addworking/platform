@component('layout.app._table_row_empty')
    {{ __('enterprise.resource.application.views.activity_period._table_row_empty.text_1') }} {{ $activity_period->customer->views->link }} {{ __('enterprise.resource.application.views.activity_period._table_row_empty.text_2') }}
    @slot('create')
    @endslot
@endcomponent
