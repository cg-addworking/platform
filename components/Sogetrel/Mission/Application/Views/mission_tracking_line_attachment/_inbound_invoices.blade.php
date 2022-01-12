@forelse (Repository::missionTrackingLineAttachment()->getInboundInvoices($mission_tracking_line_attachment) as $inbound_invoice)
    <a href="{{ $inbound_invoice->routes->show }}">@uuid($inbound_invoice->id) {{ $inbound_invoice->views->status }}</a>
    @unless($loop->last)
        <br>
    @endunless
@empty
    @include('foundation::layout.app._na')
@endforelse
