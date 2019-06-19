@extends($body)

@section('container')
<div class="container">
	<h3>{{$tipo}}</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width: 25%">ID</th>
				<th style="width: 30">Nome</th>
				<th style="width: 35%">Email</th>
				<th style="width: 10%">Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($professores as $professor)
				<tr class='clickable-row' data-href='admin_agenda_professor/{{$professor->user->id}}'>
					<td class="id">{{$professor->user->id}}</td>
					<td>{{$professor->user->nome}} {{$professor->user->sobrenome}}</td>
					<td>{{$professor->user->email}}</td>
					<td class="switch">
						<input type="checkbox" checked data-toggle="toggle" data-on="Ativo" data-off="Inativo" data-onstyle="success">
						<input type="hidden" name="professor_status" value="{{$professor->status}}">
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection