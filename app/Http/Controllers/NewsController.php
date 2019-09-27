<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsService;

class NewsController extends Controller
{
    //
    public $newsService;

    public function __construct(NewsService $newsService){
    	$this->newsService = $newsService;
    }

    public function getSources(){
    	$sources = $this->newsService->getSources();
    	return $sources;
    }
}
