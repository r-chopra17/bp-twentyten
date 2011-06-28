<?php
// Load the AJAX functions for the theme
require_once( get_stylesheet_directory() . '/_inc/ajax.php' );

// Load the javascript for the theme
wp_enqueue_script( 'dtheme-ajax-js', get_stylesheet_directory_uri() . '/_inc/global.js', array( 'jquery' ) );

/**
 * Filter the dropdown for selecting the page to show on front to include "Activity Stream"
 *
 * @param string $page_html A list of pages as a dropdown (select list)
 * @see wp_dropdown_pages()
 * @return string
 * @package BuddyPress Theme
 * @since 1.2
 */

function tt_theme_wp_pages_filter( $page_html ) {
	if ( !bp_is_active( 'activity' ) )
		return $page_html;

	if ( 'page_on_front' != substr( $page_html, 14, 13 ) )
		return $page_html;

	$selected = false;
	$page_html = str_replace( '</select>', '', $page_html );

	if ( p2_theme_page_on_front() == 'activity' )
		$selected = ' selected="selected"';

	$page_html .= '<option class="level-0" value="activity"' . $selected . '>' . __( 'Activity Stream', 'buddypress' ) . '</option></select>';
	return $page_html;
}
add_filter( 'wp_dropdown_pages', 'tt_theme_wp_pages_filter' );

/**
 * Return the ID of a page set as the home page.
 *
 * @return false|int ID of page set as the home page
 * @package BuddyPress Theme
 * @since 1.2
 */
function tt_theme_page_on_front() {
	if ( 'page' != get_option( 'show_on_front' ) )
		return false;

	return apply_filters( 'tt_theme_page_on_front', get_option( 'page_on_front' ) );
}
?>