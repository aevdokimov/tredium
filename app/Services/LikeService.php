<?php

namespace App\Services;

use App\DTO\LikeDTO;
use App\Models\Article;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class LikeService {
    public function like (LikeDTO $DTO): void
    {
        if (!Article::where(['id' => $DTO->article_id])->exists()) {
            return;
        }

        DB::transaction(function () use ($DTO) {
            if (!Like::where($DTO->toArray())->exists()) {
                Like::create($DTO->toArray());
                Article::where('id', $DTO->article_id)->increment('likes');
            }
        });
    }

    public function unlike (LikeDTO $DTO): void
    {
        DB::transaction(function () use ($DTO) {
            if (Like::where($DTO->toArray())->exists()) {
                Like::where($DTO->toArray())->delete();

                if (Article::where(['id' => $DTO->article_id])->exists()) {
                    Article::where('id', $DTO->article_id)->decrement('likes');
                }
            }
        });
    }
}