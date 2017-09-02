<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Novels;
use App\User;

class Favorites extends Model
{
    protected $table = 'favorites';
    protected $fillable = ['id_user', 'id_novel', 'deleted'];

    public function novels()
    {
    	return $this->belongsTo('App\Novels', 'id_novel');
    }
}
