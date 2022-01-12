<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{__('addworking.enterprise.iban._actions.actions')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

 @if ($iban->attachments->first())
    <a class="dropdown-item" href="{{ route('file.download', $iban->attachments->first()) }}" class="btn btn-default">
        <i class="fa fa-download"></i> {{ __('addworking.enterprise.iban._actions.download') }}
    </a>
@endif

@can('edit', $iban)
    <a class="dropdown-item" href="{{ route('enterprise.iban.create', $iban->enterprise) }}" class="btn btn-warning mr-2">
        <i class="mr-2 fa fa-pencil"></i> {{ __('addworking.enterprise.iban._actions.replace') }}
    </a>
@endcan

    </div>
</div>
