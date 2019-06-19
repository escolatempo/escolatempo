<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Professor;

class ProfessorController extends Controller
{
    public function agendaProfessor(){
    	$professor = Professor::where('user_id', Auth::user()->id)
    							->with(['disponibilidade' => function($query){
    								$query->where('status', 'livre');
    							}])
    							->with('agendado.aluno.user')
    							->first();    	
    	
    	return view ('professor/professor-agenda')->with('body', 'professor/professor-main-body')
    											->with('professor', $professor);
    }
}
