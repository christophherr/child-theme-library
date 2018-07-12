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
 * Adds demo import logic to child theme.
 *
 * @since 1.4.0
 */
class DemoImport {

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

		$this->disable_branding();

		add_filter(
			'pt-ocdi/import_files', [
				$this,
				'import_settings',
			]
		);
		add_filter(
			'pt-ocdi/after_all_import_execution', [
			$this,
			'after_import',
		], 99
		);
	}


	/**
	 * Remove One Click Demo Import branding.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function disable_branding() {

		add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

	}

	/**
	 * One click demo import settings.
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function import_settings() {

		$config = $this->theme->config['demo-import'];

		return [ $config ];

	}

	/**
	 * Set up site after demo import.
	 *
	 * Automatically creates and sets the Static Front Page and the Page for
	 * Posts upon theme activation, only if these pages don't already exist and
	 * only if the site does not already display a static page on the homepage.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function after_import() {

		// Assign menus to their locations.
		$menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );
		$home = get_page_by_title( 'Home' );
		$blog = get_page_by_title( 'Blog' );
		$shop = get_page_by_title( 'Shop' );

		if ( $menu ) {

			set_theme_mod(
				'nav_menu_locations', [
					'primary' => $menu->term_id,
				]
			);

		}

		if ( $home && $blog ) {

			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home->ID );
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

}
