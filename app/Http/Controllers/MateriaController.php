<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Materia;
use App\MateriasProfessor;

class MateriaController extends Controller
{
    public function getStaticMaterias(){
    	return Materia::all();
    }

    public function saveProfessorMaterias(){        
    	//test if is some materia selected
    	if (!isset(Request::all()['data'])) {
    		$materias = [];
    	}else{
    		$materias = Request::all()['data'];    		
    	}
    	
    	$oldMaterias = MateriasProfessor::where('professor_id', Auth::user()->professor->id)->get();

    	//Check if as any materia to delete    	
    	$this->checkMateriaToDelete($oldMaterias, $materias);
		
		//add new materias;
    	$this->addNewMaterias($oldMaterias, $materias);

    	return 'true';
    }

    private function checkMateriaToDelete($oldMaterias, $materias){
    	foreach ($oldMaterias as $oldMateria) {    		
    		$mustDelete = true;
    		foreach ($materias as $materia){    			
    			if ($materia == $oldMateria->materia_id) {
    				$mustDelete = false;
    				break;
    			}
    		}
    		if ($mustDelete) {
    			$oldMateria->delete();
    		}
    	}
    }

    private function addNewMaterias($oldMaterias, $materias){
    	$arrayOfId = [];

    	foreach ($oldMaterias as $oldMateria) {
    		array_push($arrayOfId, $oldMateria->materia_id);
    	}

    	foreach ($materias as $materia) {
    		if (!in_array($materia, $arrayOfId)) {
	    		MateriasProfessor::create([
	    							'professor_id' => Auth::user()->professor->id,
	    							'materia_id' => $materia
	    									]);    			
    		}
    	}
    }
}
