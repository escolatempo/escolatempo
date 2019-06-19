$(document).ready(function(){
	fillCalendar();
	fillHorarioSelectForDisponibilidade();
	fillCalendarIndex();
	$("#minhaAgenda_adicionarDisponibilidade").click(adicionarDisponibilidade);
	$("#minhaAgenda_horariosInicio").change(loadHorariosFim);
	$("#minhaAgenda_adicionarPeriodo").click(adicionarPeriodo);
	$("#minhaAgenda_closeModal").click(closeModal);
	$("#minhaAgenda_formaRepeticao").change(mudarFormaRepeticao);
	$('#confirmeCancelamento').click(cancelaAula);
	$("#confirmeCancelamentoDisponibilidade").click(cancelaDisponibilidade);
});

var closeModal = function(event){
	event.preventDefault();

	$("#minhaAgenda_periodosSelecionados").empty();
	$("#minhaAgenda_listaDePeriodos").addClass('hide');

	fillHorarioSelectForDisponibilidade();
	$("#minhaAgenda_inicioPeriodo").val('');
	$("#minhaAgenda_fimPeriodo").val('');

	$("#addDisponibilidadeModal").modal('toggle');
}

var treatAgendado = function(id, dia, horario, status, alunoNome){
	var time = horario.slice(0, -3).replace(':', 'H');
	var title = time + " - " + alunoNome;
	var start = dia + "T" + horario + "Z";	
	
	if (status == 'agendado') {
		var color = '#3a87ad';
	}else if (status == 'cancelado') {
		var color = '#ad3a60';
	}else if (status == 'dada') {
		var color = '#3aad77';
	}
		
	event = {'id': id, 'title': title , 'start': start, 'color': color};

	return event;
}

var treatDisponibilidade = function(id, dia, horario){
	var time = horario.slice(0, -3).replace(':', 'H');
	var title = time + " - Disponível";
	var start = dia + "T" + horario + "Z";
	var color = 'white';
	var textColor = 'black';

	event = {'id': id, 'title': title , 'start': start, 'color': color, 'textColor': textColor};

	return event;
}

var fillCalendar = function(){	
	$('#calendar').fullCalendar({
    	events : getEvents(),

    	lang: 'pt-br',

        header: {
	        left: 'prev,next today',
	        center: 'title',
	        right: ''
    	},

    	dayClick: function(){    		
    		$("#addDisponibilidadeModal").modal('show');
    	},

    	eventClick: function(event){
    		if (event.color == 'white') {
    			openDisponibilidadeModal(event);
    		}else if (event.color == '#3a87ad'){
    			openAgendadoModal(event);
    		}else if (event.color == '#3aad77') {
    			openDadaModal(event);
    		}
    	}
    });
}

var getEvents = function(){
	events = [];

	$.each($(".professor_disponibilidade"), function(){
		var id = $(this).find(".disponibilidade_id").val();
		var dia = $(this).find(".disponibilidade_dia").val();
		var horario = $(this).find(".disponibilidade_horario").val();

		var disponibilidade = treatDisponibilidade(id, dia, horario);
		
		events.push(disponibilidade);
	})

	$.each($(".professor_agendado"), function(){
		var id = $(this).find(".agendado_id").val();
		var dia = $(this).find(".agendado_dia").val();
		var horario = $(this).find(".agendado_horario").val();
		var status = $(this).find(".agendado_status").val();
		var alunoNome = $(this).find(".agendado_nome_aluno").val();

		var agendado = treatAgendado(id, dia, horario, status, alunoNome);
		
		events.push(agendado);
	})

	return events;
}

