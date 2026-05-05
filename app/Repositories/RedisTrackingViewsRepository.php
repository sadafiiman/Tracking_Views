<?php
namespace App\Repositories;

use App\Interfaces\TrackingViewsRepositoryInterface;
use Illuminate\Contracts\Redis\Factory as RedisFactory;

class RedisTrackingViewsRepository implements TrackingViewsRepositoryInterface
{
    public function __construct(
        private RedisFactory $redis,
        private string $key = 'view-report'
    ) {}

    public function increment(string $endpoint): void
    {
        $this->redis->connection()->zincrby($this->key, 1, $endpoint);
    }

    public function getReport(int $limit = 50): array
    {
        $raw = $this->redis->connection()->zrevrange(
            $this->key,
            0,
            $limit - 1,
            ['withscores' => true]
        );

        return collect($raw)->map(fn ($views, $endpoint) => [
            'endpoint' => $endpoint,
            'views' => (int) $views,
        ])->values()->toArray();
    }
}
