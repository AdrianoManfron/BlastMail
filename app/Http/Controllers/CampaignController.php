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
            ->when($what == 'statistics', fn(Builder $query) => $query->statistics())
            ->when($what == 'open', fn(Builder $query) => $query->openings($search))
            ->when($what == 'clicked', fn(Builder $query) => $query->clicks($search))
            ->simplePaginate(5)
            ->appends(compact('search'));

        if ($what == 'statistics') {
            $query = $query->first()->toArray();
        }

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
