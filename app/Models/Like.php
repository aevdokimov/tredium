<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;

    protected $fillable = ['ip', 'article_id'];

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('article_id', '=', $this->getAttribute('article_id'))
            ->where('ip', '=', $this->getAttribute('ip'));

        return $query;
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
