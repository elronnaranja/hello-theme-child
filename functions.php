<?php
/**
 * Hello Elementor Child (CWD starter) — functions.
 *
 * One style.css for all custom styling, one js/script.js for all jQuery.
 * Colors and fonts come from Elementor Site Settings (Global Colors / Global Fonts);
 * style.css uses their CSS variables, never hard-coded values.
 *
 * @package HelloElementorChild
 */

/**
 * File version = last time the file changed, so browsers and the host cache
 * pick up edits right away but keep the file cached between edits.
 */
function hello_elementor_child_ver( $file ) {
	$path = get_stylesheet_directory() . '/' . $file;
	return file_exists( $path ) ? (string) filemtime( $path ) : wp_get_theme()->get( 'Version' );
}

/**
 * Styles and scripts.
 *
 * Slick is the CWD slider: always loaded, its base CSS lives at the end of style.css.
 * Linkify is optional: uncomment the two lines below when a site needs it.
 */
function hello_elementor_child_enqueue_scripts() {
	$uri = get_stylesheet_directory_uri();

	// SCRIPTS
	wp_enqueue_script( 'cwd-slick', $uri . '/js/slick.min.js', array( 'jquery' ), hello_elementor_child_ver( 'js/slick.min.js' ), true );
	// wp_enqueue_script( 'cwd-linkify', $uri . '/js/linkify.min.js', array(), hello_elementor_child_ver( 'js/linkify.min.js' ), true );
	// wp_enqueue_script( 'cwd-linkify-jquery', $uri . '/js/jquery.linkify.min.js', array( 'jquery', 'cwd-linkify' ), hello_elementor_child_ver( 'js/jquery.linkify.min.js' ), true );
	wp_enqueue_script( 'cwd-script', $uri . '/js/script.js', array( 'jquery', 'cwd-slick' ), hello_elementor_child_ver( 'js/script.js' ), true );

	// STYLE (after Elementor's own CSS, so equal selectors win here)
	wp_enqueue_style( 'hello-elementor-child-style', get_stylesheet_uri(), array(), hello_elementor_child_ver( 'style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );
