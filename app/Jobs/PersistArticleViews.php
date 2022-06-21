<?php

namespace App\Jobs;

use App\Services\ArticleService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PersistArticleViews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const ARTICLES_PER_RUN = 50;

    public const CACHE_KEY = 'persist_article_views_offset';

    public const CACHE_TTL = 3600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ArticleService $articleService)
    {
        $offset = Cache::get(self::CACHE_KEY, 0);

        $articleIds = DB::table('articles')
                        ->orderBy('id', 'asc')
                        ->skip($offset)
                        ->take(self::ARTICLES_PER_RUN)
                        ->pluck('id');

        // All articles processed, reset offset
        if (count($articleIds) == 0) {
            Cache::put(self::CACHE_KEY, 0, self::CACHE_TTL);
            return;
        }

        foreach ($articleIds as $articleId) {
            $views = Cache::get($articleService->viewsCacheKeyById((int)$articleId));
            if (!is_null($views)) {                
                DB::table('articles')
                    ->where('id', $articleId)
                    ->update(['views' => $views]);
            }
        }

        Cache::put(
            self::CACHE_KEY,
            $offset + self::ARTICLES_PER_RUN,
            self::CACHE_TTL
        );
    }
}
