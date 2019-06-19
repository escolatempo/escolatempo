<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nome'];

    public function materiasProfessor(){
    	return $this->hasMany('App\MateriasProfessor');
    }

    public function agendado(){
    	return $this->hasMany('App\Agendado');
    }
    
}
