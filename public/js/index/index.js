$( document ).ready(function() {
	$("#login-btn").click(login);
	$("#cadastrar-btn-modal").click(openSingUpModal);
	$("#cadastrar-btn").click(cadastrar);
	$("#closeAlert").click(closeAlert);
	$("#signUpConfirmPassword").keyup(checkSignUpRequest);
	$("#signUpPassword").change(checkSignUpRequest);
	$("#signUpEmail").change(checkSignUpRequest);
	$("#sobre-nos").click(sobreNos);
	$("#fotos").click(fotos);
	$("#contato").click(contato);
	$("#email-submit").click(submitEmail);
	$("#esqueci-senha").click(modalSenha);
	$("#sendPassword").click(sendPassword);

	var map = new GMaps({
  		div: '#map',
  		lat: -19.9354483,
  		lng: -43.9289142
	});
	map.addMarker({
		lat: -19.9354483,
  		lng: -43.9289142,
  		title: 'Escola Tempo',
	})

});

var closeAlert = function(event){	
	event.stopPropagation();

	$("#logindAlert").addClass('hide');
}

var openSingUpModal = function(event){
	event.preventDefault();
	
	$("#signUpModal").modal('show');
}

var login = function(event){
	event.preventDefault();

	email = $("#email").val();
	password = $("#password").val();

	token =  $('meta[name="csrf-token"]').attr('content');

	$.ajax({
		type: 'POST',
		url: '/login',
		data: ({
			email: email,
			password: password,
			_token: token
			})
	}).done(function(result){		
		if (result == "true") {
			window.location.replace("/minha_conta");
		}else if (result == "false"){
			$("#logindAlert").removeClass('hide');
		}
	});
}

var cadastrar = function(){
	if ($("#cadastrar-btn").hasClass('disabled')) {
		//Cancela a função se o btn estiver desabilitado
		return null;
	}	
	email = $("#signUpEmail").val();
	password = $("#signUpPassword").val();
	userType = $("#typeOfUser").val();

	token =  $('meta[name="csrf-token"]').attr('content');	

	$.ajax({
		type: 'POST',
		url: '/salvar_usuario',
		data : ({
			email : email,
			password: password,
			user_type: userType,
			_token : token})
	}).done(function(result){
		if (result == "true") {
			window.location.replace("/minha_conta");
		}else if (result == "false"){
			$("#logindAlert").removeClass('hide');
		}
	});
}

var checkPasswordConfimation = function(){
	if ($("#signUpConfirmPassword").val() == $("#signUpPassword").val() && $("#signUpPassword").val() != '') {
		$("#passwordAlert").addClass('hide');		
		return true;
	}else{
		$("#passwordAlert").removeClass('hide');	
		return false;
	}
}

var checkSignUpEmail = function(){
	var email = $("#signUpEmail").val();
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	return regex.test(email);
}

var checkSignUpRequest = function(){	
	if (checkPasswordConfimation() && checkSignUpEmail()) {
		$("#cadastrar-btn").removeClass('disabled');
	}else{
		$("#cadastrar-btn").addClass('disabled');
	}
}

var sobreNos = function(){
	$('html, body').animate({
        scrollTop: $(".quem-somos").offset().top
    }, 1000);
}

var fotos = function(){
	$('html, body').animate({
        scrollTop: $(".custom-slider").offset().top
    }, 1000);
}

var contato = function(){
	$('html, body').animate({
        scrollTop: $(".custom-footer").offset().top
    }, 1000);
}

var submitEmail = function(){
	if ($("#email-nome").val() == '') {
		$("#alert-contato-text").text("Por favor preencha o campo 'Nome'.");
		$("#alert-contato-div").removeClass('hide');
		return;
	}

	if ($("#email-email").val() == '') {
		$("#alert-contato-text").text("Por favor preencha o campo 'Email'.");
		$("#alert-contato-div").removeClass('hide');
		return;
	}

	if ($("#email-mensagem").val() == '') {
		$("#alert-contato-text").text("Por favor preencha o campo 'Mensagem'.");
		$("#alert-contato-div").removeClass('hide');
		return;
	}

	var token =  $('meta[name="csrf-token"]').attr('content');	

	$.ajax({
		type: 'POST',
		url: '/send_email',
		data: ({
			_token: token,
			mensagem: $("#email-mensagem").val(),
			email: $("#email-email").val(),
			nome: $("#email-nome").val(),
		})
	}).done(function(result){
		if (result == 'true') {
			$("#email-nome").val('');
			$("#email-email").val('');
			$("#email-mensagem").val('');

			$("#alert-contato-text").text("Sua mensagem foi enviada com sucesso.");
			$("#alert-contato-div").removeClass('hide');
		}
	}).fail(function(){
		var $class = 'alert-danger';
		var $message = 'Algo deu errado, por favor tente de novo mais tarde';

		mostrarAlert($class, $message);
	})
}

var modalSenha = function(event){
	event.preventDefault()
	$('#senhaModal').modal('toggle');
}

var sendPassword = function(){
	var email = $('#emailEsqueciSenha').val();
	var token =  $('meta[name="csrf-token"]').attr('content');	

	$.ajax({
		type: 'POST',
		url: '/send_password',
		data: ({
			_token: token,
			email: email
		})
	}).done(function(result){
		console.log(result);
	}).fail(function(result){
		console.log(result);
	})
}