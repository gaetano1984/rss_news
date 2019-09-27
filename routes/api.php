<?php

use Illuminate\Http\Request;
use App\Services\NewsService;
use App\Http\Controllers\NewsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('latest', function(Request $request, NewsService $newsService){
	$data = [];
	$request = $request->getContent();
	$request = json_decode($request, TRUE);
	if(count($request['source'])>0){
		$data['source'] = $request['source'];
	}
	$news = $newsService->latestNews(15, $data);
	return Response::json($news);
});

Route::get('getsources', function(Request $request, NewsController $newsController){
	$sources = $newsController->getSources();
	return Response::json($sources);
});