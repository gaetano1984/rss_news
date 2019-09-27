<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsService;

class updateNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update local db with fresh news';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(NewsService $newsService)
    {
        //
        $news = $newsService->getNewsToInsert();
        if(count($news)>0){
            $newsService->saveNews($news);    
            foreach($news as $n){
                $this->info($n->source." ".$n->news_date.": ".$n->title);
            }
        }
    }
}
