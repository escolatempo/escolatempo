@extends($body)

@section('container')	
<div class="col-xs-12">
	<div id="calendar"></div>
</div>
<input type="hidden" name="disponibilidades" value="{{$disponibilidades}}" id="disponibilidades">

<div class="modal fade" id="agendarAulaModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Agendar Aula</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-xl-8">
					<input type="hidden" name="disponibilidade_id" value="" id="disponibilidade_id">
					<label>Selecione o aluno</label>
					<select class="form-control" name="aluno" id="alunoSelect">
						@foreach($alunos as $aluno)
						<option value="{{$aluno->id}}">{{$aluno->user->nome}} {{$aluno->user->sobrenome}}</option>
						@endforeach
					</select>
					<br>
					<label>Professor Selecionado</label>
					<select class="form-control" name="professor" disabled id="professorSelect">

					</select>
					<br>
					<label>Materia da aula</label>
					<select class="form-control" name="materia" id="materiaSelect">

					</select>
					<label>Se quiser deixe uma observação para o professor.</label>
					<textarea class="form-control" rows="5" name="observacao" id="observacao"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="agendar_aula">Agendar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

@endsection