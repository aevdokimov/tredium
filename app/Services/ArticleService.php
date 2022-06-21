<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function getViews(int $articleId): int
    {
        return Cache::rememberForever($this->viewsCacheKeyById($articleId), function () use ($articleId) {
            $views = DB::table('articles')->where('id', $articleId)->value('views');

            if (is_null($views)) {
                throw new ModelNotFoundException("Article #{$articleId} not found");
            }

            return $views;
        });
    }

    public function addView(int $articleId): int
    {
        $views = $this->getViews($articleId) + 1;

        $cacheKey = $this->viewsCacheKeyById($articleId);        
        Cache::forget($cacheKey);
        Cache::forever($cacheKey, $views);

        return $views;
    }

    public function viewsCacheKeyById(int $articleId)
    {
        return "article_views_$articleId";
    }
}