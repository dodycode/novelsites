<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Novels;

class Genres extends Model
{
    protected $table = 'genres';
    protected $fillable = ['slug', 'nama_genre', 'deleted'];

    public function novels(){
    	return $this->belongsToMany('App\Novels', 'novel_genre', 'id_novel', 'id_genre')
    	->where('novels.deleted', 0);
    }
}
