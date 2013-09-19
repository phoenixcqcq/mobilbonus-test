$(document).ready(function() {

	$("a[rel=fancy]").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over'
	});

	$(".send").click(function() {
		var id = $(this).attr('id').substring(5);
		$("#popUp").html(
			"<h3>Poslat obrázek</h3>" +
				"<form action='prace-s-obrazkem/poslat/"+id+"' method='post'>" +
				"Email: <input type='text' name='email' id='email' />" +
				"<input type='submit' value='Poslat'>" +
			"</form>"
		)
		$("#sendPopUp").show();
		$("#popUp").show();
	});

});