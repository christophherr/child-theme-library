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
 * Adds admin logic to child theme.
 *
 * @since 1.4.0
 */
class Admin {

	/**
	 * Constructor.
	 *
	 * @since  1.4.0
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'after_switch_theme', [ $this, 'display_excerpt_metabox' ] );
		add_filter( 'http_request_args', [ $this, 'dont_update_theme' ], 5, 2 );

	}

	/**
	 * Display excerpt metabox by default.
	 *
	 * The excerpt metabox is hidden by default on the page edit screen which
	 * can cause confusion for some users if they want to edit or remove the
	 * excerpt. To make it easier, we want to show the excerpt metabox by
	 * default. It only runs after switching theme so the current user's screen
	 * options are updated, allowing them to hide the metabox if not used.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function display_excerpt_metabox() {

		$user_id = get_current_user_id();

		$post_types = array(
			'page',
			'post',
			'portfolio',
		);

		foreach ( $post_types as $post_type ) {

			$meta_key   = 'metaboxhidden_' . $post_type;
			$prev_value = get_user_meta( $user_id, $meta_key, true );

			if ( ! is_array( $prev_value ) ) {

				$prev_value = array(
					'genesis_inpost_seo_box',
					'postcustom',
					'postexcerpt',
					'commentstatusdiv',
					'commentsdiv',
					'slugdiv',
					'authordiv',
					'genesis_inpost_scripts_box',
				);

			}

			$meta_value = array_diff( $prev_value, array( 'postexcerpt' ) );

			update_user_meta( $user_id, $meta_key, $meta_value, $prev_value );

		}

	}

	/**
	 * Don't Update Theme.
	 *
	 * If there is a theme in the repo with the same name,
	 * this prevents WP from prompting an update.
	 *
	 * @since  1.0.0
	 *
	 * @param  array  $request Request arguments.
	 * @param  string $url     Request url.
	 *
	 * @return array  request arguments
	 */
	public function dont_update_theme( $request, $url ) {

		if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) ) {

			return $request;

		}

		$themes = json_decode( $request['body']['themes'] );

		unset( $themes[ get_option( 'template' ) ] );
		unset( $themes[ get_option( 'stylesheet' ) ] );

		$request['body']['themes'] = wp_json_encode( $themes );

		return $request;

	}

}
