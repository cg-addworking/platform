@extends('foundation::layout.app.show')

@section('title', __('enterprise.resource.application.views.show.title')." {$resource->getNumber()}")

@section('toolbar')
    @button(__('enterprise.resource.application.views.show.return')."|href:{$resource->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('enterprise.resource.application.views.show.add')."|href:{$resource->routes->attach}|icon:plus|color:success|outline|sm|mr:2")

    @include('resource::_actions')
@endsection

@section('breadcrumb')
    {{ $resource->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class  ="card-body">
                    @if($resource->attachments()->exists())
                        @foreach($resource->attachments as $file)
                            <div class="card-header mt-2">
                                <a href="{{$file->routes->download}}">@icon('download'){{ __('enterprise.resource.application.views.show.download') }}</a> -
                                <a class="text-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">@icon('trash') Supprimer</a>
                                @push('modals')
                                    <form name="{{ $name }}" action="{{ $resource->routes->detach }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="file_id" value="{{ $file->id}}">
                                    </form>
                                @endpush
                            </div>
                            {{ $file->views->iframe(['ratio' => "4by3"]) }}
                        @endforeach
                    @else
                        {{ __('enterprise.resource.application.views.show.text') }}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{ $resource->views->html }}
        </div>
    </div>
@endsection
