<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary
 * @since     1.0.0
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
 * Adds attributes logic to child theme.
 *
 * @since 1.4.0
 */
class Attributes {

	/**
	 * Child theme object.
	 *
	 * @since 1.4.0
	 *
	 * @var   object
	 */
	public $theme;

	/**
	 * Attributes constructor.
	 *
	 * @since  1.4.0
	 *
	 * @param  object $theme Child theme object.
	 *
	 * @return void
	 */
	public function __construct( $theme ) {

		$this->theme = $theme;

		add_filter( 'body_class', [
			$this,
			'body_class'
		] );
		add_filter( 'genesis_attr_site-container', [
			$this,
			'site_container'
		] );
		add_filter( 'genesis_attr_title-area', [
			$this,
			'title_area'
		] );
		add_filter( 'genesis_attr_site-title', [
			$this,
			'site_title_schema'
		] );
		add_filter( 'genesis_attr_hero-section', [
			$this,
			'hero_section'
		] );
		add_filter( 'genesis_attr_entry', [
			$this,
			'entry'
		] );

	}

	/**
	 * Add custom body classes.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $classes Body classes.
	 *
	 * @return array
	 */
	function body_class( $classes ) {

		if ( get_theme_mod( 'child_theme_sticky_header' ) ) {

			$classes[] = 'has-sticky-header';

		}

		if ( has_nav_menu( 'secondary' ) ) {

			$classes[] = 'has-nav-secondary';

		}

		if ( is_active_sidebar( 'before-header' ) ) {

			$classes[] = 'has-before-header';

		}

		if ( is_page_template( 'page-blog.php' ) ) {

			$classes[] = 'blog';
			$classes   = array_diff( $classes, [ 'page' ] );

		}

		$classes[] = str_replace( '.php', '', get_page_template_slug() );

		$classes[] = 'no-js';

		return $classes;

	}

	/**
	 * Add 'top' ID attribute to site-container.
	 *
	 * This adds an ID attribute to the site-container by filtering the element
	 * attributes so that the "Return to Top" link has something to link to.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $atts Navigation attributes.
	 *
	 * @return array
	 */
	function site_container( $atts ) {

		$atts['id'] = 'top';

		return $atts;

	}

	/**
	 * Add schema microdata to title-area.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $attr Array of attributes.
	 *
	 * @return array
	 */
	function title_area( $attr ) {

		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'http://schema.org/Organization';

		return $attr;

	}

	/**
	 * Correct site title schema.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $attr Array of attributes.
	 *
	 * @return array
	 */
	function site_title_schema( $attr ) {

		$attr['itemprop'] = 'name';

		return $attr;

	}

	/**
	 * Callback for dynamic Genesis 'genesis_attr_$context' filter.
	 *
	 * Add custom attributes for the custom filter.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $attr The element attributes.
	 *
	 * @return array
	 */
	function hero_section( $attr ) {

		$attr['id'] = 'hero-section';
		$attr['role'] = 'banner';

		return $attr;

	}

	/**
	 * Add itemref attribute to link entry-title.
	 *
	 * Since the entry-title is repositioned outside of the entry article, we
	 * need to add some additional microdata so that it is still picked up as a
	 * part of the entry. By adding the itemref attribute, we are telling
	 * search engines to check the hero-section element for additional
	 * elements.
	 *
	 * @since  1.0.0
	 *
	 * @link   https://www.w3.org/TR/microdata/#dfn-itemref
	 *
	 * @param  array $atts Entry attributes.
	 *
	 * @return array
	 */
	function entry( $atts ) {

		if ( current_theme_supports( 'hero-section' ) && is_singular() ) {

			$atts['itemref'] = 'hero-section';

		}

		return $atts;

	}

}
