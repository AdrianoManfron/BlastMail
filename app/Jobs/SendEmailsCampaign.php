<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Subscriber;
use App\Mail\EmailCampaign;
use App\Models\CampaignMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailsCampaign implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Campaign $campaign,
        public Subscriber $subscriber,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = CampaignMail::query()
            ->create([
                'campaign_id' => $this->campaign->id,
                'subscriber_id' => $this->subscriber->id,
                'send_at' => $this->campaign->send_at,
            ]);
        Mail::to($this->subscriber->email)
            ->later($this->campaign->send_at, new EmailCampaign($this->campaign, $mail));
    }
}
