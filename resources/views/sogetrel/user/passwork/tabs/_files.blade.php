<div class="row">
    <p class="ml-3">
    @can('create', db_file())
        <a class="btn btn-success" href="{{ route("sogetrel.passwork.create-file", [$passwork->id]) }}" style="text-align: left">
            <i class="mr-2 fa fa-plus"></i> {{ __('sogetrel.user.passwork.tabs._files.add_file') }}
        </a>
    @endcan
    </p>
</div>

<h3> {{ __('sogetrel.user.passwork.tabs._files.title') }}</h3>
@forelse ($passwork->attachments as $file)
    @component('components.panel')
        <p><b>{{ __('sogetrel.user.passwork.tabs._files.created_date') }} </b>@date($file->created_at)</lpip>
        <p><b>{{ __('sogetrel.user.passwork.tabs._files.owner') }} </b>{{ $file->owner->views->link }}</p>
        <p><b>{{ __('sogetrel.user.passwork.tabs._files.size') }} </b>{{ human_filesize($file->size) }}</p>
        <p>
        @can('show', $file)
            <span class="text-left mr-5">
                <a class="dropdown-item" href="{{ route('sogetrel.passwork.show-file', [$passwork, $file]) }}">
                    <i class="text-muted fa fa-eye"></i> {{ __('sogetrel.user.passwork.tabs._files.consult') }}
                </a>
            </span>
        @endcan
        @can('download', $file)
            <span class="text-right">
                <a class="dropdown-item" href="{{ route('file.download', $file) }}">
                    <i class="text-muted fa fa-download"></i> {{ __('sogetrel.user.passwork.tabs._files.download') }}
                </a>
            </span>
        @endcan
        </p>
    @endcomponent
@empty
    <span colspan="9" class="text-center">
        <div class="p-5">
            <i class="fa fa-frown-o"></i> @lang('messages.empty')
        </div>
    </span>
@endforelse

