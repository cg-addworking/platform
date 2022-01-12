@if ($passwork->pre_qualified_by)
    @component('components.panel')
        <h4>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.title') }}</h4>
        <b>{{ user($passwork->pre_qualified_by)->name }}</b>
    @endcomponent
@endif

@component('components.panel')
    @switch ($passwork->status)
        @case (sogetrel_passwork()::STATUS_ACCEPTED)
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span class="text-success">
                <i class="fa fa-check"></i> <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.accept') }}</b>
            </span>
            par <b>{{ is_object(user($passwork->accepted_by))? user($passwork->accepted_by)->name : "" }}</b>
            @break
        @case (sogetrel_passwork()::STATUS_ACCEPTED_QUEUED)
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span class="text-success">
                <i class="fa fa-check"></i> <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.accept_queue') }}</b>
            </span>
            par <b>{{ is_object(user($passwork->accepted_by))? user($passwork->accepted_by)->name : "" }}</b>
            @break
        @case (sogetrel_passwork()::STATUS_REFUSED)
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span class="text-danger">
                <i class="fa fa-times"></i> <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.reject') }}</b>
            </span>
            par <b>{{ is_object(user($passwork->refused_by))? user($passwork->refused_by)->name : "" }}</b>
            @break
        @case (sogetrel_passwork()::STATUS_PREQUALIFIED)
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span class="text-warning">
                <i class="fa fa-clock-o"></i> <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.prequalified') }}</b>
            </span>
            par <b>{{ is_object(user($passwork->pre_qualified_by))? user($passwork->pre_qualified_by)->name : "" }}</b>
            @break
        @case (sogetrel_passwork()::STATUS_BLACKLISTED)
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span style="color: black;">
                <i class="fa fa-exclamation-triangle"></i> <b> {{ __('sogetrel.user.passwork.tabs._operational_monitoring.blacklisted') }}</b>
            </span>
            par <b>{{ is_object(user($passwork->blacklisted_by))? user($passwork->blacklisted_by)->name : "" }}</b>
            @break
        @case (sogetrel_passwork()::STATUS_NOT_RESULTED)
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span class="text-warning">
                <i class="fa fa-phone"></i> <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.not_resulted') }}
            </span>
            @break
        @default
            <b>{{ __('sogetrel.user.passwork.tabs._operational_monitoring.status_of_passwork') }} </b>
            <span class="text-warning">
                <i class="fa fa-clock-o"></i> {{ __('sogetrel.user.passwork.tabs._operational_monitoring.waiting') }}
            </span>
    @endswitch
@endcomponent

<hr>

@component('components.panel')
    @slot('heading')
        {{ __('sogetrel.user.passwork.tabs._operational_monitoring.comments') }}
    @endslot

    <div class="tab-pane" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
        <div class="row">
            <div class="col-12 pl text-right">
                <a class="btn btn-outline-success" data-toggle="modal" data-target="#add-comment">
                    <i class="fa fa-plus"></i> {{ __('sogetrel.user.passwork.tabs._operational_monitoring.add_comment') }}
                </a>
                <hr>
            </div>

            @component('components.form.modal', ['id' => 'add-comment', 'action' => route('comment.store')])
                @slot('title')
                    {{ __('sogetrel.user.passwork.tabs._operational_monitoring.add_comment') }}
                @endslot

                <input type="hidden" name="comment[commentable_id]" value="{{ $passwork->id }}">
                <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($passwork)) }}">

                @form_group([
                    'text'     => __('sogetrel.user.passwork.tabs._operational_monitoring.comments'),
                    'type'     => "textarea",
                    'name'     => "comment.content",
                    'required' => true,
                    'rows'     => 10
                ])

                <input type="hidden" name="comment[visibility]" value="public">
            @endcomponent

            <div style="padding: 20px;">
                {{ $passwork->comments }}
            </div>
        </div>
    </div>
@endcomponent
