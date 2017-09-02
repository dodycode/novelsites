<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Genres;
use App\TipeNovel;
use App\Chapters;
use App\Rating;
use App\Favorites;
use App\Comment;
use App\Tags;

class Novels extends Model
{
    protected $table = 'novels';
    protected $fillable = ['slug_novel', 'judul_novel', 'desc_novel', 'id_tipe_novel', 'author_novel', 'raw_ft', 'url_raw_ft', 'raw_eng_ft', 'url_raw_eng_ft', 'id_user', 'deleted'];

    public function genres(){
    	return $this->belongsToMany('App\Genres', 'novel_genre', 'id_novel', 'id_genre')->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany('App\Tags', 'tag_novel', 'id_novel', 'id_tag')->withTimestamps();
    }

    public function namatipe()
    {
    	return $this->belongsTo('App\TipeNovel', 'id_tipe_novel');
    }

    public function ratings()
    {
    	return $this->hasMany('App\Rating', 'id_novel');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'id_novel');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorites', 'id_novel');
    }
}