var adicionarDisponibilidade = function(){	
	var periodos = [];
	var dias = [];
	var mes = [];
	var repeticaoInicio = $("#minhaAgenda_inicioPeriodo").val();
	var repeticaoFim = $("#minhaAgenda_fimPeriodo").val();
	
	var token =  $('meta[name="csrf-token"]').attr('content');

	//pega todos os periodos selecionados
	$.each($("#minhaAgenda_periodosSelecionados").find('li'), function(){		
		periodo = {inicio : $(this).find('.inicioValue').val(),
					 fim: $(this).find('.fimValue').val()}

		periodos.push(periodo);
	});


	//pega todos os dias selecionados
	$.each($("#minhaAgenda_diasDaSemana").find(':checked'), function(){
		dias.push($(this).val());
	});

	//pega todos os dias selecionados
	$.each($("#minhaAgenda_meses").find(':checked'), function(){
		mes.push($(this).val());
	});

	var formaDeRepeticao = $("#minhaAgenda_formaRepeticao").val();	

	if (periodos.length == 0) {
		$(".disponibilidade-alert").removeClass('hide');
		$(".disponibilidade-alert-message").text("Por favor adicione um Horário antes de prosseguir")

		return;
	}

	if (dias.length == 0) {
		$(".disponibilidade-alert").removeClass('hide');
		$(".disponibilidade-alert-message").text("Por favor adicione um Dia de semana antes de prosseguir")

		return;
	}


	if (mes.length == 0 && formaDeRepeticao == 'Meses') {
		$(".disponibilidade-alert").removeClass('hide');
		$(".disponibilidade-alert-message").text("Por favor adicione um Mês de semana antes de prosseguir")

		return;
	}

	$.ajax({
		type: 'POST',
		url: '/add_disponibilidade',
		data : ({
			dias: dias,
			mes: mes,
			periodos: periodos,
			formaDeRepeticao: formaDeRepeticao,
			repeticaoInicio: repeticaoInicio,
			repeticaoFim : repeticaoFim,
			_token : token})
	}).done(function(result){		
		location.reload();
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor verifique se você já tem algo agendado nesse(s) horario(s)';

		mostrarAlert($class, $message);
		closeModal();
	});
}

var adicionarPeriodo = function(){
	var inicio = $("#minhaAgenda_horariosInicio").val();
	var fim = $("#minhaAgenda_horariosFim").val();

	var spanName = inicio + " - " + fim;
		
	var periodoLi = $("<li>")
			.addClass("list-group-item")
			.text(spanName);

	var periodoSpan = $("<span>")
			.addClass("glyphicon")
			.addClass("glyphicon-remove")
			.addClass("remove-location");

	var inicioValue = $("<input>")
			.addClass("hide")
			.addClass("inicioValue")
			.attr("value", inicio);

	var fimValue = $("<input>")
			.addClass("hide")
			.addClass("fimValue")
			.attr("value", fim);

	periodoSpan.click(removePeriodo);
	periodoSpan.appendTo(periodoLi);
	inicioValue.appendTo(periodoLi);
	fimValue.appendTo(periodoLi);

	$("#minhaAgenda_periodosSelecionados").append(periodoLi);
	$("#minhaAgenda_listaDePeriodos").removeClass('hide');
	fillHorarioSelectForDisponibilidade();
}

var removePeriodo = function(){
	//mudar essa função, ela tem que mudar o horario que pode ser selecionado
	var span = event.target;	
	var li = $(span).parent().remove();
	if ($("#minhaAgenda_periodosSelecionados").find('li').length <= 0) {
		$("#minhaAgenda_listaDePeriodos").addClass('hide');
	}

	fillHorarioSelectForDisponibilidade();
}

