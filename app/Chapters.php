<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Novels;
use App\FT;

class Chapters extends Model
{
    protected $table = 'releases';
    protected $fillable = ['id_novel', 'chapter', 'url', 'tanggal', 'id_ft', 'id_user', 'deleted'];

    public function novels()
    {
    	return $this->belongsTo('App\Novels', 'id_novel');
    }

    public function ft()
    {
    	return $this->belongsTo('App\FT', 'id_ft');
    }
}
