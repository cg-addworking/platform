@extends('foundation::layout.app.edit', ['action' => route('sector.offer.update', $offer), 'enctype' => "multipart/form-data"])

@section('title', __('offer::offer.edit.title').' '.$offer->getLabel())

@section('toolbar')
    @button(__('offer::offer.edit.return')."|href:".route('sector.offer.show', $offer)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('offer::offer._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('offer::offer.construction._form', ['page' => "edit"])

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-outline-success"><i class="fa fa-check"></i> {{ __('offer::offer.edit.submit') }}</button>
    </div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {
            var selected_skills_array = {!! $selected_skills !!};
            var workfield_id = "{{ $workfield }}";
            var referent_id = "{{ $offer->getReferent()->id ?? '' }}";
            loadReferentsOfEnterprise($('#selected_enterprise').val(), referent_id);
            loadWorkfieldsOfEnterprise($('#selected_enterprise').val(), workfield_id);
            loadSkillsOfEnterprise($('#selected_enterprise').val(), selected_skills_array);
        });

        $('#selected_enterprise').on('change', function() {
            loadReferentsOfEnterprise($(this).val(), null);
            loadSkillsOfEnterprise($(this).val());
            loadWorkfieldsOfEnterprise($(this).val(), null);
        });

        var loadReferentsOfEnterprise = function(value, referent_id) {
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
                        if (referent_id !== '' && referent_id === id) {
                            $('#selected_referent').append('<option value="'+id+'" selected>'+name+'</option>');
                        } else {
                            $('#selected_referent').append('<option value="'+id+'">'+name+'</option>');
                        }
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

        var loadSkillsOfEnterprise = function(value, selected_skills_array) {
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
                            if ($.inArray(id, selected_skills_array) !== -1) {
                                html += '<option value="' + id + '" selected >' + name + '</option>';
                            } else {
                                html += '<option value="' + id + '">' + name + '</option>';
                            }
                        });
                        html += '</optgroup>';

                        $('#selected_skill').append(html);
                        $("#selected_skill").selectpicker("refresh");
                    });

                },
            });
        }
    </script>
@endpush
