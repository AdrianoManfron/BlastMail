<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignShowRequest extends FormRequest
{
    public function checkWhat()
    {
        if (is_null($this->route('what'))) {
            return to_route('campaign.show', ['campaign' => $this->route('campaign'), 'what' => 'statistics']);
        }
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $what = $this->route('what') ?: 'statistics';

        abort_unless(in_array($what, ['statistics', 'open', 'clicked']), 404);

        return true;
    }
}
