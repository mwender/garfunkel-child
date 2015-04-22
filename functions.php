<?php
/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 *
 * @return void
 */
function garfunkel_child_enqueue_scripts(){
	remove_action( 'wp_print_styles', 'garfunkel_load_style' ); // parent theme improperly hooks to `wp_print_styles`

	wp_register_style('garfunkel_googleFonts',  '//fonts.googleapis.com/css?family=Fira+Sans:400,500,700,400italic,700italic|Playfair+Display:400,900|Crimson+Text:700,400italic,700italic,400' );
	wp_register_style('garfunkel_genericons', get_template_directory_uri() . '/genericons/genericons.css' );
	wp_register_style('garfunkel_style', get_stylesheet_uri(), null, filemtime( get_stylesheet_directory() . '/style.css' ) );

    wp_enqueue_style( 'garfunkel_googleFonts' );
    wp_enqueue_style( 'garfunkel_genericons' );
    wp_enqueue_style( 'garfunkel_style' );
}
add_action( 'wp_enqueue_scripts', 'garfunkel_child_enqueue_scripts' );
?>