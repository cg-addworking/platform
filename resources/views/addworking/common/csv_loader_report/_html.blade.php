<div class="row">
    <div class="col-md-8">
        @attribute("{$csv_loader_report}|icon:tag|label:".__('addworking.common.csv_loader_report._html.label'))
        @attribute("{$csv_loader_report->line_count}|icon:info|label:".__('addworking.common.csv_loader_report._html.number_of_lines'))
        @attribute("{$csv_loader_report->error_count}|icon:info|label:".__('addworking.common.csv_loader_report._html.errors'))
    </div>
    <div class="col-md-4">
        @attribute("{$csv_loader_report->id}|icon:id-card-alt|label:".__('addworking.common.csv_loader_report._html.username'))
        @attribute("{$csv_loader_report->created_at}|icon:calendar-plus|label:".__('addworking.common.csv_loader_report._html.created_date'))
        @attribute("{$csv_loader_report->updated_at}|icon:calendar-check|label:".__('addworking.common.csv_loader_report._html.last_modified_date'))
    </div>
</div>
