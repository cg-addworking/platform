@component('components.panel', ['icon' => "comment-o"])
    <form action="{{ route('sogetrel.passwork.comment', $passwork) }}" method="POST">
        @csrf
        @method('put')

        @component('components.form.group', [
            'type'       => "textarea",
            'name'       => "comment",
            'value'      => $passwork->comment,
            'required'   => true,
            'label'      => __('sogetrel.user.passwork.tabs._comment.comments'),
        ])
        @endcomponent

        @button(__('sogetrel.user.passwork.tabs._comment.save')."|type:submit|color:success|shadow")
    </form>
@endcomponent
