<?php

namespace App\Jobs;

use App\DTO\CreateCommentDTO;
use App\Services\CommentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected CreateCommentDTO $DTO
    ) {
        $this->onQueue('comments');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CommentService $commentService)
    {
        // sleep(600);
        $commentService->create($this->DTO);
    }
}
