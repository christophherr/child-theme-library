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
 * Main child theme library class.
 *
 * @since   1.4.0
 */
class ChildTheme {

	/**
	 * Theme name.
	 *
	 * @since 1.4.0
	 *
	 * @var   false|string
	 */
	public $name;

	/**
	 * Theme url.
	 *
	 * @since 1.4.0
	 *
	 * @var   false|string
	 */
	public $url;

	/**
	 * Theme version.
	 *
	 * @since 1.4.0
	 *
	 * @var   false|string
	 */
	public $version;

	/**
	 * Theme handle.
	 *
	 * @since 1.4.0
	 *
	 * @var   false|string
	 */
	public $handle;

	/**
	 * Theme author.
	 *
	 * @since 1.4.0
	 *
	 * @var   false|string
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
	 * Theme vendor.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $vendor;

	/**
	 * Theme lib.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $lib;

	/**
	 * Theme views.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $views;

	/**
	 * Theme uri.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $uri;

	/**
	 * Theme assets.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $assets;

	/**
	 * Theme config.
	 *
	 * @since 1.4.0
	 *
	 * @var   string
	 */
	public $config;

	/**
	 * Theme constructor.
	 *
	 * @since  1.4.0
	 *
	 * @param  string $config Theme config path.
	 *
	 * @return void
	 */
	public function __construct( $config ) {

		$this->config = require_once $config;

		$this->init();
		$this->bootstrap();

	}

	/**
	 * Initialize child theme properties.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function init() {

		$child_theme = wp_get_theme();

		$this->name    = $child_theme->get( 'Name' );
		$this->url     = $child_theme->get( 'ThemeURI' );
		$this->version = $child_theme->get( 'Version' );
		$this->handle  = $child_theme->get( 'TextDomain' );
		$this->author  = $child_theme->get( 'Author' );
		$this->dir     = get_stylesheet_directory();
		$this->vendor  = get_stylesheet_directory() . '/vendor';
		$this->lib     = get_stylesheet_directory() . '/vendor/seothemes/child-theme-library/src';
		$this->views   = get_stylesheet_directory() . '/vendor/seothemes/child-theme-library/resources/views';
		$this->uri     = get_stylesheet_directory_uri();
		$this->assets  = get_stylesheet_directory_uri() . '/assets';
	}

	/**
	 * Bootstrap the child theme library.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function bootstrap() {

		$this->setup       = new Setup( $this );
		$this->utilities   = new Utilities( $this );
		$this->attributes  = new Attributes( $this );
		$this->defaults    = new Defaults( $this );
		$this->demoimport  = new DemoImport( $this );
		$this->herosection = new HeroSection( $this );
		$this->layout      = new Layout( $this );
		$this->markup      = new Markup( $this );
		$this->plugins     = new Plugins( $this );
		$this->templates   = new Templates( $this );
		$this->enqueue     = new Enqueue( $this );
		$this->shortcodes  = new Shortcodes( $this );
		$this->widgets     = new Widgets( $this );
		$this->widgetareas = new WidgetAreas( $this );
		$this->admin       = new Admin( $this );
		$this->customizer  = new Customizer( $this );
		$this->structure   = new Structure( $this );

	}

}

new ChildTheme( get_stylesheet_directory() . '/config/config.php' );
