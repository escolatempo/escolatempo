$( document ).ready(function() {
	escondeAlertas();
	ifProfessorShowMaterias();
	$("#btnMudarSenha").click(abrirMudarSenha);
	$("#minhaConta_confirmacaoSenha").keyup(validarNovaSenha);
	$("#minhaConta_novaSenha").change(validarNovaSenha);
	$("#minhaConta_senhaAntiga").keyup(validarNovaSenha);
	carregaMateriasStaticas();
	$("#minhaConta_submitBtn").click(salvar);
});

var ifProfessorShowMaterias = function(){	
	if ($("#minhaConta_UserType").val() == "professor") {
		$("#minhaConta_materiasDiv").removeClass('hidden');
	}
}

var abrirMudarSenha = function(){
	$("#btnMudarSenha").addClass("hide");
	$("#mudarSenha").removeClass("hide");
}

var validarNovaSenha = function(){
	var senha = $("#minhaConta_novaSenha").val();
	var senhaConfirmacao = $("#minhaConta_confirmacaoSenha").val();
	var senhaAntiga = $("#minhaConta_senhaAntiga").val();

	if (senha != senhaConfirmacao) {	
		$("#alertaConfirmacao").fadeIn(400);		
		$("#messagemDeAlerta").text("Confirme a Senha");
		//desabilita o botão de submit
		$("#minhaConta_submitBtn").prop('disabled',true);

	}else if (senhaAntiga == '' && senha != '') {
		$("#alertaConfirmacao").fadeIn(400);
		$("#messagemDeAlerta").text("Confirme a senha antiga");
		//desabilita o botão de submit
		$("#minhaConta_submitBtn").prop('disabled',true);

	}else {
		$("#alertaConfirmacao").fadeOut(400);
		$("#minhaConta_submitBtn").prop('disabled',false);
	}
}

var escondeAlertas = function(){
	$("#alertaConfirmacao").fadeOut(1);
}

var salvar = function(){	
	var nome = $("#minhaConta_nome").val();
	var email = $("#minhaConta_email").val();
	var sobrenome = $("#minhaConta_sobreNome").val();
	var token =  $('meta[name="csrf-token"]').attr('content');

	//save if was materias selected
	//PRECISO TESTAR SE É ALUNO
	if ($("#minhaConta_UserType").val() == "professor") {
		$.ajax({
			type: 'POST',
			url: '/save_professor_materias',
			data: ({ data : $("#minhaConta_materias").val(), _token: token }),
		}).fail(function(result){
			var $class = 'alert-danger';
			var $message = 'Algo deu errado, por favor tente de novo mais tarde';

			mostrarAlert($class, $message);
		});
	}
	
	var data = {'nome': nome, 'email': email, 'sobrenome' : sobrenome};
	
	if ($("#minhaConta_novaSenha").val() != '') {		
		data['novaSenha'] = $("#minhaConta_novaSenha").val();
		data['venhaSenha'] = $("#minhaConta_senhaAntiga").val();
	}

	$.ajax({
		type: 'POST',
		url: '/save_profile',
		data: ({ data : data, _token: token }),
	}).done(function(result){
		if (result == "wrongPassword"){
			var $class = 'alert-danger';
			var $message = 'Por favor confirme a senha antiga';
			
			mostrarAlert($class, $message);
		}else if (result == "true") {
			var $class = 'alert-success';
			var $message = 'Conta atualizada com sucesso';

			mostrarAlert($class, $message);
		}
	}).fail(function(result){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente de novo mais tarde';

		mostrarAlert($class, $message);		
	});
}