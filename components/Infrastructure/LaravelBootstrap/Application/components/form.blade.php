<form @attr('form_attr')>
    @csrf
    @if(isset($method) && !in_array(strtolower($method), ['get', 'post']))
        @method($method)
    @endif

    @if(isset($errors) && $errors instanceof Illuminate\Support\ViewErrorBag && $errors->any())
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">@lang('bootstrap.form.errors')</div>
            <div class="card-body">
                <ul class="pl-3 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if(isset($groups))
        @foreach ($groups as $group)
            @include('bootstrap::form.group', pipe_to_array($group))
        @endforeach
    @else
        {{ $text ?? $slot ?? '' }}
    @endif

    @isset($submit)
        @include('bootstrap::button', ['type' => "submit"] + pipe_to_array($submit))
    @endisset
</form>
