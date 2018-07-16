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
 * Adds markup logic to child theme.
 *
 * @since 1.4.0
 */
class Markup {

	/**
	 * Constructor.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function __construct() {

		add_filter(
			'genesis_markup_title-area_close', [
				$this,
				'after_title_area',
			], 10, 2
		);
		add_action(
			'init', [
				$this,
				'structural_wrap_hooks',
			]
		);

	}

	/**
	 * Adds HTML to the closing markup for .title-area.
	 *
	 * Adding something between the title + description and widget area used to
	 * require re-building genesis_do_header(). However, since the title-area
	 * closing markup now goes through genesis_markup(), it means we now have
	 * some extra filters to play with. This function makes use of this and
	 * adds in an extra hook after the title-area used for displaying the
	 * primary navigation menu.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $close_html HTML tag being processed by the API.
	 * @param  array  $args       Array with markup arguments.
	 *
	 * @return string
	 */
	public function after_title_area( $close_html, $args ) {

		if ( $close_html ) {

			ob_start();

			do_action( 'child_theme_after_title_area' );

			$close_html = $close_html . ob_get_clean();

		}

		return $close_html;

	}

	/**
	 * Add hooks immediately before and after Genesis structural wraps.
	 *
	 * @since   1.0.0
	 *
	 * @version 1.1.0
	 * @author  Tim Jensen
	 * @link    https://timjensen.us/add-hooks-before-genesis-structural-wraps
	 *
	 * @return void
	 */
	public function structural_wrap_hooks() {

		$wraps = get_theme_support( 'genesis-structural-wraps' );

		foreach ( $wraps[0] as $context ) {

			add_filter(
				"genesis_structural_wrap-{$context}", function ( $output, $original ) use ( $context ) {

					$position = ( 'open' === $original ) ? 'before' : 'after';

					ob_start();

					do_action( "child_theme_{$position}_{$context}_wrap" );

					if ( 'open' === $original ) {

						return ob_get_clean() . $output;

					} else {

						return $output . ob_get_clean();

					}

				}, 10, 2
			);

		}

	}

}
