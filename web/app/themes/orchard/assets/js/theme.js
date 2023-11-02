jQuery( document ).ready( ( $ ) => {

    $( '.root-a > a, .root-a li > a' ).on( 'click', ( e ) => {
        e.preventDefault();
        $( '.banner' ).removeClass( 'mountains-bg' );
        $( '.banner' ).addClass( 'grass-bg' );
    });
    
    $( '.root-b > a, .root-b li > a' ).on( 'click', ( e ) => {
        e.preventDefault();
        $( '.banner' ).removeClass( 'grass-bg' );
        $( '.banner' ).addClass( 'mountains-bg' );
    });

});