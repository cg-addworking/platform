<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('sogetrel.user.passwork_saved_search._actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

    <a class="dropdown-item btn btn-default" style="margin: 0.5em" href="#" data-toggle="modal" data-target="#{{ $passwork_saved_search->id }}" >
        <i class="text-muted mr-3 fa fa-envelope"></i> {{ __('sogetrel.user.passwork_saved_search._actions.set_email_notification') }}
    </a>

    @push('modals')
        @component('components.form.modal', [
            'id'     => $passwork_saved_search->id,
            'action' => route('sogetrel.user.passwork.saved.search.schedule', $passwork_saved_search),
            'method' => 'post',
        ])
            @slot('title')
                {{ __('sogetrel.user.passwork_saved_search._actions.setting_email_notification') }}
            @endslot

            @component('components.form.group', [
                'name' => "email",
                'type'=> "email",
                'placeholder' => "votremail@email.com",
                'label'      => __('sogetrel.user.passwork_saved_search._actions.email_where_sent'),
                'required' => true
            ])
            @endcomponent

            @component('components.form.group', [
                'name' => "frequency",
                'type' => "number",
                'min' => "1",
                'max' => "7",
                'value' => "7",
                'label'      => __('sogetrel.user.passwork_saved_search._actions.frequency_in_days'),
                'required' => true
            ])
            @endcomponent
        @endcomponent
    @endpush

    <a class="dropdown-item btn btn-default" style="margin: 0.5em" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">{{ __('sogetrel.user.passwork_saved_search._actions.remove') }}</span>
    </a>
    <form name="{{ $name }}" action="{{ route('sogetrel.saved_search.destroy', $passwork_saved_search) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>

    </div>
</div>
