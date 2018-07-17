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
 * Main child theme library class.
 *
 * @since   1.4.0
 */
class Theme {

	/**
	 * Theme object.
	 *
	 * @since 1.4.0
	 *
	 * @var   object
	 */
	public $theme;

	/**
	 * Theme name.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $name;

	/**
	 * Theme url.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $url;

	/**
	 * Theme version.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $version;

	/**
	 * Theme handle.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $handle;

	/**
	 * Theme author.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $author;

	/**
	 * Theme dir.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $dir;

	/**
	 * Theme uri.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $uri;

	/**
	 * Theme config.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $config;

	/**
	 * Constructor.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function __construct() {

		$this->theme   = wp_get_theme();
		$this->name    = $this->theme->get( 'Name' );
		$this->url     = $this->theme->get( 'ThemeURI' );
		$this->version = $this->theme->get( 'Version' );
		$this->handle  = $this->theme->get( 'TextDomain' );
		$this->author  = $this->theme->get( 'Author' );
		$this->dir     = get_stylesheet_directory();
		$this->uri     = get_stylesheet_directory_uri();

	}

	/**
	 * Initialize child theme library.
	 *
	 * @since  1.4.0
	 *
	 * @param  string $config Path to config file.
	 *
	 * @return void
	 */
	public function init( $config ) {

		$config = apply_filters( 'child_theme_config', $config );

		if ( ! file_exists( $config ) ) {

			$config = dirname( __DIR__ ) . '/docs/example-config.php';

		}

		$this->config = require_once $config;

		$this->modules( $this->config['modules'] );
		$this->autoload( $this->config['autoload'] );

	}

	/**
	 * Load child theme modules after the Genesis Framework.
	 *
	 * @since  1.4.0
	 *
	 * @param  array $modules List of modules to load.
	 *
	 * @return void
	 */
	public function modules( $modules ) {

		require_once get_template_directory() . '/lib/init.php';

		foreach ( $modules as $module ) {

			$property  = strtolower( $module );
			$namespace = __NAMESPACE__ . '\\';
			$classname = $namespace . $module;
			$filename  = trailingslashit( __DIR__ ) . $module . '.php';

			if ( file_exists( $filename ) ) {

				$this->$property = new $classname( $this );

			}
		}

	}

	/**
	 * Loads Genesis and additional files listed in theme config.
	 *
	 * @since  1.4.0
	 *
	 * @param  array $files List of files to autoload.
	 *
	 * @return void
	 */
	public function autoload( $files ) {

		foreach ( $files as $file ) {

			$file_name = $this->dir . '/' . $file . '.php';

			if ( file_exists( $file_name ) ) {

				require_once $file_name;

			}
		}

	}

}
