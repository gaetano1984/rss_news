<?php 

	namespace App\Services;

	use App\Model\News;

	class NewsService{
		public function __construct(){

		}
		public function getNewsToInsert(){
			$arr = [];
			foreach(config('news.source') as $newspaper => $url_rss){
				$xml = simplexml_load_string(file_get_contents($url_rss));
				foreach ($xml->channel->item as $news) {
					$title = strip_tags($news->title);
					$time = date('Y-m-d H:i:d', strtotime($news->pubDate));
					$description = strip_tags($news->description);
					$result = News::where('guid', $news->guid)->get()->toArray();		
					\Log::error('check guid '.print_r($result));
					if(count($result)==0){
						$new_to_insert = new \stdClass();
						$new_to_insert->title = $title;
						$new_to_insert->description = $news->description;
						$new_to_insert->news_date = $time;
						$new_to_insert->guid = $news->guid;
						$new_to_insert->source = $newspaper;
						array_push($arr, $new_to_insert);
					}
				}
			}
			return $arr;
		}

		public function saveNews($news){
			foreach($news as $n){
				$obj = new News();
				$obj->title = $n->title;
				$obj->description = $n->description;
				$obj->news_date = $n->news_date;
				$obj->guid = $n->guid;
				$obj->source = $n->source;
				$obj->save();
			}
		}

		public function latestNews($limit=10, $data=null){
			$n = new News();
			$news = $n->mostRecent($limit, $data);
			return $news;
		}

		public function getSources(){
			$n = new News();
			$sources = $n->getSources();
			return $sources;
		}
	}


 ?>