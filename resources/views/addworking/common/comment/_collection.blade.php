@if (auth()->check())
    @foreach($comments as $comment)
        <div class="col-12">
            @can('show', $comment)
                {{ $comment->views->html }}
            @endcan
        </div>
    @endforeach
@endif
