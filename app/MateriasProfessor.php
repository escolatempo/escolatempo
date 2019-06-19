<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriasProfessor extends Model
{
    protected $fillable= ['professor_id', 'materia_id'];

    public function professor(){
    	return $this->belongsTo('App\Professor');
    }

    public function materia(){
    	return $this->belongsTo('App\Materia');
    }
}
