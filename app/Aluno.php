<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{

	protected $fillable = ['user_id'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function agendado(){
    	return $this->hasMany('App\Agendado');
    }
}
