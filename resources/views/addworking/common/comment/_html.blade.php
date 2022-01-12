
<p>{!! $comment->getContentHtmlAttribute() !!}</p>
<p class="text-right">
    <small>
        {{ __('addworking.common.comment._html.added_by') }} :
        @if(auth()->user()->isSupport())
            {{ optional($comment->author)->name ?? 'n/a' }} (@date($comment->created_at)) - (@lang("messages.comment.visibility.{$comment->visibility}"))
        @elseif($comment->author->isSupport())
            Le service Conformité AddWorking
        @else
            {{ optional($comment->author)->name ?? 'n/a' }} (@date($comment->created_at)) - (@lang("messages.comment.visibility.{$comment->visibility}"))
        @endif

        @can('destroy', $comment)
            -
            <a href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                <span class="text-danger">{{ __('addworking.common.comment._html.remove') }}</span>
            </a>
            @push('modals')
                <form name="{{ $name }}" action="{{ route('comment.destroy', $comment) }}" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            @endpush
        @endcan
    </small>
</p>
<hr>

