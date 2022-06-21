<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagIds = Tag::pluck('id')->toArray();

        Article::factory()
            ->count(20)
            ->create()
            ->each(function (Article $article) use ($tagIds) {
                shuffle($tagIds);
                $article->tags()->attach(
                    array_slice($tagIds, 0, mt_rand(1, 5))
                );

                $article->comments()->saveMany(
                    Comment::factory()
                        ->times(mt_rand(0,3))
                        ->make()
                );

                $article->likes()->saveMany(
                    Like::factory()
                        ->times(mt_rand(10, 100))
                        ->make()
                );
            });
    }
}
