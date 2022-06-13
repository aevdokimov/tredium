<?php

namespace App\Http\Controllers;

use App\DTO\CreateCommentDTO;
use App\Http\Requests\CreateCommentRequest;
use App\Jobs\CreateComment;

class CommentController extends Controller
{
    public function create (CreateCommentRequest $request)
    {
        $DTO = CreateCommentDTO::fromRequest($request);
 
        CreateComment::dispatch($DTO);

        return ['status' => 'ok'];
    }
}
