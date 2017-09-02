<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Chapters;
use App\Novels;
use App\Likes;

class FT extends Model
{
    protected $table = 'fantranslations';
    protected $fillable = ['nama_ft', 'slug', 'url', 'approve', 'id_user', 'deleted'];

    public function chapters()
    {
    	return $this->hasMany('App\Chapters', 'id_ft')
    	->where('releases.deleted', 0);
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function novels()
    {
    	return $this->hasMany('App\Novels', 'id_ft')
    	->where('novels.deleted', 0);
    }

    public function likes()
    {
        return $this->hasMany('App\Likes', 'id_ft')
        ->where('likes.deleted', 0);
    }
}
