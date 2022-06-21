<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleThumbnailCollection;
use App\Models\Tag;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleThumbnailCollection(
            Article::orderBy('id', 'desc')->paginate(10)
        );
    }

    public function show($slug)
    {
        return new ArticleResource(
            Article::where('slug', $slug)->firstOrFail()
        );
    }

    public function homePage()
    {
        return new ArticleThumbnailCollection(
            Article::orderBy('id', 'desc')->limit(6)->get()
        );
    }

    public function byTag($slug)
    {
        return new ArticleThumbnailCollection(
            Tag::where('slug', $slug)
                ->firstOrFail()
                ->articles()
                ->orderBy('id', 'desc')
                ->paginate(10)
        );
    }

    public function addView(Article $article, ArticleService $articleService)
    {
        $views = $articleService->addView($article->id);

        return ['views' => $views];
    }
}
