$(document).ready(function(){
	fillCalendar();
	$("#agendar_aula").click(agendaAula);
});

var fillCalendar = function(){
	var events = $(".disponibilidades-para-agendar").val();	
	$('#calendar').fullCalendar({
		events : jQuery.parseJSON(events),

		lang: 'pt-br',

		header: {
	        left: 'prev,next today',
	        center: 'title'
    	},

    	eventClick : function(event){    		
    		openHorarioModal(event);
    	},

    	titleFormat: '[Horários Disponíveis para ' + $("#materiaNome").val() + ' em] MMMM'
	});
}

var openHorarioModal = function(event){
	var horario = event.start._i;
	var materiaId = $('#materiaId').val()

	$.ajax({
		type: 'GET',
		url: '/disponibilidadePorDiaHorario/',
		data : ({
			horario : horario,
			materiaId : materiaId
		})
	}).done(function(result){
		fillModal(result)
	}).fail(function(){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente de novo mais tarde';

		mostrarAlert($class, $message);		
	})


	$("#agendarAulaModal").modal('toggle');
}

var fillModal = function(disponibilidades){
	//limpa o select
	$('.agendamentoSelect').empty();

	horario = disponibilidades[0]['horario'].substr(0,5);
	dia = disponibilidades[0]['dia'].substr(8,2) + ' - ' + disponibilidades[0]['dia'].substr(5,2);
	
	$(".modal-title").text('Selecione um professor para agendar a aula as ' + horario + ' no dia ' + dia);

	$.each(disponibilidades, function(i, disponibilidade){
		$('.agendamentoSelect').append($('<option>', {
			value: disponibilidade.id,
			text: disponibilidade.professor.user.nome + ' ' + disponibilidade.professor.user.sobrenome
		}));
	})
}

var agendaAula = function(){
	var disponibilidadeId = $('.agendamentoSelect').val();
	var observacao = $("#observacao").val();
	var materiaId = $('#materiaId').val();
	var token =  $('meta[name="csrf-token"]').attr('content');

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