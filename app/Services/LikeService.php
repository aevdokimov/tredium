<?php

namespace App\Services;

use App\DTO\LikeDTO;
use App\Models\Article;
use App\Models\Like;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LikeService
{
    public const CACHE_TTL = 60;

    public function like(LikeDTO $DTO): void
    {
        if (!Article::where(['id' => $DTO->article_id])->exists()) {
            throw new ModelNotFoundException("Article #{$DTO->article_id} not found");
        }

        DB::table('likes')->insertOrIgnore($DTO->toArray());
    }

    public function unlike(LikeDTO $DTO): void
    {
        Like::where($DTO->toArray())->delete();
    }

    public function getLikes(int $articleId): int
    {
        return Cache::remember(
            $this->likesCacheKeyById($articleId),
            self::CACHE_TTL,
            function () use ($articleId) {
                $likes = DB::table('likes')->where('article_id', $articleId)->count();
                return $likes;
            }
        );
    }

    public function likesCacheKeyById(int $articleId)
    {
        return "article_likes_$articleId";
    }
}