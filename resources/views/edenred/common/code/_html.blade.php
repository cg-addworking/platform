<div class="row">
    @attribute($code->code."|class:col-md-4|icon:info|label:".__('edenred.common.code._html.last_name'))

    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "info", 'label' => __('edenred.common.code._html.skill')])
        <a href="{{ route('addworking.common.enterprise.job.show',  [$code->skill->job->enterprise, $code->skill->job]) }}">{{ $code->skill->job->display_name }}</a>
    @endcomponent

    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "info", 'label' => __('edenred.common.code._html.competence')])
        <a href="{{ route('addworking.common.enterprise.job.skill.show', [$code->skill->job->enterprise, $code->skill->job, $code->skill]) }}">{{ $code->skill->display_name }}</a>
    @endcomponent

    @attribute($code->level.'|class:col-md-4|icon:info|label:'.__('edenred.common.code._html.level'))
</div>
