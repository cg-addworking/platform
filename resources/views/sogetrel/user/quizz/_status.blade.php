@switch($quizz->status)
    @case('pending')
        <span class="text-warning">
            <i class="fa fa-fw mr-1 fa-clock-o"></i> {{ __('sogetrel.user.quizz._status.waiting') }}
        </span>
        @break
    @case('done')
        <span class="text-success">
            <i class="fa fa-fw mr-1 fa-check"></i> {{ __('sogetrel.user.quizz._status.fact') }}
        </span>
        @break
@endswitch
