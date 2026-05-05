<?php

namespace App\Interfaces;

interface TrackingViewsRepositoryInterface
{
    public function increment(string $endpoint): void;

    public function getReport(int $limit = 50): array;
}
