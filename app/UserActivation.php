<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    protected $table = 'user_activations';
    protected $fillable = ['id_user', 'token'];
}
