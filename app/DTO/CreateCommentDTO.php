<?php

namespace App\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class CreateCommentDTO extends DataTransferObject
{
    #[Required, Max(255)]
    public string $subject;

    #[Required]
    public string $body;

    #[Required]
    public int $article_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'subject' => $request->get('subject'),
            'body' => $request->get('body'),
            'article_id' => $request->get('article_id')
        ]);
    }
}