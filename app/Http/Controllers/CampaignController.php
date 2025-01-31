<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignShowRequest;
use App\Models\Campaign;
use App\Models\Template;
use App\Models\EmailList;
use App\Mail\EmailCampaign;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\CampaignStoreRequest;
use App\Jobs\SendEmailCampaign;
use App\Models\CampaignMail;
use Illuminate\Support\Traits\Conditionable;

class CampaignController extends Controller
{
    use Conditionable;
    public function index()
    {
        $search = request()->get('search', null);
        $withTrashed = request()->get('withTrashed', false);

        return view('campaign.index', [
            'campaigns' => Campaign::query()
                ->when($withTrashed, fn(Builder $query) => $query->withTrashed())
                ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")->orWhere('id', '=', $search))
                ->paginate(5)
                ->appends(compact('search', 'withTrashed')),
            'search' => $search,
            'withTrashed' => $withTrashed,
        ]);
    }

    public function show(CampaignShowRequest $request, Campaign $campaign, ?string $what = null)
    {
        if ($redirect = $request->checkWhat()) {
            return $redirect;
        }

        $search = request()->search;

        $query = $campaign
            ->mails()
            ->selectRaw('
                count(subscriber_id) as total_subscriber
                , sum(openings) as total_openings
                , count(case when openings > 0 then subscriber_id end) as unique_openings
                , round((cast(count(case when openings > 0 then subscriber_id end) as float) / cast(count(subscriber_id) as float)) * 100) as opening_rate
                , sum(clicks) as total_clicks
                , count(case when openings > 0 then subscriber_id end) as unique_clicks
                , round((cast(count(case when clicks > 0 then subscriber_id end) as float) / cast(count(subscriber_id) as float)) * 100) as clicks_rate
            ')
            ->first();

        return view('campaign.show', compact('campaign', 'what', 'search', 'query'));
    }

    public function create(?string $tab = null)
    {
        $data =  session()->get('campaign::create', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null,
            'send_when' => 'now',
        ]);

        return view('campaign.create', array_merge(
            $this->when(blank($tab), fn() => [
                'emailLists' => EmailList::query()->select(['id', 'title'])->orderBy('title')->get(),
                'templates' => Template::query()->select(['id', 'name'])->orderBy('name')->get(),
            ], fn() => []),
            $this->when($tab == 'schedule', fn() => [
                'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                'template' => Template::find($data['template_id'])->name,
            ], fn() => []),
            [
                'tab' => $tab,
                'form' => match ($tab) {
                    'template' => '_template',
                    'schedule' => '_schedule',
                    default => '_config',
                },
                'data' => $data,
            ]
        ));
    }

    public function store(CampaignStoreRequest $request, ?string $tab = null)
    {
        $data = $request->getData();
        $toRoute = $request->getToRoute();

        if ($tab == 'schedule') {
            $campaign = Campaign::create($data);

            SendEmailCampaign::dispatchAfterResponse($campaign);
        }

        return response()->redirectTo($toRoute);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return back()->with('message', __('Campaign deleted successfully!'));
    }

    public function restore(Campaign $campaign)
    {
        $campaign->restore();

        return back()->with('message', __('Campaign restored successfully!'));
    }
}
