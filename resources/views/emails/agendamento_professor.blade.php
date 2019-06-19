<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h2>Nova aula agendada</h2>
	<h4>O aluno {{$agendado->professor->user->nome}} {{$agendado->professor->user->sobrenome}} agendou com você uma aula de {{$agendado->materia->nome}} no dia {{$agendado->dia}} as {{$agendado->horario}}. Confira sua agenda e boa aula.</h4>
</body>
</html>