<?php

namespace App\Jobs;

use App\DTO\LikeDTO;
use App\Services\LikeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Unlike implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected LikeDTO $DTO
    ) {
        $this->onQueue('likes');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LikeService $likeService)
    {
        $likeService->unlike($this->DTO);
    }
}
