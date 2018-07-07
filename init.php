<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary
 * @link      https://github.com/seothemes/child-theme-library
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-2.0-or-later
 */

namespace SEOThemes\ChildThemeLibrary;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {

	die;

}

add_action( 'child_theme_init', __NAMESPACE__ . '\constants', 1 );
/**
 * Initialize the Child Theme Library.
 *
 * @since  1.3.0
 *
 * @return void
 */
function constants() {

	$child_theme = wp_get_theme();

	$constants = apply_filters(
		'child_theme_constants', [
			'CHILD_THEME_NAME'    => $child_theme->get( 'Name' ),
			'CHILD_THEME_URL'     => $child_theme->get( 'ThemeURI' ),
			'CHILD_THEME_VERSION' => $child_theme->get( 'Version' ),
			'CHILD_THEME_HANDLE'  => $child_theme->get( 'TextDomain' ),
			'CHILD_THEME_AUTHOR'  => $child_theme->get( 'Author' ),
			'CHILD_THEME_DIR'     => get_stylesheet_directory(),
			'CHILD_THEME_LIB'     => get_stylesheet_directory() . '/lib',
			'CHILD_THEME_VIEWS'   => get_stylesheet_directory() . '/lib/views',
			'CHILD_THEME_VENDOR'  => get_stylesheet_directory() . '/vendor',
			'CHILD_THEME_CONFIG'  => get_stylesheet_directory() . '/config/config.php',
			'CHILD_THEME_URI'     => get_stylesheet_directory_uri(),
			'CHILD_THEME_ASSETS'  => get_stylesheet_directory_uri() . '/assets',
		]
	);

	foreach ( $constants as $name => $value ) {

		if ( ! defined( $name ) ) {

			define( $name, $value ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound -- Dynamically defined constants.

		}
	}

}

add_action( 'child_theme_init', __NAMESPACE__ . '\load', 2 );
/**
 * Load Genesis Framework and child theme autoloader.
 *
 * @since  1.3.0
 *
 * @return void
 */
function load() {

	require_once get_template_directory() . '/lib/init.php';
	require_once CHILD_THEME_LIB . '/autoload.php';

}

// Fires during initialization.
do_action( 'child_theme_init' );

// Fires after initialization.
do_action( 'child_theme_setup' );
