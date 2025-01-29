<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $campaign = $this->route('campaign');
        $what = $this->route('what');

        if (is_null($what)) {
            return to_route('campaign.show', ['campaign' => $campaign, 'what' => 'statistics']);
        }

        abort_unless(in_array($what, ['statistics', 'open', 'clicked']), 404);

        return true;
    }
}
