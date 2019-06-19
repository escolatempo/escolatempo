<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use App\Disponibilidade;
use App\Materia;
use App\Aluno;

class AlunoController extends Controller
{
    public function viewAgendarAula(){
    	return view('aluno/materias-para-agendar')->with('body', 'aluno/aluno-main-body');
    }

    public function viewAgendaPorMateria($materiaId){
        $disponibilidades = Disponibilidade::with('professor')
                                        ->where('status', 'livre')
                                        ->whereHas('professor.materia', function($query) use ($materiaId){
                                            $query->where('materia_id', $materiaId);
                                        })->get();

        $treatedDisponibilidades = $this->getDisponibilidadeSemRepeticao($disponibilidades);
        $materia = Materia::find($materiaId);

        return view('aluno/disponibilidades-para-agendar')->with('body', 'aluno/aluno-main-body')->with('disponibilidades', json_encode($treatedDisponibilidades))->with('materiaId', $materiaId)->with('materiaNome', $materia->nome);
    }

    //Monta a disponibilidade com as configurações pro fullCalendar
    public function getDisponibilidadeSemRepeticao($disponibilidades){
        $disponibilidadesSemRepeticao =[];
		
        foreach ($disponibilidades as $disponibilidade) {
            $disponibilidadeTitle = str_replace(':', 'H', substr($disponibilidade->horario, -8,5)) . ' - Disponível';
            $disponibilidadeStart = $disponibilidade->dia . 'T' . $disponibilidade->horario . 'Z';

            $repeticao = false;
            foreach ($disponibilidadesSemRepeticao as $disponibilidadeSemRepeticao) {
                if (in_array($disponibilidadeStart, $disponibilidadeSemRepeticao)) {
                    $repeticao = true;
                    break;
                }
            }
            
            if ($repeticao == false) {
        		$disponibilidadeNova = ['id' => $disponibilidade->id, 'title' => $disponibilidadeTitle, 'start'=> $disponibilidadeStart, 'color' => "#3aad77"];
                array_push($disponibilidadesSemRepeticao, $disponibilidadeNova);
            }         
    	}
        
        return $disponibilidadesSemRepeticao;
    }

    public function AgendaAluno(){
        $aluno = Aluno::where('user_id', Auth::user()->id)
                        ->with('agendado.professor.user')
                        ->with('agendado.materia')
                        ->first();
        
        $aulas = $this->getAulasParaFullCalendar($aluno->agendado);

        return view('aluno/aluno-agenda')->with('body', 'aluno/aluno-main-body')
                                        ->with('aulas', json_encode($aulas));
    }

    private function getAulasParaFullCalendar($agendados){
        $agendadosForFC = [];

        foreach ($agendados as $agendado) {         
            $agendadoNovoTitle = substr($agendado->horario, 0, 5) . ' - ' . $agendado->professor->user->nome . ' ' . $agendado->professor->user->sobrenome;
            $agendadoNovoStart = $agendado->dia . 'T' . $agendado->horario . 'Z';

            if ($agendado->status == 'agendado') {
                $color = '#3a87ad';
            }elseif ($agendado->status == 'cancelado') {
                $color = '#ad3a60';
            }elseif ($agendado->status == 'dada') {
                $color = '#3aad77';
            }


            $agendadoNovo = ['id' => $agendado->id, 'title' => $agendadoNovoTitle, 'start' => $agendadoNovoStart, 'color' => $color, 'materia' => $agendado->materia->nome];

            array_push($agendadosForFC, $agendadoNovo);
        }

        return $agendadosForFC;
    }

    public function teste(){
        return view('teste');
    }
}
