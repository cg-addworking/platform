<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('sogetrel.user.quizz._actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

@can('view', $quizz)
    <li>
        <a href="{{ route('sogetrel.passwork.quizz.show', [$quizz->passwork, $quizz]) }}">
            <i class="text-muted mr-3 fa fa-eye"></i> {{ __('sogetrel.user.quizz._actions.consult') }}
        </a>
    </li>
@endcan

@can('update', $quizz)
    <li>
        <a href="{{ route('sogetrel.passwork.quizz.edit', [$quizz->passwork, $quizz]) }}">
            <i class="text-muted mr-3 fa fa-edit"></i> {{ __('sogetrel.user.quizz._actions.edit') }}
        </a>
    </li>
@endcan

@can('delete', $quizz)
    <li role="separator" class="divider"></li>
    <li>
        <a href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">{{ __('sogetrel.user.quizz._actions.remove') }}</span>
        </a>
        <form name="{{ $name }}" action="{{ route('sogetrel.passwork.quizz.destroy', [$quizz->passwork, $quizz]) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    </li>
@endcan

    </div>
</div>
