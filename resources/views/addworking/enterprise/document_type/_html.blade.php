<div class="row">
    <div class="col-md-6">
        @component('bootstrap::attribute', ['icon' => "tag", 'label' => "Type"])
            {{ __("document.type.{$document_type->type}") ?? 'n/a' }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.mandatory')])
            {{ $document_type->is_mandatory ? __('addworking.enterprise.document_type._html.yes') : __('addworking.enterprise.document_type._html.no')}}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => "Période de validité"])
            {{ $document_type->validity_period ?? 'n/a' }} {{ __('addworking.enterprise.document_type._html.days') }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.deadline_date')])
                @date($document_type->getDeadlineDate() ?? 'n/a')
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => "Code"])
            {{ $document_type->code ?? 'n/a' }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.possible_validation_by')])
            @if($document_type->needs_support_validation)
                <span class="badge badge-pill badge-danger">{{ __('addworking.enterprise.document_type._html.support') }}</span>
            @endif

            @if($document_type->needs_customer_validation)
                <span class="badge badge-pill badge-warning">{{ __('addworking.enterprise.document_type._html.customer') }}</span>
            @endif

            @if(! $document_type->needs_support_validation && ! $document_type->needs_customer_validation)
                n/a
            @endif
        @endcomponent
    </div>
    <div class="col-md-6">
        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.document_template')])
            {{ $document_type->file->views->download }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.created_at')])
            @date($document_type->created_at)
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.modified')])
            @date($document_type->updated_at)
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.delete_it')])
            @date($document_type->deleted_at)
        @endcomponent
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @component('bootstrap::attribute', ['icon' => "tag", 'label' => __('addworking.enterprise.document_type._html.legal_forms')])
            @foreach($document_type->legalForms as $legal_form)
                {{ $legal_form->display_name }},
            @endforeach
        @endcomponent
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @component('bootstrap::attribute', ['icon' => "tag", 'label' => "Description"])
            {{ $document_type->description ?? 'n/a' }}
        @endcomponent
    </div>
</div>
