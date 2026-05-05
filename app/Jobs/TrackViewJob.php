<?php

namespace App\Jobs;

use App\Interfaces\TrackingServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackViewJob implements ShouldQueue
{
    public function __construct(
        private string $endpoint
    ) {}

    public function handle(TrackingServiceInterface $service)
    {
        $service->track($this->endpoint);
    }
}
