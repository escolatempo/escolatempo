<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendado extends Model
{
    protected $fillable = ['dia', 'horario', 'sala', 'professor_id', 'aluno_id', 'materia_id', 'status','observacao'];

    public function aluno(){
    	return $this->belongsTo('App\Aluno');
    }

    public function professor(){
    	return $this->belongsTo('App\Professor');
    }

    public function materia(){
    	return $this->belongsTo('App\Materia');
    }
}
