@inject('documentTypeRejectReasonRepository', 'Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository')

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('file-alt') {{ $document->documentType->display_name }}</legend>

    <div class="form-group">
        <label>{{ __('addworking.enterprise.document._form_reject.refusal_reason') }}</label>
        <select id="select-reason-for-rejection" class="form-control" name="document[reason_for_rejection]" required>
            @foreach($documentTypeRejectReasonRepository->listRejectReason($document->documentType) as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</fieldset>

@push('scripts')
    <script>
        $(function () {
            var loadMessage = function(reject_reason_id)
            {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('support.document_type_reject_reason.get_available_reject_reason_ajax', [$document->enterprise, $document->documentType]) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "reject_reason_id": reject_reason_id,
                    },
                    success: function(response) {
                        $('#textarea-comment').val(response.data);
                    },
                });
            };

            $("#select-reason-for-rejection").change(function() {
                loadMessage($("#select-reason-for-rejection").val());
            });
            loadMessage($("#select-reason-for-rejection").val());
        })
    </script>
@endpush
