@extends('foundation::layout.app.show')

@section('title', "{$document_type_model->getDisplayName()}")

@section('toolbar')
    @button(__('document_type_model::document_type_model.show.return')."|href:".route('document_type_model.index', [$enterprise, $document_type])."|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('edit', $document_type_model)
        @button(__('document_type_model::document_type_model.show.edit_variable')."|href:".route('document_type_model.variable.edit', [$enterprise, $document_type, $document_type_model])."|icon:edit|color:primary|outline|sm|mr:2")
    @endcan

    @can('publish', $document_type_model)
        <a class="btn btn-outline-success btn-sm mr-2" href="#" onclick="confirm('Confirmer la publication ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('eye|mr-3') <span>{{ __('document_type_model::document_type_model._actions.publish') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('document_type_model.publish', [$enterprise, $document_type,$document_type_model]) }}" method="POST">
                @method('PUT')
                @csrf
            </form>
        @endpush
    @endcan

    @can('unpublish', $document_type_model)
        <a class="btn btn-outline-danger btn-sm mr-2" href="#" onclick="confirm('Confirmer la dépublication ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('undo|mr-3') <span>{{ __('document_type_model::document_type_model._actions.unpublish') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('document_type_model.unpublish', [$enterprise, $document_type,$document_type_model]) }}" method="POST">
                @method('PUT')
                @csrf
            </form>
        @endpush
    @endcan

    @include('document_type_model::document_type_model._actions')
@endsection

@section('breadcrumb')
    @include('document_type_model::document_type_model._breadcrumb', ['page' => "show"])
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    @if(!is_null($document_type_model->getFile()))
                        {{ $document_type_model->getFile()->views->iframe(['ratio' => "1by1"]) }}
                    @else
                        {{ __('document_type_model::document_type_model.show.no_file') }}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    @component('bootstrap::attribute', ['icon' => "info", 'label' => __('document_type_model::document_type_model.show.description')])
                        {{ $document_type_model->getDescription() }}
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "file", 'label' => __('document_type_model::document_type_model.show.document_type')])
                        {{$document_type->display_name}}
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "building", 'label' => __('document_type_model::document_type_model.show.enterprise')])
                        {{$enterprise->name}}
                    @endcomponent
                </div>
            </div>
            <div class="card shadow mt-1">
                <div class="card-body">
                    @component('bootstrap::attribute', ['icon' => "calendar", 'label' => __('document_type_model::document_type_model.show.published_at')])
                        @date($document_type_model->published_at)
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "info", 'label' => __('document_type_model::document_type_model.show.created_at')])
                        @date($document_type_model->created_at)
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "info", 'label' => __('document_type_model::document_type_model.show.updated_at')])
                        @date($document_type_model->updated_at)
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection