<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Disponibilidade extends Model
{
    protected $fillable = ['professor_id', 'horario', 'dia', 'status'];

    public function professor(){
    	return $this->belongsTo('App\Professor');
    }    
}
