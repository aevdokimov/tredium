<?php

namespace App\Http\Controllers;

use App\DTO\LikeDTO;
use App\Jobs\Like;
use App\Jobs\Unlike;
use App\Models\Article;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, Article $article)
    {
        $DTO = new LikeDTO($request->ip(), $article->id);

        Like::dispatch($DTO);

        return ['status' => 'ok'];
    }

    public function unlike(Request $request, Article $article)
    {
        $DTO = new LikeDTO($request->ip(), $article->id);

        Unlike::dispatch($DTO);

        return ['status' => 'ok'];
    }
}