var fillHorarioSelectForDisponibilidade = function(){	
	$("#minhaAgenda_horariosInicio").empty();
	$("#minhaAgenda_horariosFim").empty();
	
	var horarios = [];

	for (var i = 700; i <= 2300; i+=100) {
		var horario = i.toString().slice(0,-2);

		var horario1 =  horario + ":00";
		var horario2 =  horario + ":30";
		
		horarios.push(horario1);
		horarios.push(horario2);
	}

	$("#minhaAgenda_horariosInicio").select2({
		data: horarios,
		width: '100%',
	});

	$("#minhaAgenda_horariosFim").select2({
		data: horarios,
		width: '100%',
	});

	$.each($("#minhaAgenda_periodosSelecionados").find('li'), function(){
		var selectedInicio = $(this).find(".inicioValue").val().replace(':','');
		var selectedFim = $(this).find(".fimValue").val().replace(':','');

		var horarioExistente = [];

		for (var i = parseInt(selectedInicio); i <= parseInt(selectedFim); i+=100) {
		var horario = i.toString().slice(0,-2);		

		var horario1 =  horario + ":00";
		var horario2 =  horario + ":30";
		
		horarioExistente.push(horario1);
		horarioExistente.push(horario2);
	}	

		var inicioOptions = $("#minhaAgenda_horariosInicio").find('option');
		var fimOptions = $("#minhaAgenda_horariosFim").find('option');

		$.each(inicioOptions, function(){
			if ($.inArray(this.text, horarioExistente) != -1) {
				this.remove();
			}
		});
		
	})
	
}

var loadHorariosFim = function(){	
	$("#minhaAgenda_horariosFim").empty();
	var horarios = [];

	for (var i = 700; i <= 2300; i+=100) {
		var horario = i.toString().slice(0,-2);

		var horario1 =  horario + ":00";
		var horario2 =  horario + ":30";
		
		horarios.push(horario1);
		horarios.push(horario2);
	}
	
	$("#minhaAgenda_horariosFim").select2({
		data: horarios,
		width: '100%',
	});

	$.each($("#minhaAgenda_periodosSelecionados").find('li'), function(){
		var selectedInicio = $(this).find(".inicioValue").val().replace(':','');
		var selectedFim = $(this).find(".fimValue").val().replace(':','');

		var horarioExistente = [];

		for (var i = parseInt(selectedInicio); i <= parseInt(selectedFim); i+=100) {
		var horario = i.toString().slice(0,-2);		

		var horario1 =  horario + ":00";
		var horario2 =  horario + ":30";
		
		horarioExistente.push(horario1);
		horarioExistente.push(horario2);
	}	
		
		var fimOptions = $("#minhaAgenda_horariosFim").find('option');

		$.each(fimOptions, function(){
			if ($.inArray(this.text, horarioExistente) != -1) {
				this.remove();
			}
		});
		
	})


	var inicio = parseInt($("#minhaAgenda_horariosInicio").val());
	var fimOptions = $("#minhaAgenda_horariosFim").find('option');

	$.each(fimOptions, function(){
		var thisValue = this.text;		
		if (parseInt(thisValue) <= inicio) {
			this.remove();
		}
	})
}

var mudarFormaRepeticao = function(){	
	if ($("#minhaAgenda_formaRepeticao").val() == 'Período') {
		$("#minhaAgenda_periodo").removeClass('hide');
		$("#minhaAgenda_meses").addClass('hide');
	}else{
		$("#minhaAgenda_periodo").addClass('hide');
		$("#minhaAgenda_meses").removeClass('hide');
	}
}

var openDisponibilidadeModal = function(event){
	var horario = event.start._i.substring(event.start._i.indexOf('T')+1).slice(0,-4);
	var dia = event.start._i.split("T")[0].slice(8) + '/' + event.start._i.split("T")[0].slice(5,-3) + '/' + event.start._i.split("-")[0];

	$("#disponibilidadeId").val(event.id);
	$("#disponivelText").text('Disponibilidade do dia: ' + dia + ' Horario: ' + horario);
	$("#disponivelModal").modal('toggle');

	$("#cancelarDisponibilidade").click(function(){
		$("#confirmeCancelamentoDisponibilidade").removeClass('hidden');		
	});
	
	$('#disponivelModal').on('hide.bs.modal', function(){
		$('#confirmeCancelamentoDisponibilidade').addClass('hidden');
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
		$("#observacoes").val(result.observacao);
		$("#agendadoId").val(result.id);
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente mais tarde.';

		mostrarAlert($class, $message);
		closeModal();
	});
}

