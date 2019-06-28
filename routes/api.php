<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Content;
use ONGR\ElasticsearchDSL\Query\FullText\MultiMatchQuery;
use ONGR\ElasticsearchDSL\Highlight\Highlight;

Route::middleware('api')->get('/search', function () {
    return Content::search(request()->get('q'), function ($client, $body) {
        $query = new MultiMatchQuery(
            ['title^3', 'body^2', 'comments'],
            request()->get('q')
        );
        $body->addQuery($query);

        $highlight = new Highlight();
        $highlight->addField('title');
        $highlight->addField('body');
        $highlight->addField('comments');
        
        $body->addHighlight($highlight);

        return $client->search(['index' => 'content', 'body' => $body->toArray()]);
    })
    ->raw();
    //->get()
    //->load('comments');
    //    return Content::search(request()->get('q'))->get();
});
