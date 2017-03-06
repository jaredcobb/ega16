<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ega16
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ega16_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	} else {
		global $post;
		$classes[] = $post->post_name;
	}

	if ( ega16_crt_enabled() ) {
		$classes[] = 'crt-on';
	}

	return $classes;
}
add_filter( 'body_class', 'ega16_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ega16_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ega16_pingback_header' );

// Disable hardcoded inline styles from the recent comments widget.
add_filter( 'show_recent_comments_widget_style', '__return_false' );
