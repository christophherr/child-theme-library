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
 * Adds template logic to child theme.
 *
 * @since 1.4.0
 */
class Templates {

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

		add_filter( 'theme_page_templates', [
			$this,
			'add'
		] );
		add_filter( 'template_include', [
			$this,
			'set'
		] );
		add_filter( 'genesis_before', [
			$this,
			'modify'
		], 0 );

	}

	/**
	 * Add page templates.
	 *
	 * Removes default Genesis templates then loads library templates defined in
	 * the child theme's config file.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $page_templates The existing page templates.
	 *
	 * @return array
	 */
	public function add( $page_templates ) {

		$config = $this->theme->config['page-templates'];

		if ( array_key_exists( 'page-blog.php', $config ) ) {

			unset( $config['page-blog.php'] );

		} else {

			unset( $page_templates['page_blog.php'] );

		}

		if ( array_key_exists( 'page-sitemap.php', $config ) ) {

			unset( $page_templates['page_archive.php'] );

		}

		$page_templates = array_merge( $page_templates, $config );

		return $page_templates;

	}

	/**
	 * Modify page based on selected page template.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $template The path to the template being included.
	 *
	 * @return string
	 */
	public function set( $template ) {

		if ( ! is_singular( 'page' ) ) {

			return $template;

		}

		$current_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

		if ( 'page-blog.php' === $current_template ) {

			$template = get_template_directory() . '/page_blog.php';

			return $template;

		}

		if ( 'page-sitemap.php' === $current_template ) {

			$template = get_template_directory() . '/page_sitemap.php';

			return $template;

		}

		return $template;

	}

	/**
	 * Modifies loop depending on current template.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function modify() {

		if ( ! is_singular( 'page' ) ) {

			return;

		}

		$current_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

		if ( 'page-builder.php' === $current_template ) {

			remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
			remove_theme_support( 'hero-section' );
			add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

		}

		if ( 'page-landing.php' === $current_template ) {

			remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );
			remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
			remove_action( 'genesis_header', 'genesis_do_header' );
			remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
			remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
			remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
			remove_action( 'genesis_footer', 'genesis_do_footer' );
			remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
			remove_theme_support( 'hero-section' );
			remove_theme_support( 'genesis-menus' );
			remove_theme_support( 'genesis-footer-widgets' );
			unregister_sidebar( 'footer-credits' );

		}

	}

}