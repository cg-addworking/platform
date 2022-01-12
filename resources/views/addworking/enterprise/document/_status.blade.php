@inject('documentRepository', "App\Repositories\Addworking\Enterprise\DocumentRepository")

@if($document && $document->exists)
    @php
        $commentsOfRejection = [];
        foreach ($document->comments as $comment) {
            if(starts_with($comment->content, __('addworking.enterprise.document._status.refusal_comment'))) {
                $commentsOfRejection[] = $comment;
            }
        }
        if ($commentsOfRejection) {
            $latestComment = collect($commentsOfRejection)->sortByDesc('created_at')->first()->content;
            $count = strlen($latestComment);
            $status = ($count >= 250) ? substr($latestComment, 0, 250)."[...]" : $latestComment;
        }
    @endphp
    @switch($document->status)
        @case('pending_signature')
            <a href="{{ $document->routes->show }}#nav-info-tab"><span class="badge badge-pill badge-primary">{{ __('addworking.enterprise.document._status.pending_signature') }}</span></a>
            @break
        @case('pending')
            @if(auth()->user()->isSupport() && $documentRepository->isPreCheck($document))
                <a href="{{ $document->routes->show }}#nav-info-tab"><span class="badge badge-pill badge-secondary">{{ __('addworking.enterprise.document._status.precheck') }}</span></a>
            @else
                <a href="{{ $document->routes->show }}#nav-info-tab"><span class="badge badge-pill badge-primary">{{ __('addworking.enterprise.document._status.waiting') }}</span></a>
            @endif
            @break

        @case('validated')
            <a href="{{ $document->routes->show }}#nav-info-tab"><span class="badge badge-pill badge-success">{{ __('addworking.enterprise.document._status.valid') }}</span></a>
            @break

        @case('outdated')
            <a href="{{ $document->routes->show }}#nav-info-tab"><span class="badge badge-pill badge-default">{{ __('addworking.enterprise.document._status.expired') }}</span></a>
            @break

        @case('rejected')
            <div data-toggle='tooltip' data-placement='left' data-html='true' title="{{ $status ?? '' }}">
                <a href="{{ $document->routes->show }}#nav-info-tab"><span class="badge badge-pill badge-danger">{{ __('addworking.enterprise.document._status.rejected') }}</span></a>
                @isset($document->reason_for_rejection)
                    <br><small class="text-muted">{{ $documentRepository->getDocumentRejectReasonText($document->reason_for_rejection) ?? 'n/a' }}</small>
                @endisset
            </div>
            @break
    @endswitch
@else
    <span class="badge badge-pill badge-warning">{{ __('addworking.enterprise.document._status.missing') }}</span>
@endif
