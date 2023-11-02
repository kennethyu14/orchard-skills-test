<?php

add_action( 'after_setup_theme', 'custom_scripts', 10 );

function custom_scripts() {

	add_action( 'init', 'theme_menus', 10 );
  add_action( 'wp_enqueue_scripts', 'theme_scripts', 10 );

}

function theme_scripts() {

	$parenthandle = 'parent-style';
	$theme = wp_get_theme();

	wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get( 'Version' ) );

	wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/assets/js/theme.js', ['jquery'] );

}

function theme_menus() {

	$locations = array(
		'main'  => __( 'Main Menu', 'twentytwenty' )
	);

	register_nav_menus( $locations );
}

?>