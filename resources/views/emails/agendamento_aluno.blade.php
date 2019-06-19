<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h2>Aula agendada</h2>
	<h4>Você agendou uma aula de {{$agendado->materia->nome}} no dia {{$agendado->dia}} as {{$agendado->horario}} com o professor {{$agendado->professor->user->nome}} {{$agendado->professor->user->sobrenome}}. Boa aula.</h4>
</body>
</html>