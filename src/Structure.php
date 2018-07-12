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

/**
 * Adds structure logic to child theme.
 *
 * @since 1.4.0
 */
class Structure {

	/**
	 * Child theme object.
	 *
	 * @since 1.4.0
	 *
	 * @var   object
	 */
	public $theme;

	/**
	 * Constructor.
	 *
	 * @since  1.4.0
	 *
	 * @param  object $theme Child theme object.
	 *
	 * @return void
	 */
	public function __construct( $theme ) {

		$this->theme = $theme;

		add_action( 'after_setup_theme', [
			$this,
			'display_custom_logo'
		] );
		add_action( 'after_setup_theme', [
			$this,
			'reposition_menus'
		] );
		add_action( 'after_setup_theme', [
			$this,
			'reposition_footer_widgets'
		] );

	}

	/**
	 * Display custom logo in site title area.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function display_custom_logo() {

		add_action( 'genesis_site_title', 'the_custom_logo', 0 );

	}

	/**
	 * Reposition navigation menus.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function reposition_menus() {

		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );
		add_action( 'child_theme_after_title_area', 'genesis_do_nav' );
		add_action( 'child_theme_after_header_wrap', 'genesis_do_subnav' );

	}

	/**
	 * Reposition footer widgets inside site footer.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function reposition_footer_widgets() {

		remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
		add_action( 'child_theme_before_footer_wrap', 'genesis_footer_widget_areas', 15 );

	}

}