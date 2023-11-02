( function( $ ) {
    'use strict';

	$( document ).ready( function() {
        $( '.toggle-featured' ).on( 'click', function( e ) {
            e.preventDefault();
        
            var post_id = $( this ).attr( 'data-post-id' );
            var is_featured = !! $( this ).attr( 'data-featured' );
            
            var nonce = custom_products_params.nonce;
            
            var featuredCount = $( '.toggle-featured[data-featured="1"]' ).length;
            console.log( 'is featured: ' + is_featured );
            console.log( 'featured content: ' + featuredCount );
    
            if ( ! is_featured && featuredCount >= 5 ) {
                alert( 'You can feature up to 5 products.' );
                return;
            }
    
            $.ajax( {
                type: 'POST',
                url: custom_products_params.ajax_url,
                data: {
                    action: 'toggle_featured',
                    post_id: post_id,
                    is_featured: is_featured,
                    nonce: nonce,
                },
                success: function( response ) {
                    console.log( response );
                    if ( response.success ) {
                        if ( response.data.is_featured ) {
                            $( '.toggle-featured[data-post-id="' + post_id + '"]' ).attr( 'data-featured', 1 );
                            $( '.toggle-featured[data-post-id="' + post_id + '"] span' ).removeClass( 'dashicons-star-empty' ).addClass( 'dashicons-star-filled' );
                        } else {
                            $( '.toggle-featured[data-post-id="' + post_id + '"]' ).attr( 'data-featured', '' );
                            $( '.toggle-featured[data-post-id="' + post_id + '"] span' ).removeClass( 'dashicons-star-filled' ).addClass( 'dashicons-star-empty' );
                        }
                    }
                },
            });
        });
    });

})( jQuery );
