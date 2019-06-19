$(document).ready(function(){
	fillCalendar();
	$("#confirmeCancelamento").click(cancelarAula);
});

var fillCalendar = function(){
	var events = $("#aulas").val();

	$('#calendar').fullCalendar({
		events : jQuery.parseJSON(events),

		lang: 'pt-br',

		header: {
	        left: 'prev,next today',
	        center: 'title'
    	},

    	eventClick: function(event){
    		openAgendadoModal(event);
    	}
	});
}

var openAgendadoModal = function(event){
	$("#nomeAluno").val('');
	$("#observacoes").val('');
	$("#agendadoModal").modal('toggle');
	var token =  $('meta[name="csrf-token"]').attr('content');
	var agendadoId = event.id;

	$("#cancelarAgendado").click(function(){
		$("#confirmeCancelamento").removeClass('hidden');		
	});
	
	$('#agendadoModal').on('hide.bs.modal', function(){
		$('#confirmeCancelamento').addClass('hidden');
	});

	$.ajax({
		type: 'GET',
		url: '/get/agendadoPorId',
		data : ({
			agendadoId: agendadoId,
			_token : token})
	}).done(function(result){		
		$('.modal-title').text('Aula agendado por: ' + result.aluno.user.nome + ' ' + result.aluno.user.sobrenome);
		$("#materia").val(result.materia.nome);
		$("#observacoes").val(result.observacao);
		$("#agendadoId").val(result.id);
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente mais tarde.';

		mostrarAlert($class, $message);
		closeModal();
	});
}

var cancelarAula = function(){
	var agendadoId = $("#agendadoId").val();
	var token =  $('meta[name="csrf-token"]').attr('content');

	$.ajax({
		type: 'POST',
		url: '/cancela_aula',
		data : ({
			agendadoId: agendadoId,
			_token : token})
	}).done(function(result){		
		var event = $('#calendar').fullCalendar('clientEvents', agendadoId);

		var newEvent = {
			'id': event[0].id,
			'title': event[0].title,
			'start': event[0].start,
			'color': '#ad3a60'
		}


		$('#calendar').fullCalendar('removeEvents', agendadoId);
		$('#calendar').fullCalendar('renderEvent', newEvent, true);


		var $class = 'alert-success';
		var $message = 'A sua aula foi cancelada com sucesso.';

		mostrarAlert($class, $message);
		closeModal();
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente mais tarde';

		mostrarAlert($class, $message);
		closeModal();
	});

}