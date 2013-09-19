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

	setMessageDialog();

});

/**
 * Set the message dialog if message exists
 */
function setMessageDialog(){
	if($('#message').length){
		showMessage($('#message').text());
	}
}

/**
 * Display the message
 *
 * @param message
 */
function showMessage(message, header){
	if(typeof header !== 'undefined'){
		bootbox.dialog(message, [
			{
				"label":"OK",
				"class":"btn-primary"
			}
		], {"header":header});
	}
	else{
		bootbox.dialog(message, [
			{
				"label":"OK",
				"class":"btn-primary"
			}
		]);
	}
}
