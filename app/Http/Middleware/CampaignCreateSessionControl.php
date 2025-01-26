<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CampaignCreateSessionControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! str($request->header('referer'))->contains($request->route()->compiled->getStaticPrefix())) {
            session()->forget('campaign::create');
        } else {
            $session = session()->get('campaign::create');
            $tab = $request->route('tab');

            if (filled($tab) && blank(data_get($session, 'name'))) {
                return to_route('campaign.create');
            }

            if ($tab == 'schedule' && blank(data_get($session, 'body'))) {
                return to_route('campaign.create', ['tab' => 'template']);
            }
        }

        return $next($request);
    }
}
