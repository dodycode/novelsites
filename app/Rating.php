<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Novels;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = ['id_user', 'id_novel', 'buruk', 'biasa', 'luarbiasa'];

    public function novels()
    {
    	return $this->belongsTo('App\Novels', 'id_novel');
    }
}
