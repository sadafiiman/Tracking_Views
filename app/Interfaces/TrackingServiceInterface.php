<?php

namespace App\Interfaces;

interface TrackingServiceInterface
{
    public function track(string $endpoint): void;
}