var cancelaAula = function(){
	var agendadoId = $("#agendadoId").val();
	var token =  $('meta[name="csrf-token"]').attr('content');
	
	$.ajax({
		type: 'POST',
		url: '/cancela_aula',
		data : ({
			agendadoId: agendadoId,
			_token : token})
	}).done(function(result){
		location.reload();
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente mais tarde';

		mostrarAlert($class, $message);
		closeModal();
	});
}

var cancelaDisponibilidade = function(){
	var disponibilidadeId = $("#disponibilidadeId").val();
	var token =  $('meta[name="csrf-token"]').attr('content');

	$.ajax({
		type: 'POST',
		url: '/cancela_disponibilidade',
		data : ({
			disponibilidadeId: disponibilidadeId,
			_token : token})
	}).done(function(result){
		$('#calendar').fullCalendar('removeEvents', disponibilidadeId);
		var $class = 'alert-success';
		var $message = 'A sua disponibilidade foi deletada.';

		mostrarAlert($class, $message);
		closeModal();
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente mais tarde';

		mostrarAlert($class, $message);
		closeModal();
	});
}

var openDadaModal = function(event){	
	$(".modal-title").text('');
	$("#observacoes").val('');
	$("#agendadoId").val('');

	var dada = $('<strong>')
					.text('Aula passada')
					.attr('style', 'color: #ad3a60');

	var token =  $('meta[name="csrf-token"]').attr('content');
	var agendadoId = event.id;

	$("#agendadoModal").modal('toggle');

	$("#cancelarAgendado").addClass('hide');

	$('#agendadoModal').on('hide.bs.modal', function(){
		$("#cancelarAgendado").removeClass('hide');
	});

	$.ajax({
		type: 'GET',
		url: '/get/agendadoPorId',
		data : ({
			agendadoId: agendadoId,
			_token : token})
	}).done(function(result){
		$('.modal-title').text(' com: ' + result.aluno.user.nome + ' ' + result.aluno.user.sobrenome);
		dada.prependTo($('.modal-title'));
		$("#observacoes").val(result.observacao);
		$("#agendadoId").val(result.id);
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente mais tarde.';

		mostrarAlert($class, $message);
		closeModal();
	});
}

var fillCalendarIndex = function(){
	var calendarIndex = $('<div>');

	var divAgendado = $('<div>')
						.addClass('row calendar-line');

	var divAgendadoColor = $('<div>')
							.addClass('calendar-index-color')
							.attr('style', "background-color: #3a87ad");

	var divAgendadoText = $('<div>')
						.addClass('col-xs-12');

	var agendadoText = $('<p>')
						.text('Aula Agendada');

	divAgendadoColor.appendTo(divAgendado);
	agendadoText.appendTo(divAgendadoText);
	divAgendadoText.appendTo(divAgendado);

	divAgendado.appendTo(calendarIndex);

	var divCancelado = $('<div>')
						.addClass('row calendar-line')
						.attr('style', "position: relative; top: -12px");

	var divCanceladoColor = $('<div>')
							.addClass('calendar-index-color')
							.attr('style', "background-color: #ad3a60");

	var divCanceladoText = $('<div>')
						.addClass('col-xs-12');

	var canceladoText = $('<p>')
						.text('Aula Cancelada');

	divCanceladoColor.appendTo(divCancelado);
	canceladoText.appendTo(divCanceladoText);
	divCanceladoText.appendTo(divCancelado);

	divCancelado.appendTo(calendarIndex);

	var divDada = $('<div>')
						.addClass('row calendar-line')
						.attr('style', "position: relative; top: -24px");

	var divDadaColor = $('<div>')
							.addClass('calendar-index-color')
							.attr('style', "background-color: #3aad77");

	var divDadaText = $('<div>')
						.addClass('col-xs-12');

	var dadaText = $('<p>')
						.text('Aula Passada');

	divDadaColor.appendTo(divDada);
	dadaText.appendTo(divDadaText);
	divDadaText.appendTo(divDada);

	divDada.appendTo(calendarIndex);


	$(".fc-right").append(calendarIndex);
}