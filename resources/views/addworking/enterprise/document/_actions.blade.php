@component('foundation::layout.app._actions', ['model' => $document])
    @can('download', $document)
        @action_item(__('addworking.enterprise.document._actions.download') ."|icon:download|href:{$document->routes->download}")
    @endcan

    @can('replace', $document)
        <a class="dropdown-item" href="{{ $document->routes->replace }}" onclick="confirm('{{ __('addworking.enterprise.document._actions.replacement_of_document') }}')">
            <i class="fa fa-redo mr-3 text-secondary"></i> {{ __('addworking.enterprise.document._actions.replace') }}
        </a>
    @endif

    @if(auth()->user()->can('tag', $document) && ! in_array('pre-check', $document->tagNames))
        @action_item(__('addworking.enterprise.document._actions.tag_in_precheck') ."|icon:shield-alt|href:{$document->routes->tag}?tag=pre-check")
    @endcan

    @if(auth()->user()->can('untag', $document) && in_array('pre-check', $document->tagNames))
        @action_item(__('addworking.enterprise.document._actions.remove_precheck') ."|icon:shield-alt|href:{$document->routes->untag}?tag=pre-check")
    @endcan

    @can('showHistory', $document)
        @action_item(__('addworking.enterprise.document._actions.history')."|icon:history|href:".route('addworking.enterprise.document.actions_history', [$document->enterprise, $document]))
    @endcan

    @can('createProofAuthenticity', $document)
        @action_item(__('addworking.enterprise.document._actions.add_proof_authenticity')."|icon:plus|href:".route('addworking.enterprise.document.proof_authenticity.create', [$document->enterprise, $document]))
    @endcan

    @can('editProofAuthenticity', $document)
        @action_item(__('addworking.enterprise.document._actions.edit_proof_authenticity')."|icon:edit|href:".route('addworking.enterprise.document.proof_authenticity.edit', [$document->enterprise, $document]))
    @endcan

    @if (! is_null($document->getProofAuthenticity()))
        @action_item(__('addworking.enterprise.document._actions.download_proof_authenticity')."|icon:file-download|href:".route('addworking.enterprise.document.proof_authenticity.download', [$document->enterprise, $document]))
    @endif

    @if (! is_null($document->getDocumentTypeModel()) && ! is_null($document->getYousignMemberId()) && ! is_null($document->getSignedAt()))
        @action_item(__('addworking.enterprise.document._actions.download_proof_authenticity_from_yousign')."|icon:file-download|href:".route('addworking.enterprise.document.proof_authenticity.download_from_yousign', [$document->enterprise, $document]))
    @endif
@endcomponent
