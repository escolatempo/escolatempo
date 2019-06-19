<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Agendado;
use App\Disponibilidade;
use App\Mail\NovoAgendamento;
use App\Mail\AgendamentoProfessor;
use App\Mail\CancelarAula;

class AgendadoController extends Controller
{
	public function getUserAgendamentos(){		
		if (Auth::user()->user_type == 'professor') {
			return Agendado::where('professor_id', Auth::user()->professor->id)
					->with('aluno.user')
					->with('professor.user')
					->with('materia')
					->get();
		}else if (Auth::user()->user_type == 'aluno') {
			return Agendado::where('aluno_id', Auth::user()->aluno->id)
					->with('aluno')
					->with('professor')
					->with('materia')
					->get();
		}else{
			//colocar aqui caso seja o admin
		}
	}

	public function agendaAula(){

		$disponibilidade = Disponibilidade::with('professor')
							->find(Request::all()['disponibilidade']);

		$horario = $disponibilidade->horario;
		$dia = $disponibilidade->dia;		
		$professorId = $disponibilidade->professor->id;

		if (isset(Request::all()['alunoId'])) {
			$alunoId = Request::all()['alunoId'];
		}else{
			$alunoId = Auth::user()->aluno->id;
		}

		$observacao = Request::all()['observacao'];
		$materiaId = Request::all()['materiaId'];

		if (count(Agendado::where('aluno_id', $alunoId)
		->where('dia', $dia)
		->where('horario', $horario)
		->where('status', 'agendado')->get()) !=0) {
			return 'conflito de horario';
		}		

		$disponibilidadesId = [$disponibilidade->id];
		
		foreach ($this->changeDisponibilidadesStatus($horario, $dia, 'comAula', $professorId) as $id) {
			array_push($disponibilidadesId, $id);
		}


		$agendado = Agendado::create(['horario' => $horario, 'dia' => $dia, 'sala' => 1, 'professor_id' => $professorId, 'aluno_id' => $alunoId, 'observacao' => $observacao, 'materia_id' => $materiaId]);

		$disponibilidade->update(['status' => 'comAula']);

		
		$agendadoInfo = Agendado::where('id', $agendado->id)
		 				->with('professor.user')
						->with('aluno.user')
						->with('materia')
						->first();
		
		$emailProfessor = $agendadoInfo->professor->user->email;
		$emailAluno = $agendadoInfo->aluno->user->email;
		
		\Mail::to($emailAluno)->send(new NovoAgendamento($agendadoInfo));
		\Mail::to($emailProfessor)->send(new AgendamentoProfessor($agendadoInfo));
		
		return $disponibilidadesId;
	}

	private function changeDisponibilidadesStatus($horario, $dia, $status, $professorId){
		$proximoHorario = new \DateTime($horario);
		$proximoHorario->modify('+30 minutes');

		$anteriorHorario = new \DateTime($horario);
		$anteriorHorario->modify('-30 minutes');

		$disponibilidades = Disponibilidade::where(function($query) use ($proximoHorario, $anteriorHorario){
										$query->where('horario', '=', $proximoHorario->format('H:i:s'));
										$query->orWhere('horario', '=', $anteriorHorario->format('H:i:s'));
									})
									->where('dia', '=', $dia)
									->where('professor_id', '=', $professorId);
		
		$disponibilidadesId = [];
		foreach ($disponibilidades->get() as $disponibilidade) {
			array_push($disponibilidadesId, $disponibilidade->id);
		}

		$disponibilidades->update(['status' => $status]);
		return $disponibilidadesId;
	}

	public function getAgendadoById(){		
		$agendado = Agendado::where('id', Request::all()['agendadoId'])
							->with('aluno')
							->with('aluno.user')
							->with('professor')
							->with('professor.user')
							->with('materia')
							->first();

		return $agendado;
	}

	public function cancelaAula(){
		
		// QUALQUER UM ESTÁ CONSEGUINDO CANCELAR, PRECISO TESTAR QUEM É O USUARIO ANTES DE CANCELAR.
		$agendado = Agendado::find(Request::all()['agendadoId']);

		$horario = $agendado->horario;
		$professorId = $agendado->professor_id;
		$dia = $agendado->dia;

		$agendado->update(['status' => 'cancelado']);

		$proximoHorario = new \DateTime($horario);
		$proximoHorario->modify('+30 minutes');

		$anteriorHorario = new \DateTime($horario);
		$anteriorHorario->modify('-30 minutes');

		$disponibilidadesProfessor = Disponibilidade::where(function($query) use ($proximoHorario, $anteriorHorario, $horario){
										$query->where('horario', '=', $proximoHorario->format('H:i:s'));
										$query->orWhere('horario', '=', $anteriorHorario->format('H:i:s'));
										$query->orWhere('horario', '=', $horario);
									})
									->where('dia', '=', $dia)
									->where('professor_id', '=', $professorId);

		$disponibilidades = $disponibilidadesProfessor->get();
		$disponibilidadesProfessor->update(['status' => 'livre']);

		$disponibilidadesId = [];
		foreach ($disponibilidades as $disponibilidade) {
			array_push($disponibilidadesId, $disponibilidade->id);
		}

		$agendadoInfo = Agendado::where('id', Request::all()['agendadoId'])
		 				->with('professor.user')
						->with('aluno.user')
						->with('materia')
						->first();
		
		$emailProfessor = $agendadoInfo->professor->user->email;
		$emailAluno = $agendadoInfo->aluno->user->email;

		\Mail::to($emailAluno)->send(new CancelarAula($agendadoInfo));
		\Mail::to($emailProfessor)->send(new CancelarAula($agendadoInfo));

		return $disponibilidadesId;
	}

	public static function passAgendados(){
		echo (Agendado::all());
	}
}
