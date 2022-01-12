@extends('foundation::layout.app.show')

@section('title', 'Aperçu du fichier')

@section('toolbar')
    @can('download', $file)
        @button(__('sogetrel.user.passwork.show_file.download')."|href:".route('file.download', $file)."|color:outline-info|outline|sm|ml:2")
    @endcan

    @button(__('sogetrel.user.passwork.show_file.return')."|href:".url()->previous()."|icon:arrow-left|color:outline-primary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('sogetrel.user.passwork.show_file.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('sogetrel.user.passwork.show_file.passwork').'|href:'.route('sogetrel.passwork.show', $passwork->id) )
    @breadcrumb_item(__('sogetrel.user.passwork.show_file.file')."|active")
@endsection

@section('content')
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="{{ $file->common_url }}" frameborder="0"></iframe>
    </div>

@endsection
