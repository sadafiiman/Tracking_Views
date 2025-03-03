<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class TrackingViewsRepository
{
    protected $redisKey = 'view-report';

    /**
     *
     * @param string $endpoint
     * @return void
     */
    public function incrementEndpointView(string $endpoint): void
    {
        Redis::zincrby($this->redisKey, 1, $endpoint);
    }

    /**
     * Get all the view counts (members and scores) from the Redis sorted set.
     *
     * @return array
     */
    public function getAllViewsReport(): array
    {
        return Redis::zrevrange($this->redisKey, 0, -1, ['WITHSCORES' => true]);
    }
}
