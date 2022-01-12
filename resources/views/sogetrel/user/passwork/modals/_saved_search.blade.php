@component('components.modal', [
    'id'     => "save_search",
    'show_footer'   => true
])
    @slot('title')
        {{ __('sogetrel.user.passwork.modals._saved_search.title') }}
    @endslot

    @slot('slot')
        @component('components.form.group', ['type' => "text", 'name' => "name"])
            @slot('label')
                {{ __('sogetrel.user.passwork.modals._saved_search.label') }}
            @endslot
        @endcomponent
    @endslot

    @slot('footer')
        <button type="submit" name="save_search" class="btn btn-success mr-2">{{ __('sogetrel.user.passwork.modals._saved_search.save_search') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('sogetrel.user.passwork.modals._saved_search.close') }}</button>
    @endslot
@endcomponent
