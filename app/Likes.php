<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FT;

class Likes extends Model
{
    protected $table = 'likes';
    protected $fillable = ['id_user', 'id_ft', 'deleted'];

    public function ft()
    {
    	return $this->belongsTo('App\FT', 'id_ft');
    }
}
