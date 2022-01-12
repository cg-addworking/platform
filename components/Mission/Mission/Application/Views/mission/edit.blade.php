@extends('foundation::layout.app.edit', ['action' => route('sector.mission.update', $mission->getId()), 'enctype' => "multipart/form-data"])

@section('title', __('mission::mission.edit.title').' '.$mission->getLabel())

@section('toolbar')
    @button(__('mission::mission.edit.return')."|href:#|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('mission::mission._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('mission::mission.construction._form', ['page' => "edit"])

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-outline-success"><i class="fa fa-check"></i> {{ __('mission::mission.edit.submit') }}</button>
    </div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {
            var workfield_id = "{{ $workfield }}";
            loadReferentsOfEnterprise($('#selected_enterprise').val());
            loadVendorsOfEnterprise($('#selected_enterprise').val());
            loadWorkfieldsOfEnterprise($('#selected_enterprise').val(), workfield_id);
        });

        $('#selected_enterprise').on('change', function() {
            loadReferentsOfEnterprise($(this).val());
            loadVendorsOfEnterprise($(this).val());
            loadWorkfieldsOfEnterprise($(this).val(), null);
        });

        var loadReferentsOfEnterprise = function(value) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('sector.mission.get_referent') }}",
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
                        var selected = '{{$mission->getReferent()->id }}'=== id ? 'selected' : '';

                        $('#selected_referent').append('<option value="'+id+'"'+selected+'>'+name+'</option>');
                        $("#selected_referent").selectpicker("refresh");
                    });
                },
            });
        }

        var loadVendorsOfEnterprise = function(value) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('sector.mission.get_vendor') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    enterprise_id: value
                },
                beforeSend: function () {
                    $('#selected_vendor option').remove();
                    $("#selected_vendor").selectpicker("refresh");
                },
                success: function(response) {
                    $.each(response.data, function(id, name) {
                        var selected = '{{$mission->getVendor()->id }}'=== id ? 'selected' : '';

                        $('#selected_vendor').append('<option value="'+id+'"'+selected+'>'+name+'</option>');
                        $("#selected_vendor").selectpicker("refresh");
                    });
                },
            });
        }

        var loadWorkfieldsOfEnterprise = function(value, workfield_key) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('sector.mission.get_workfield') }}",
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
    </script>
@endpush
