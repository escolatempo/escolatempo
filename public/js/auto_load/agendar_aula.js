$(document).ready(function(){
	carregaMateriasStaticas();	
	$("#agendaPorMateria").click(disponibilidadePorMateria);
})

document.write('<script src="../js/comum/materias.js"></script>');

var disponibilidadePorMateria = function(){
	var materia = $(".materiasSelect").val();	

	window.location.replace("/agendar_materia/" + materia);
}