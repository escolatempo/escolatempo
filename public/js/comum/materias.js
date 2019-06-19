var carregaMateriasStaticas = function(){
	$.ajax({
		type: 'GET',
		url: "/get/static_materias"
	}).done(function(staticMaterias){
		staticMaterias = JSON.stringify(staticMaterias).replace(/\"nome"/g, "\"text\"");		
		$(".materiasSelect").select2({
			data: JSON.parse(staticMaterias),
		});
			
		carregaMateriasSalvas();
	});	
}

var carregaMateriasSalvas = function(){
	var materiaIds = [];
	$.each($(".materias-id"), function(){
		materiaIds.push($(this).val());
	});
	
	$("#minhaConta_materias").val(materiaIds);
	$("#minhaConta_materias").trigger('change');
}