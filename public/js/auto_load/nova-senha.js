$( document ).ready(function() {
    $('#submit-btn-nova-senha').click(function(event){    	

    	if ($('#nova-senha').val() != $('#confirmacao-senha').val()) {
    		event.preventDefault();
    		console.log('ta diferente');

    		var mensagem = "Por favor confirme a senha";
    		var alert = 'alert-danger';

			mostrarAlert(alert, mensagem);
    		return;
    	}

    	console.log('ta igual');
    })
});