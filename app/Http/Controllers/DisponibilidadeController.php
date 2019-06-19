<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Disponibilidade;
use App\Professor;

class DisponibilidadeController extends Controller
{
    public function getProfessorDisponibilidade(){
    	return Disponibilidade::where('professor_id', Auth::user()->professor->id)->get();
    }

    public function getDias(){
    	$dias = [];

    	for ($i=0; $i < 30; $i++) { 
    		$dia = ['id'=> $i, 'text' => $i];
    		array_push($dias, $dia);
    	}

    	return $dias;
    }

    public function addDisponibilidade(){    	
    	$professorId = Auth::user()->professor->id;
    	$diasDaSemana = Request::only('dias')['dias'];
    	$horarioPeriodos = Request::only('periodos');

    	$formaDeRepeticao = Request::only('formaDeRepeticao')['formaDeRepeticao'];

    	if ($formaDeRepeticao == "Meses") {
    		$mesesParaRepetir = Request::only('mes');
    		$datas = $this->pegaDatasPeloMes($mesesParaRepetir);

    		$datasSelecionadas = $this->getDatasSelecionadas($datas, $diasDaSemana);
    		$horarios = $this->getArrayDeHorarios($horarioPeriodos);

    		$arrayDeDisponibilidade = $this->montaArrayParaAdd($datasSelecionadas, $horarios, $professorId);
    		//$arrayDeDisponibilidade = $this->tiraHorarioEmConflito($arrayDeDisponibilidade, $professorId);

    		Disponibilidade::insert($arrayDeDisponibilidade);

    	}else if ($formaDeRepeticao == "Período") {            
    		$repeticaoInicio = Request::only('repeticaoInicio')['repeticaoInicio'];
    		$repeticaoFim = Request::only('repeticaoFim')['repeticaoFim'];
    		
    		$datas = $this->getDatesPorPeriodo($repeticaoInicio, $repeticaoFim);
    		$datasSelecionadas = $this->getDatasSelecionadas($datas, $diasDaSemana);
    		$horarios = $this->getArrayDeHorarios($horarioPeriodos);

    		$arrayDeDisponibilidade = $this->montaArrayParaAdd($datasSelecionadas, $horarios, $professorId);

    		Disponibilidade::insert($arrayDeDisponibilidade);
    	}
    }

    private function getDatasSelecionadas($datas, $diasDaSemana){
    	$datasSelecionadas = [];
    	
    	foreach ($datas as $data) {
    		$data = $data->format('Y-m-d');
    		
    		if ($this->verificaODia($data, $diasDaSemana)) {
    			array_push($datasSelecionadas, $data);
    		}
    	}
    	return $datasSelecionadas;    	
    }

    private function getDatesPorPeriodo($repeticaoInicio, $repeticaoFim){
    	$inicioTratado = substr($repeticaoInicio, -4) . "-" . substr($repeticaoInicio, -7, 2) . "-" . substr($repeticaoInicio, -10, 2);
    	$fimTratado = substr($repeticaoFim, -4) . "-" . substr($repeticaoFim, -7, 2) . "-" . strval(substr($repeticaoFim, -10, 2) +1);
    	$interval = new \DateInterval('P1D');
    	
    	$datas = new \DatePeriod(new \DateTime($inicioTratado),$interval ,new \DateTime($fimTratado));

    	return $datas;
    }

   
    private function verificaODia($data, $dias){    	
    	if (in_array(date('N', strtotime($data)), $dias)) {
    		return true;
    	}
    	return false;    	
    }

    private function getArrayDeHorarios($periodos){
    	$disponibilidades = [];
    	
    	foreach ($periodos['periodos'] as $periodo){
    		array_push($disponibilidades, $periodo['inicio'] . ":00");
    	
    		$inicio = intval($periodo['inicio']) + 1;
    		$fim = intval($periodo['fim']);

    		for ($i=$inicio*100; $i < $fim*100 ; $i+=100) {
    			$hora = strval($i / 100);
    			
    			$horario1 = $hora . ":00:00";
    			$horario2 = $hora . ":30:00";

    			array_push($disponibilidades, $horario1);
    			array_push($disponibilidades, $horario2);
    		}
    	}

    	return $disponibilidades;
    }

    private function montaArrayParaAdd($datasSelecionadas, $horarios, $professorId){
    	$arrayParaAdd = [];
    	foreach ($datasSelecionadas as $data) {
    		
    		foreach ($horarios as $horario) {
    			$novaDisponibilidade = [
    					'professor_id' => $professorId,
    					'dia' => $data,
    					'horario' => $horario
    					];

    			array_push($arrayParaAdd, $novaDisponibilidade);
    		}

    	}

    	return $arrayParaAdd;
    }

    private function pegaDatasPeloMes($meses){
    	$datas = [];
    	$interval = new \DateInterval('P1D');

    	foreach ($meses['mes'] as $mes) {
    		if ($mes >= date('n')) {
    			$ano = date('Y');	
    		}else{
    			$ano = date('Y') + 1;
    		}

    		if (strlen($mes) == 1) {
	    		$mes = "0" . $mes;
	    	}
	    	
    		$inicio = $ano . '-' . $mes . "-01";
    		$fim = $this->getFinal($mes, $ano);

    		$novasDatas = new \DatePeriod(new \DateTime($inicio),$interval ,new \DateTime($fim));

    		foreach ($novasDatas as $data) {
    			array_push($datas, $data);
    		}

    	}

    	return $datas;
    }

    private function getFinal($mes, $ano){
    	if ($mes == 12) {
    		$ano = $ano+1;
    		$mes = '01';

    		return $ano . '-' . $mes . "-01";
    	}

    	$mes = $mes +1;
    	if (strlen($mes) == 1) {
	    	$mes = "0" . $mes;
	    }

	    return $ano . '-' . $mes . "-01";
    }
    /*
    private function tiraHorarioEmConflito($arrayDeDisponibilidade, $professorId){
    	$disponibilidadeSalvas =  Disponibilidade::where('professor_id', $professorId)->get();
    	$teste =[];
    	foreach ($disponibilidadeSalvas as $disponibilidade) {
    		
    	}
    	dd($teste);
    }
    */

    public function getDisponibilidadePorDiaHorario(){
        $horarioTreat = str_replace('%3A', ':', Request::all()['horario']);
        $horario = substr($horarioTreat, -9, 8);
        $dia = substr($horarioTreat, 0, -10);        
        $materiaId = Request::all()['materiaId'];
        
        $disponibilidades = Disponibilidade::with('professor')
                                            ->with('professor.user')
                                            ->where('status', 'livre')
                                            ->where('dia', $dia)
                                            ->where('horario', $horario)
                                            ->whereHas('professor.materia', function($query) use ($materiaId){
                                                $query->where('materia_id', $materiaId);
                                            })->get();

        return $disponibilidades;
    }

    public function cancelaDisponibilidade(){
        Disponibilidade::find(Request::all()['disponibilidadeId'])->delete();
    }

    public function getDisponibilidadeById($id){
        $disponibilidade = Disponibilidade::with('professor.user')->with('professor.materia.materia')->where('id', $id)->first();
        
        return $disponibilidade;
    }

}