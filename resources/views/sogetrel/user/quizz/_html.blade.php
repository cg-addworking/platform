<h4 id="{{ $quizz->id }}">
    {{ __('sogetrel.user.quizz._html.so_quiz') }} - {{ $quizz->passwork->user->name }}
    <a href="{{ route('sogetrel.passwork.quizz.show', [$quizz->passwork, $quizz]) }}" data-toggle="tooltip" title="Permalien">
        <i class="fa fa-link"></i>
    </a>
</h4>

<p>
    <small class="text-muted" data-toggle="tooltip" title="{{ __('sogetrel.user.quizz._html.username') }}">
        <i class="fa fa-key"></i> {{ $quizz->id }}
    </small>
</p>

<hr>

<p>
    <i class="fa fa-link text-muted fa-fw mr-2"></i> <a href="{{ $quizz->url }}">{{ $quizz->url }}</a>
</p>

<div class="row">
    <div class="col-md-6">
        @component('components.attribute', ['icon' => "info", 'name' => __('sogetrel.user.quizz._html.job')])
              {{ __('sogetrel.user.passwork.quizz.' . $quizz->job) }}
        @endcomponent

        @component('components.attribute', ['icon' => "info", 'name' => __('sogetrel.user.quizz._html.score')])
            {{ $quizz->score }}
        @endcomponent

        @component('components.attribute', ['icon' => "info", 'name' => __('sogetrel.user.quizz._html.level')])
            @include('sogetrel.user.passwork.quizz._level')
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('components.attribute', ['icon' => "info", 'name' => __('sogetrel.user.quizz._html.status')])
            @include('sogetrel.user.passwork.quizz._status')
        @endcomponent

        @component('components.attribute', ['icon' => "info", 'name' => __('sogetrel.user.quizz._html.proposed_on')])
            @date($quizz->proposed_at)
        @endcomponent

        @component('components.attribute', ['icon' => "info", 'name' => __('sogetrel.user.quizz._html.completed_at')])
            @date($quizz->completed_at)
        @endcomponent
    </div>
</div>
