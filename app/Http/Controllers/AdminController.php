<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agendado;
use App\Disponibilidade;
use App\Aluno;
use App\Professor;

class AdminController extends Controller
{
    public function todasAulas(){
    	$agendados = Agendado::all();

    	$agendadosTratado = $this->getAulasParaFullCalendar($agendados);

    	return view('admin/admin-todas-aulas')->with('body', 'admin/admin-main-body')->with('aulas', json_encode($agendadosTratado));
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

    public function todasDisponibilidades(){
        $disponibilidades = Disponibilidade::with('professor.user')
                        ->where('status', 'livre')
                        ->get();

        $alunos = Aluno::with('user')->get();        

        $treatedDisponibilidades = $this->getDisponibilidadeParaFullCalendar($disponibilidades);

        //dd($treatedDisponibilidades);

        return view('admin/admin-todas-disponibilidades')->with('body', 'admin/admin-main-body')->with('disponibilidades', json_encode($treatedDisponibilidades))->with('alunos', $alunos);
        
    }

    public function getDisponibilidadeParaFullCalendar($disponibilidades){
        $treatedDisponibilidades =[];
        foreach ($disponibilidades as $disponibilidade) {        
            $disponibilidadeTitle = str_replace(':', 'H', substr($disponibilidade->horario, -8,5)) . ' - ' . $disponibilidade->professor->user->nome;
            $disponibilidadeStart = $disponibilidade->dia . 'T' . $disponibilidade->horario . 'Z';
            
            
            $disponibilidadeNova = ['id' => $disponibilidade->id, 'title' => $disponibilidadeTitle, 'start'=> $disponibilidadeStart, 'color' => "#3aad77"];
            array_push($treatedDisponibilidades, $disponibilidadeNova);            
        }
        
        return $treatedDisponibilidades;
    }

    public function alunos(){
        $alunos = Aluno::all();
        $tipoDeUsuario = "Alunos";
        
        return view('admin/lista-alunos')->with('body', 'admin/admin-main-body')->with('usuarios', $alunos)->with('tipo', $tipoDeUsuario);
    }

    public function professores(){
        $professores = Professor::all();

        //ISSO DAQUI É PARA QUANDO O PROFESSOR ESTÁ SEM USER. TENHO QUE OLHAR ISSO MAIS A FUNDO
        foreach ($professores as $key => $professor) {
            if (!$professor->user) {
                unset($professores[$key]);
            }
        }
        $tipoDeUsuario = "Professores";

        return view('admin/lista-professores')->with('body', 'admin/admin-main-body')->with('professores', $professores)->with('tipo', $tipoDeUsuario);
    }

    public function agendaAluno($id){
        $aluno = Aluno::where('user_id', $id)
                        ->with('agendado.professor.user')
                        ->with('agendado.materia')
                        ->first();
        
        $aulas = $this->getAulasParaFullCalendar($aluno->agendado);

        return view('aluno/aluno-agenda')->with('body', 'admin/admin-main-body')
                                        ->with('aulas', json_encode($aulas));
    }

    public function agendaProfessor($id){
        $professor = Professor::where('user_id', $id)
                                ->with(['disponibilidade' => function($query){
                                    $query->where('status', 'livre');
                                }])
                                ->with('agendado.aluno.user')
                                ->first();      
        
        return view ('professor/professor-agenda')->with('body', 'admin/admin-main-body')
                                                ->with('professor', $professor);
    }
}
