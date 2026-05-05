<?php

namespace App\Services;

use App\Interfaces\TrackingServiceInterface;
use App\Repositories\RedisTrackingViewsRepository;

class TrackingService implements TrackingServiceInterface
{
    public function __construct(
        private readonly RedisTrackingViewsRepository $redisTrackingViewsRepository
    ) {}

    public function track(string $endpoint): void
    {
        $this->redisTrackingViewsRepository->increment($endpoint);
    }
}
