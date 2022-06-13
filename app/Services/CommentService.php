<?php

namespace App\Services;

use App\DTO\CreateCommentDTO;
use App\Models\Article;

class CommentService {
    public function create (CreateCommentDTO $DTO)
    {
        return Article::findOrFail($DTO->article_id)
            ->comments()
            ->create([
                'subject' => $DTO->subject,
                'body' => $DTO->body
            ]);
    }
}