<?php

namespace App\Http\Middleware;

use App\Jobs\TrackViewJob;
use Closure;
use Illuminate\Http\Request;

class TrackingViews
{
    public function __construct() {}

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $endpoint = '/' . ltrim($request->path(), '/');

            if ($this->shouldTrack($request, $response)) {
                dispatch(new TrackViewJob($endpoint));
            }
        }

        return $response;
    }

    private function shouldTrack(Request $request, $response): bool
    {
        return $request->isMethod('GET')
            && $response->getStatusCode() >= 200
            && $response->getStatusCode() < 300
            && !str_starts_with($request->path(), 'api/internal');
    }
}
