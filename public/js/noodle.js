$(function() {

	// Form elements

	// Picture element
	$('.form_picture .remove').click(function(){
		var currentInput = $(this).parent().find('input');
		$(this).parent().find('img').remove();
		$(this).parent().find('a').remove();
		$("<input type='file' />").attr({ name: currentInput.attr('name') }).insertBefore(currentInput);
		currentInput.remove();
		return false;
	});

});