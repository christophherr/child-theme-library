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

/**
 * Adds setup logic to child theme.
 *
 * @since 1.4.0
 */
class Setup {

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

		$this->config = $theme->config;

	}

	/**
	 * Initialize class.
	 *
	 * @since  1.5.0
	 *
	 * @return void
	 */
	public function init() {

		$this->add_text_domain( $this->config['textdomain'] );
		$this->add_theme_supports( $this->config['theme-supports'] );
		$this->add_image_sizes( $this->config['image-sizes'] );
		$this->add_post_type_supports( $this->config['post-type-supports'] );
		$this->add_default_headers( $this->config['default-headers'] );

	}

	/**
	 * Add theme text domain.
	 *
	 * @since  1.3.0
	 *
	 * @param  array $config Text domain config.
	 *
	 * @return void
	 */
	public function add_text_domain( $config ) {

		load_child_theme_textdomain( $config['domain'], $config['path'] );

	}

	/**
	 * Add theme supports.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $config Text domain config.
	 *
	 * @return void
	 */
	public function add_theme_supports( $config ) {

		foreach ( $config as $feature => $args ) {

			if ( is_array( $args ) ) {

				add_theme_support( $feature, $args );

			} else {

				add_theme_support( $args );

			}
		}

	}

	/**
	 * Add new image sizes.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $config Text domain config.
	 *
	 * @return void
	 */
	public function add_image_sizes( $config ) {

		foreach ( $config as $name => $args ) {

			$crop = array_key_exists( 'crop', $args ) ? $args['crop'] : false;

			add_image_size( $name, $args['width'], $args['height'], $crop );

		}

	}

	/**
	 * Add post type supports.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $config Text domain config.
	 *
	 * @return void
	 */
	public function add_post_type_supports( $config ) {

		foreach ( $config as $post_type => $support ) {

			add_post_type_support( $post_type, $support );

		}

	}

	/**
	 * Add default header image.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $config Text domain config.
	 *
	 * @return void
	 */
	public function add_default_headers( $config ) {

		register_default_headers( $config );

	}

}
