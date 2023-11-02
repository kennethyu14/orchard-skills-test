( function( $ ) {
	'use strict';

	$( document ).ready( function() {
		$( '.product-cta' ).on( 'click', function( e ) {
			// e.preventDefault();
	
			var nonce = custom_products_params.nonce;
			
			$.ajax( {
				type: 'POST',
				url: custom_products_params.ajax_url,
				data: {
					action: 'record_cta_click',
					cta_id: $( this ).data( 'cta-id' ),
					nonce: nonce
				},
				success: function( response ) {
					console.log( response );
				}
			});
		});
	} );

})( jQuery );
