<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['id','title', 'body', 'content_id', 'created_at', 'updated_at'];

    public function content()
    {
        return $this->belongsTo('App\Content');
    }
}
