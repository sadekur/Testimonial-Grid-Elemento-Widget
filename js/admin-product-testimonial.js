( function ( $ ) {
	$('#pt_form').submit( function(e) {
		//alert("sss")
		e.preventDefault();
		var data = $(this).serialize();

		$.ajax({
			url: ARRG.ajaxurl,
			data: data,
			type: 'POST',
			dataType: 'json',
			success: function(resp) {
				$('.successMessage').show();
			},
			error: function(error) {
				console.log(error)
			}
		})
	} );
} )( jQuery );