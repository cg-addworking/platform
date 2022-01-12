<?php

namespace Components\Sogetrel\Mission\Application\Requests;

use Carbon\Carbon;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMissionTrackingLineAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('update', $this->route('mission_tracking_line_attachment'));
    }

    public function rules()
    {
        $today = Carbon::today();

        return [
            'mission_tracking_line_attachment.amount'          => "required|numeric|min:0",
            'mission_tracking_line_attachment.signed_at'       => "required|date|max:{$today}",
            'mission_tracking_line_attachment.submitted_at'    => "nullable|date|max:{$today}",
            'mission_tracking_line_attachment.reverse_charges' => "nullable|boolean",
            'mission_tracking_line_attachment.direct_billing'  => "nullable|boolean",
            'mission_tracking_line_attachment.num_attachment'  => "nullable|string",
            'mission_tracking_line_attachment.num_order'       => "nullable|string",
            'mission_tracking_line_attachment.num_site'        => "nullable|string",
        ];
    }
}
