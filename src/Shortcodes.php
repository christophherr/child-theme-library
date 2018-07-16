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
 * Adds shortcodes logic to child theme.
 *
 * @since 1.4.0
 */
class Shortcodes {

	/**
	 * Constructor.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function __construct() {

		$this->enable_widget_shortcodes();

		add_shortcode(
			'footer_backtotop', [
				$this,
				'footer_backtotop',
			]
		);

	}

	/**
	 * Enables shortcodes in text widgets.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function enable_widget_shortcodes() {

		add_filter( 'widget_text', 'do_shortcode' );

	}

	/**
	 * Produces the "Return to Top" link.
	 *
	 * Supported shortcode attributes are:
	 *
	 * - after (output after link, default is empty string),
	 * - before (output before link, default is empty string),
	 * - href (link url, default is fragment identifier '#wrap'),
	 * - nofollow (boolean for whether to include rel="nofollow", default is
	 * true),
	 * - text (Link text, default is 'Return to top of page').
	 *
	 * Output passes through `child_theme_footer_backtotop` filter before
	 * returning.
	 *
	 * @since  1.0.0
	 *
	 * @param  array|string $atts Shortcode attributes. Empty string if no
	 *                            attributes.
	 *
	 * @return string Output for `footer_backtotop` shortcode.
	 */
	public function footer_backtotop( $atts ) {

		$defaults = array(
			'after'    => '',
			'before'   => '',
			'href'     => '#top',
			'nofollow' => true,
			'text'     => __( 'Return to top', 'genesis' ),
		);

		$atts     = shortcode_atts( $defaults, $atts, 'footer_backtotop' );
		$nofollow = $atts['nofollow'] ? 'rel="nofollow"' : '';
		$output   = sprintf( '%s<a href="%s" %s>%s</a>%s', $atts['before'], esc_url( $atts['href'] ), $nofollow, $atts['text'], $atts['after'] );

		return apply_filters( 'child_theme_footer_backtotop', $output, $atts );

	}

}
