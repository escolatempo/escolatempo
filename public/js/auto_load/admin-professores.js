$(function(){
	$('input[name="professor_status"]').each(function(){
		if ($(this).val() == 0) {}
		$(this).prev().bootstrapToggle('off');
	})

	$('.switch').click(function(){
		console.log($(this).parent().find('.id').text())
	})
})