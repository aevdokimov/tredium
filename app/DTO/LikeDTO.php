<?php

namespace App\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class LikeDTO extends DataTransferObject
{
    public function __construct(
        #[Required, IP]
        public string $ip,    
        #[Required]
        public int $article_id
    ) {}
}