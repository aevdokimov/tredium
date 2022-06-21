<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Article;
use App\Services\LikeService;

class ArticleResource extends JsonResource
{
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'cover_url' => $this->cover_url,
            'views' => $this->views,
            'likes' => (new LikeService)->getLikes($this->id),
            'tags' => TagResource::collection($this->tags),
            'comments' => CommentResource::collection(
                $this->comments()->orderBy('id', 'desc')->get()
            )
        ];
    }
}
