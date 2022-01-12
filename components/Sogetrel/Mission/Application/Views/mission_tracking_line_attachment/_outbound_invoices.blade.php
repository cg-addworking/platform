@forelse (Repository::missionTrackingLineAttachment()->getOutboundInvoices($mission_tracking_line_attachment) as $outbound_invoice)
    @if ($outbound_invoice instanceof Components\Billing\Outbound\Application\Models\OutboundInvoice)
        <span class="badge badge-primary badge-pill">v2</span>
    @endif
    <a href="{{ $outbound_invoice->routes->show }}">@uuid($outbound_invoice->id) {{ $outbound_invoice->views->status }}</a>
    @unless($loop->last)
        <br>
    @endunless
@empty
    @include('foundation::layout.app._na')
@endforelse
