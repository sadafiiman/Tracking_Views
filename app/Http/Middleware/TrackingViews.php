<?php

namespace App\Http\Middleware;

use App\Repositories\TrackingViewsRepository;
use Closure;
use Illuminate\Http\Request;

class TrackingViews
{
    protected TrackingViewsRepository $trackingViewsRepository;

    /**
     * Constructor to inject the RedisRepository
     *
     * @param TrackingViewsRepository $trackingViewsRepository
     */
    public function __construct(TrackingViewsRepository $trackingViewsRepository)
    {
        $this->trackingViewsRepository = $trackingViewsRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $endpoint = '/' . ltrim($request->path(), '/');

        $this->trackingViewsRepository->incrementEndpointView($endpoint);

        return $next($request);
    }
}
