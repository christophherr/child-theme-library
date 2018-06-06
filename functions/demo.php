<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary\Functions
 * @link      https://github.com/seothemes/child-theme-library
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-2.0+
 */

add_filter( 'pt-ocdi/import_files', 'child_theme_demo_import_settings' );
/**
 * One click demo import settings.
 *
 * @since  1.0.0
 *
 * @return array
 */
function child_theme_demo_import_settings() {

	$config = child_theme_get_config( 'demo-import' );

	return array( $config );

}

add_filter( 'pt-ocdi/after_all_import_execution', 'child_theme_after_demo_import', 99 );
/**
 * Set default pages after demo import.
 *
 * Automatically creates and sets the Static Front Page and the Page for Posts
 * upon theme activation, only if these pages don't already exist and only
 * if the site does not already display a static page on the homepage.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_after_demo_import() {

	// Assign menus to their locations.
	$menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );
	$home = get_page_by_title( 'Home' );
	$blog = get_page_by_title( 'Blog' );
	$shop = get_page_by_title( 'Shop' );

	if ( $menu ) {

		set_theme_mod( 'nav_menu_locations', array(
			'primary' => $menu->term_id,
		) );

	}

	if ( $home && $blog ) {

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front',  $home->ID );
		update_option( 'page_for_posts', $blog->ID );

	}

	if ( $shop ) {

		update_option( 'woocommerce_shop_page_id', $shop->ID );

	}

	// Trash "Hello World" post.
	wp_delete_post( 1 );

	// Update permalink structure.
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	$wp_rewrite->flush_rules();

}