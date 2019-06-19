@extends($body)

@section('container')
<div class="container">
	<h3>{{$tipo}}</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width: 25%">ID</th>
				<th style="width: 40">Nome</th>
				<th style="width: 35%">Email</th>
			</tr>
		</thead>
		<tbody>
			@foreach($usuarios as $user)
				<tr class='clickable-row' data-href='admin_agenda_aluno/{{$user->user->id}}'>
					<td>{{$user->user->id}}</td>
					<td>{{$user->user->nome}} {{$user->user->sobrenome}}</td>
					<td>{{$user->user->email}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection