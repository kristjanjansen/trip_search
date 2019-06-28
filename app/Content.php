<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
//use ScoutElastic\Searchable;

class Content extends Model
{
    use Searchable;

    protected $fillable = ['id', 'title', 'body', 'created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function searchableAs()
    {
        return 'content';
    }

    public function toSearchableArray()
    {
        $fields =  $this->toArray();
        $fields['comments'] = $this->comments()->pluck('body')->join('');
        return $fields;
    }

    public function shouldBeSearchable()
    {
        return true;
    }

    public function getScoutKey()
    {
        return $this->id;
    }
}
