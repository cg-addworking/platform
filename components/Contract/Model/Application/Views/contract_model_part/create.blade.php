@extends('foundation::layout.app.create', ['action' => route('support.contract.model.part.store',$contract_model), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.model.application.views.contract_model_part.create.title', ['number'=> $contract_model->getNumber()]))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model_part.create.return')."|href:".route('support.contract.model.part.index', $contract_model)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_part._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('contract_model::contract_model_part._form')

    <fieldset>
        <div class="form-group">
            <label id="">
                {{__('components.contract.model.application.views.contract_model_part._form.part_type')}}
                <sup class=" text-danger font-italic">*</sup>
            </label>
            <select class="custom-select" id="select-part-type" required>
                <option value="textarea">{{ __('components.contract.model.application.views.contract_model_part._form.textarea') }}</option>
                <option value="file">{{ __('components.contract.model.application.views.contract_model_part._form.file') }}</option>
            </select>
        </div>

        <div class="form-group mb-3" id="div-file">
                @form_group([
                    'type'        => "file",
                    'name'        => "contract_model_part.file",
                    'required'    => false,
                    'accept'      => 'application/pdf',
                    'text'        => __('components.contract.model.application.views.contract_model_part._form.file'),
                ])
        </div>
        <div class="form-group" id="div-text">
            <label>{{ __('components.contract.model.application.views.contract_model_part._form.textarea') }}</label>
            <div class="alert alert-info" role="alert">
                <p>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_1') }}</p>
                <ul>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_2') }}</li>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_3') }}</li>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_4') }}</li>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_5') }}</li>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_6') }}</li>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_7') }}</li>
                    <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.paragraph_8') }}</li>
                </ul>
                <p><a id="variable-informations-modal-trigger" href="#">{{ __('components.contract.model.application.views.contract_model_part._form.information.call_to_action') }}</a></p>
            </div>

            <textarea class="form-control" name="contract_model_part[textarea]" rows="25"></textarea>
        </div>
    </fieldset>

    @button(__('components.contract.model.application.views.contract_model_part.create.create')."|type:submit|color:success|shadow|icon:check")

    @component('components.modal', ['id' => "variable-informations-modal"])
        @slot('title')
            {{ __('components.contract.model.application.views.contract_model_part._form.information.modal.main_title') }}
        @endslot
        <h5 class="alert-heading">{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.title_1') }}</h5>
        <p>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_1') }}</p>
        <p>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_2') }}</p>
        <p>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_3') }}</p>
        <ul>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_5') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_6') }}</li>
        </ul>
        <p>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_7') }}</p>
        <b>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_8') }}</b>
        <ul>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_9') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_10') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_11') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_12') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_13') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_14') }}</li>
            <li>{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_1_15') }}</li>
        </ul>
        <h5 class="alert-heading">{{ __('components.contract.model.application.views.contract_model_part._form.information.modal.title_2') }}</h5>
        {{ __('components.contract.model.application.views.contract_model_part._form.information.modal.paragraph_2_1') }}
    @endcomponent
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            if($('#select-part-type').val() == 'file'){
                $("#div-file").show();
                $("#div-text").hide();
            } else {
                $("#div-file").hide();
                $("#div-text").show();
            }

            $('form').submit(function (event) {
                if ($("#div-file").is(":hidden")) {
                    $("#div-file").remove();
                }
                if ($("#div-text").is(":hidden")) {
                    $("#div-text").remove();
                }
            });

            $("#select-part-type").change(function() {
                $("#div-file, #div-text").toggle("slow");
            });

            $('a#variable-informations-modal-trigger').click(function(){
                $('#variable-informations-modal').modal({ show: true })
            });
        });
    </script>
    @include('contract_model::contract_model_part._tinymce')
@endpush
