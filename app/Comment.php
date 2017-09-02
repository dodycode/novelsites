<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['id_user', 'id_novel', 'ch', 'comment', 'deleted'];

    public function namaUser()
    {
    	return $this->belongsTo('App\User', 'id_user');
    }
}
