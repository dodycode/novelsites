<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Novels;

class Tags extends Model
{
    protected $fillable = ['slug', 'nama_tag', 'deleted'];
    protected $table = 'tags';

    public function novels(){
    	return $this->belongsToMany('App\Novels', 'tag_novel', 'id_novel', 'id_tag')
    	->where('novels.deleted', 0);
    }
}
