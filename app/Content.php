<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
//use ScoutElastic\Searchable;

class Content extends Model
{
    use Searchable;

    // protected $indexConfigurator = ContentIndexConfigurator::class;

    // protected $searchRules = [
    //     //
    // ];

    // protected $mapping = [
    //     'properties' => [
    //         'title' => [
    //             'type' => 'text',
    //         ],
    //         'body' => [
    //             'type' => 'text',
    //         ],
    //     ]
    // ];

    protected $fillable = ['id', 'title', 'body', 'created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function searchableAs()
    {
        return 'content_index';
    }

    public function toSearchableArray()
    {
        return $this->toArray();
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