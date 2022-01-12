<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('calendar') {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._form.period') }}</legend>

    <div class="row my-4">
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._period_selector.customer'),
                'type' => "select",
                'name' => "customer.id",
                'options' => Repository::missionTrackingLineAttachment()->getCustomerWithVendors()->pluck('name', 'id'),
                'required' => true,
                'id' => "select-customer-id",
                'size' => 10,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._period_selector.vendor'),
                'type' => "select",
                'name' => "vendor.id",
                'required' => true,
                'id' => "select-vendor-id",
                'size' => 10,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._period_selector.mission'),
                'type' => "select",
                'name' => "mission.id",
                'required' => true,
                'id' => "select-mission-id",
                'size' => 10,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._period_selector.milestone'),
                'type' => 'select',
                'name' => 'milestone.id',
                'required' => true,
                'id' => "select-milestone-id",
                'size' => 10,
            ])
        </div>
    </div>
</fieldset>

@push('scripts')
    <script type="text/javascript">
        $(function() {
            var $select_customers  = $('#select-customer-id'),
                $select_vendors    = $('#select-vendor-id'),
                $select_missions   = $('#select-mission-id'),
                $select_milestones = $('#select-milestone-id');

            $select_customers.change(function(event) {
                $.ajax({
                    dataType: "json",
                    url: "{{ route('sogetrel.mission.mission_tracking_line_attachment.get_vendors') }}",
                    data: {
                        customer: $(this).val()
                    },
                    beforeSend: function () {
                        var $selects = $([]).add($select_vendors).add($select_missions).add($select_milestones);
                        $('option', $selects).remove();
                        $selects.attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        $(data).each(function(i, enterprise) {
                            $select_vendors.append('<option value="'+enterprise.id+'">'+enterprise.name+'</option>');
                        });
                    },
                    complete: function () {
                        $([]).add($select_vendors).add($select_missions).add($select_milestones).removeAttr('disabled');
                    }
                });
            });

            $select_vendors.change(function(event) {
                $.ajax({
                    dataType: "json",
                    url: "{{ route('sogetrel.mission.mission_tracking_line_attachment.get_missions') }}",
                    data: {
                        customer: $select_customers.val(),
                        vendor:   $(this).val()
                    },
                    beforeSend: function () {
                        var $selects = $([]).add($select_missions).add($select_milestones);
                        $('option', $selects).remove();
                        $selects.attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        $(data).each(function(i, mission) {
                            $select_missions.append('<option value="'+mission.id+'">'+mission.label+'</option>');
                        });
                    },
                    complete: function () {
                        $([]).add($select_missions).add($select_milestones).removeAttr('disabled');
                    }
                });
            });

            $select_missions.change(function(event) {
                $.ajax({
                    dataType: "json",
                    url: "{{ route('sogetrel.mission.mission_tracking_line_attachment.get_milestones') }}",
                    data: {
                        customer: $select_customers.val(),
                        vendor:   $select_vendors.val(),
                        mission:  $(this).val(),
                    },
                    beforeSend: function () {
                        $('option', $select_milestones).remove();
                        $select_milestones.attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        $(data).each(function(i, milestone) {
                            var starts_at = new Date(milestone.starts_at),
                                ends_at   = new Date(milestone.ends_at);

                            $select_milestones.append(
                                '<option value="'+milestone.id+'">'+
                                    starts_at.getDate()+'/'+(starts_at.getMonth()+1)+'/'+starts_at.getFullYear()+
                                    ' - '+
                                    ends_at.getDate()+'/'+(ends_at.getMonth()+1)+'/'+ends_at.getFullYear()+
                                '</option>'
                            );
                        });
                    },
                    complete: function () {
                        $select_milestones.removeAttr('disabled');
                    }
                });
            });
        });
    </script>
@endpush
