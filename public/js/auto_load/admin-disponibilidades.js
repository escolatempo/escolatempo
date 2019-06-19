$(document).ready(function(){
	fillCalendar();
	$('#agendar_aula').click(agendaAula);
});

var fillCalendar = function(){
	var events = $("#disponibilidades").val();

	$('#calendar').fullCalendar({
		events : jQuery.parseJSON(events),

		lang: 'pt-br',

		header: {
	        left: 'prev,next today',
	        center: 'title'
    	},

    	eventClick: function(event){
    		openHorarioModal(event);
    	}
	});
}

var openHorarioModal = function(event){	
	$('#materiaSelect').empty();
	$('#professorSelect').empty();
	
	var id = event.id;
	$('#disponibilidade_id').val(event.id);
	console.log(id);
	$.ajax({
		type: 'GET',
		url: '/disponibilidadeById/' + id,
	}).done(function(result){
		console.log(result);
		$('#professorSelect').append('<option value="' + result.professor.id + '">' + result.professor.user.nome + ' ' + result.professor.user.sobrenome + '</option>');
		$.each(result.professor.materia, function( key, value ) {			
  			$('#materiaSelect').append('<option value="' + value.materia.id + '">' + value.materia.nome + '</option>');
		});
	}).fail(function(){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente de novo mais tarde';

		mostrarAlert($class, $message);		
	})

	$("#agendarAulaModal").modal('toggle');
}

var agendaAula = function(){
	var disponibilidadeId = $('#disponibilidade_id').val();
	var observacao = $("#observacao").val();
	var materiaId = $('#materiaSelect').val();
	var token =  $('meta[name="csrf-token"]').attr('content');
	var alunoId = $('#alunoSelect').val();

	$("#agendarAulaModal").modal('toggle');
	$("#observacao").val('');	

	var $class = 'alert-info';
	var $message = 'Sua aula está sendo agendada, por favor aguarde um instante';

	mostrarAlert($class, $message);
	
	$.ajax({
		type: 'POST',
		url: '/post/agenda_aula',
		data: ({
			_token: token,
			disponibilidade: disponibilidadeId,
			observacao: observacao,
			materiaId: materiaId,
			alunoId: alunoId,
		})
	}).done(function(result){
		if (result == 'conflito de horario') {
			var $class = 'alert-danger';
			var $message = 'Você já tem uma aula agendada neste horario';

			mostrarAlert($class, $message);
			return false;
		}

		$(result).each(function(){			
			$("#calendar").fullCalendar('removeEvents', this);
		});
		var $class = 'alert-success';
		var $message = 'Sua aula foi agendada com sucesso';

		mostrarAlert($class, $message);
	}).fail(function(){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente de novo mais tarde';

		mostrarAlert($class, $message);
	})
}