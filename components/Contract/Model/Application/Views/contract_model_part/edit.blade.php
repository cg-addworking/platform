@extends('foundation::layout.app.edit', ['action' => route('support.contract.model.part.update', [$contract_model, $contract_model_part]), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.model.application.views.contract_model_part.edit.title', ["number" => $contract_model_part->getNumber()]))

@section('toolbar')
    @button("Retour|href:".route('support.contract.model.part.index', $contract_model)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_part._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('contract_model::contract_model_part._form')

    <fieldset>
        @if($contract_model_part->getShouldCompile())
            <div class="form-group">
                <label>{{ __('components.contract.model.application.views.contract_model_part._form.textarea') }}</label>
                <textarea class="form-control" name="contract_model_part[textarea]" rows="25">{{$contract_model_part->getText()}}</textarea>
            </div>
            @push('scripts')
                @include('contract_model::contract_model_part._tinymce')
            @endpush
        @else
            <div class="form-group mb-3">
                <a href="{{route('file.download', $contract_model_part->getFile())}}">Télécharger</a>
                @form_group([
                    'type'        => "file",
                    'name'        => "contract_model_part.file",
                    'required'    => false,
                    'id'          => 'input-group-file',
                    'accept'      => 'application/pdf',
                    'text'        => __('components.contract.model.application.views.contract_model_part._form.file'),
                ])
            </div>
        @endif
    </fieldset>

    @button(__('components.contract.model.application.views.contract_model_part.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            if($('#is-signed-select').val() == '0'){
                $("#div-signature").hide();
            } else {
                $("#div-signature").show();
            }

            $("#is-signed-select").change(function() {
                $("#div-signature").toggle("slow");
            });
        });
    </script>
@endpush
