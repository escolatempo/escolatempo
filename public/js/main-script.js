$(document).ready(function(){
	$(".close-alert").click(hideAlert);
	$(".custom-navbar-icon").hover(putHover, takeHover);

	$(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

var mostrarAlert = function($class, $message){
	$("#alert-id").removeClass();
	$("#alert-id").addClass('alert');
	$("#alert-id").addClass($class);
	$("#alert-id").find('strong').text($message);
	$("#alert-id").removeClass('hidden');
	window.scrollTo(0,0);	
}

var hideAlert = function(){	
	$(".alert").addClass('hide');
}

var closeModal = function(){
	$('.modal').modal('hide');
}

var putHover = function(){	
	$(this).addClass('putHover');
}

var takeHover = function(){	
	$(this).removeClass('putHover');
}