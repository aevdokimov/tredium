<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Article;
use App\Services\LikeService;

class ArticleThumbnailResource extends JsonResource
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
        $plainBody = strip_tags($this->body);

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'excerpt' => mb_strlen($plainBody) >= 100
                ? rtrim(mb_substr($plainBody, 0, 100), ' .').'...'
                : $plainBody,
            'cover_url' => $this->cover_url,
            'cover_thumbnail_url' => $this->cover_thumbnail_url,
            'views' => $this->views,
            'likes' => (new LikeService)->getLikes($this->id)
        ];
    }
}
