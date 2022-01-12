@if($quizz->score >= 0 && $quizz->score < 10)
   <i data-toggle="tooltip" data-original-title="{{ __('sogetrel.user.quizz._level.score_obtained') }}: {{ $quizz->score }}/20" class="text-warning fa fa-fw fa-thermometer-0"></i>
@elseif($quizz->score >= 10 && $quizz->score < 14)
    <i data-toggle="tooltip" data-original-title="{{ __('sogetrel.user.quizz._level.score_obtained') }}: {{ $quizz->score }}/20" class="text-info fa fa-fw mr-1 fa-thermometer-2"></i>
@elseif($quizz->score >= 14 && $quizz->score <= 20)
    <i data-toggle="tooltip" data-original-title="{{ __('sogetrel.user.quizz._level.score_obtained') }}: {{ $quizz->score }}/20" class="text-success fa fa-fw mr-1 fa-thermometer-4"></i>
@endif
