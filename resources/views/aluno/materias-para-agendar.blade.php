@extends($body)
@section('container')
	<div class="col-xs-3">
		<label>Selecione a Materia</label>
		<select class="materiasSelect form-control">
		</select>
		<br>
		<br>
		<button class="btn btn-primary" id="agendaPorMateria">Selecionar</button>
	</div>
@endSection