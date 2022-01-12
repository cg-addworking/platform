@if(auth()->user() && auth()->user()->enterprises()->count() > 0 &&
    is_null(auth()->user()->getJobTitleFor(auth()->user()->enterprise)))
    <div class="modal fade" id="modal_member_job_title" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('enterprise.resource.application.views.modals.member_job_title.modal_title', ['enterprise_name' => auth()->user()->enterprise->name]) }}</h5>
                </div>
                <div class="modal-body">
                    <fieldset class="pt-2">
                        @form_group([
                            'text'        => "Fonction",
                            'type'        => "text",
                            'name'        => "member.job_title",
                            'placeholder' => __('enterprise.resource.application.views.modals.member_job_title.general_project_manager'),
                            'id'          => 'modal_member_job_input_job_title',
                        ])
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modal_member_job_title_send_button">{{ __('enterprise.resource.application.views.modals.member_job_title.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#modal_member_job_title').modal({backdrop: 'static', keyboard: false})
            $('#modal_member_job_title').modal('show');
            $('#modal_member_job_title_send_button').bind('click', function () {
                var value = $('#modal_member_job_input_job_title').val();
                if (!value || value === "" || !value.replace(/\s/g, '').length) {
                    $('#modal_member_job_input_job_title').css("border-color", "red");
                    return;
                }
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('enterprise.set_member_job_title') }}",
                    data: {
                        member_job_title: value,
                        enterprise_id: "{{auth()->user()->enterprise->id}}",
                    },
                    success: function(response) {
                        $('#modal_member_job_title').modal('hide');
                    },
                });
            });
        });
    </script>
@endif