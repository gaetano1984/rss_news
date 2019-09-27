<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = 'news';

    protected $fillable = ['title', 'description', 'news_date', 'source'];

    public function mostRecent($limit=10, $data){
        $query = $this;
        if(array_key_exists('source', $data)){
            $source = explode(',', $data['source']);
            foreach($source as $k=>$s){
                if($s==""){
                    unset($source[$k]);
                }
            }
            if(count($source)>0){
                $query = $query->whereIn('source', $source);                                
            }
        }
        if(array_key_exists('filter', $data)){
            if($data['filter']!=""){
                $query = $query->where('title', 'like', "%".$data['filter']."%");
            }    
        }        
    	return $query->orderBy('news_date', 'desc')->limit($limit)->get()->toArray();
    }

    public function getSources(){
        $query = $this;
        $sources = $query->select('source')->distinct()->get()->toArray();
        return $sources;
    }
}
