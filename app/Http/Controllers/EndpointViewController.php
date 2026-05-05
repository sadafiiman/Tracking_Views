<?php

namespace App\Http\Controllers;

use App\Repositories\RedisTrackingViewsRepository;
use Illuminate\Http\JsonResponse;

class EndpointViewController extends Controller
{
    private RedisTrackingViewsRepository $redisTrackingViewsRepository;

    /**
     * Constructor to inject the RedisRepository
     *
     * @param RedisTrackingViewsRepository $redisTrackingViewsRepository
     */
    public function __construct(RedisTrackingViewsRepository $redisTrackingViewsRepository)
    {
        $this->redisTrackingViewsRepository = $redisTrackingViewsRepository;
    }

    /**
     * Home endpoint
     *
     */
    public function home()
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
        $viewReports = $this->redisTrackingViewsRepository->getReport();

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
