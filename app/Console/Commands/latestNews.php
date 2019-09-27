<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsService;

class latestNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:latest {--limit=} {--source=} {--filter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display summary of latest news';

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
        $limit = $this->option('limit');
        $source = $this->option('source');
        $filter = $this->option('filter');

        $data = [
            'source' => $source
            ,'filter' => $filter
        ];

        $news = $newsService->latestNews($limit, $data);

        $table = [];
        foreach ($news as $key => $n) {
            array_push(
                $table
                ,[
                    substr($n['title'], 0, 115)
                    ,date('d-m-Y H:i', strtotime($n['news_date']))
                    ,substr($n['source'], 0, 16)
                ]
            );
        }

        $this->table(['title', 'date', 'source'], $table);
    }
}
