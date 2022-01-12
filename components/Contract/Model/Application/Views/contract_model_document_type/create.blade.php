@extends('foundation::layout.app.create', ['action' => route('support.contract.model.party.document_type.store', [$contract_model, $contract_model_party]), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.model.application.views.contract_model_document_type.create.title', ['number' => $contract_model_party->getOrder(), 'denomination' => $contract_model_party->getDenomination()])))

@section('toolbar')
    @button(__('components.contract.model.application.views.contract_model_document_type.create.return')."|href:".route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract_model::contract_model_document_type._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>{{ __('components.contract.model.application.views.contract_model_document_type._form.document_type') }}</th>
                    <th>{{ __('components.contract.model.application.views.contract_model_document_type._form.add') }}</th>
                    <th>{{ __('components.contract.model.application.views.contract_model_document_type._form.validation_required') }}</th>
                </tr>
                @forelse($document_types as $key => $document_type)
                    <tr class="document_type_line">
                        <td>{{$document_type->display_name}} <i class="fas fa-info-circle fa-sm text-secondary" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ implode(", ", $document_type->legalForms()->get()->pluck('display_name')->toArray()) }}"></i></td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input document_type_id" type="checkbox" value="{{ $document_type->id }}" name="contract_model_document_type[{{ $key }}][document_type_id]">
                            </div>
                        </td>
                        <td>
                            <select class="custom-select custom-select-sm validation_required" name="contract_model_document_type[{{ $key }}][validation_required]">
                                <option value="0">{{ __('components.contract.model.application.views.contract_model_document_type._form.no') }}</option>
                                <option value="1">{{ __('components.contract.model.application.views.contract_model_document_type._form.yes') }}</option>
                            </select>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun document</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </fieldset>

    @push('scripts')
        <script>
            $(".validation_required").prop('disabled', 'true');

            $(".document_type_id").change(function(){
                $next = $(this).closest('tr').find("select");
                $next.prop('disabled', !this.checked);
            });
        </script>
    @endpush
    @button(__('components.contract.model.application.views.contract_model_document_type.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection

