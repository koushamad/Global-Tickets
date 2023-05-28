<?php

namespace App\Jobs;

use App\Service\Contract\ShortLinkServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ShortLinkClickedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $timeout = 10;

    public $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $code)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(ShortLinkServiceContract $shortLinkService): void
    {
        $shortLinkService->incrementShortLinkClick($this->code);
    }
}
