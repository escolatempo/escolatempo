<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = ['user_id'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function disponibilidade(){
    	return $this->hasMany('App\Disponibilidade');
    }

    public function agendado(){
    	return $this->hasMany('App\Agendado');
    }

    public function materia(){
        return $this->hasMany('App\MateriasProfessor');
    }
}
