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
 * Adds utility functions to child theme.
 *
 * @since 1.4.0
 */
class Utilities {

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

	}

	/**
	 * Sanitize RGBA values.
	 *
	 * If string does not start with 'rgba', then treat as hex then
	 * sanitize the hex color and finally convert hex to rgba.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $color The rgba color to sanitize.
	 *
	 * @return string $color Sanitized value.
	 */
	public function sanitize_rgba_color( $color ) {

		// Return invisible if empty.
		if ( empty( $color ) || is_array( $color ) ) {

			return 'rgba(0,0,0,0)';

		}

		// Return sanitized hex if not rgba value.
		if ( false === strpos( $color, 'rgba' ) ) {

			return sanitize_hex_color( $color );

		}

		$red   = '';
		$green = '';
		$blue  = '';
		$alpha = '';

		// Finally, sanitize and return rgba.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

		return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

	}

	/**
	 * Minify CSS helper function.
	 *
	 * @since  1.0.0
	 *
	 * @author Gary Jones
	 * @link   https://github.com/GaryJones/Simple-PHP-CSS-Minification
	 *
	 * @param  string $css The CSS to minify.
	 *
	 * @return string Minified CSS.
	 */
	public function minify_css( $css ) {

		// Normalize whitespace.
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove spaces before and after comment.
		$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

		// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */.
		$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

		// Remove ; before }.
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >.
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { } ( ) >.
		$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px).
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0).
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Converts all zeros value into short-hand.
		$css = preg_replace( '/0 0 0 0/', '0', $css );

		// Shorten 6-character hex color codes to 3-character where possible.
		$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

		return trim( $css );

	}

	/**
	 * Check if any Front Page widgets are active.
	 *
	 * @since  1.0.0
	 *
	 * @return bool
	 */
	public function has_front_page_widgets() {

		$config = $this->theme->config['widget-areas'];

		foreach ( $config as $id => $location ) {

			if ( is_numeric( str_replace( 'front-page-', '', $id ) ) ) {

				if ( is_active_sidebar( $id ) ) {

					return true;

				}
			}
		}

		return false;

	}

}
