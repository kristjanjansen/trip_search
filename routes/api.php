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

Route::middleware('api')->get('/search', function () {
    return Content::search(request()->get('q'), function ($client, $body) {

        $query = new MultiMatchQuery(
            ['title^3', 'body'],
            request()->get('q')
        );

        $body->addQuery($query);

        return $client->search(['index' => 'content', 'body' => $body->toArray()]);
    })->get();
    //    return Content::search(request()->get('q'))->get();
});
