<?php

namespace App\Http\Controllers;

use App\Repositories\TrackingViewsRepository;
use Illuminate\Http\JsonResponse;

class EndpointViewController extends Controller
{
    protected TrackingViewsRepository $trackingViewRepository;

    /**
     * Constructor to inject the RedisRepository
     *
     * @param TrackingViewsRepository $trackingViewRepository
     */
    public function __construct(TrackingViewsRepository $trackingViewRepository)
    {
        $this->trackingViewRepository = $trackingViewRepository;
    }

    /**
     * Home endpoint
     *
     * @return string
     */
    public function home(): string
    {
        return view('welcome');
    }

    public function helloWorld(): string
    {
        return 'Hello world';
    }

    /**
     * Handle the report route
     *
     * @return JsonResponse
     */
    public function report(): JsonResponse
    {
        $viewReports = $this->trackingViewRepository->getAllViewsReport();

        if (empty($viewReports)) {
            return response()->json(['message' => 'No view reports found']);
        }

        $formattedReports = [];
        foreach ($viewReports as $endpoint => $views) {
            $formattedReports[] = [
                'endpoint' => $endpoint,
                'views' => intval($views)
            ];
        }

        return response()->json($formattedReports);
    }
}
