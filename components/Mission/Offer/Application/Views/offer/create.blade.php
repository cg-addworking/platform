@extends('foundation::layout.app.create', ['action' => route('sector.offer.store'), 'enctype' => "multipart/form-data"])

@section('title', __('offer::offer.create.title'))

@section('toolbar')
    @button(__('offer::offer.create.return')."|href:#|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('offer::offer._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('offer::offer.construction._form', ['page' => "create"])

    <input type="hidden" name="offer[status]" value="">

    <div class="text-right mt-3">
        <button type="submit" id="draft_offer_btn" value="draft" class="border btn btn-outline-secondary"><i class="fa fa-edit"></i> {{ __('offer::offer.create.save_as_draft') }}</button>
        <button type="submit" id="to_provide_offer_btn" value="to_provide" class="btn btn-outline-success"><i class="fa fa-check"></i> {{ __('offer::offer.create.submit') }}</button>
    </div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {
            var loadReferentsOfEnterprise = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('sector.offer.get_referent') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $('#selected_referent option').remove();
                        $("#selected_referent").selectpicker("refresh");
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            var selected = '{{auth()->user()->id}}' === id ? 'selected' : '';

                            $('#selected_referent').append('<option value="'+id+'" '+selected+'>'+name+'</option>');
                            $("#selected_referent").selectpicker("refresh");
                        });
                    },
                });
            }

            var loadWorkfieldsOfEnterprise = function(value, workfield_key) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('sector.offer.get_workfield') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $('#selected_workfield option').remove();
                        $("#selected_workfield").selectpicker("refresh");
                    },
                    success: function (response) {
                        $.each(response.data, function (id, name) {
                            if (workfield_key !== undefined && workfield_key === id) {
                                $('#selected_workfield').append('<option value="' + id + '" selected>' + name + '</option>');
                            } else {
                                $('#selected_workfield').append('<option value="' + id + '">' + name + '</option>');
                            }

                            $("#selected_workfield").selectpicker("refresh");
                        });
                    },
                });
            }

            var loadSkillsOfEnterprise = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('sector.offer.get_skill') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $('#selected_skill option').remove();
                        $("#selected_skill").selectpicker("refresh");
                    },
                    success: function (response) {
                        $.each(response.data, function (job_name, job) {
                            var html = '<optgroup label="' + job_name + '">';
                            $.each(job, function (id, name) {
                                html += '<option value="' + id + '">' + name + '</option>';
                            });
                            html += '</optgroup>';

                            $('#selected_skill').append(html);
                            $("#selected_skill").selectpicker("refresh");
                        });

                    },
                });
            }
            var workfield_id = "{{ $workfield }}";
            loadReferentsOfEnterprise($('#selected_enterprise').val());
            loadWorkfieldsOfEnterprise($('#selected_enterprise').val(), workfield_id);
            loadSkillsOfEnterprise($('#selected_enterprise').val());

            $('#selected_enterprise').on('change', function() {
                loadReferentsOfEnterprise($(this).val());
                loadWorkfieldsOfEnterprise($(this).val(), null);
                loadSkillsOfEnterprise($(this).val());
            });

            $("#draft_offer_btn").click(function() {
                const submit_value = $(this).val();
                $('input[name="offer[status]"]').val(submit_value);
            });

            $("#to_provide_offer_btn").click(function() {
                const submit_value = $(this).val();
                $('input[name="offer[status]"]').val(submit_value);
            });
        });
    </script>
@endpush
