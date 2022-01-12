@extends('foundation::layout.app.show')

@section('title', 'Recherche attachements Sogetrel')

@section('toolbar')
    @button(__('sogetrel.enterprise._html.return')."|href:".route('dashboard')."|icon:arrow-left|color:outline-primary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('sogetrel.enterprise._html.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('sogetrel.enterprise._html.attachments_search')."|active")
@endsection

@section('content')
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item"  src="https://app.miniextensions.com/grid-portal/iaPrVuRvoFHGyFQI0LSw/" style="max-width:100%" frameborder="0"></iframe>
    </div>
@endsection
