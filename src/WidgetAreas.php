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
 * Adds widget area logic to child theme.
 *
 * @since 1.4.0
 */
class WidgetAreas {

	/**
	 * Child theme object.
	 *
	 * @since 1.4.0
	 *
	 * @var   object
	 */
	public $theme;

	/**
	 * Child theme config.
	 *
	 * @since 1.4.0
	 *
	 * @var   array
	 */
	public $config;

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

		$this->theme  = $theme;
		$this->config = $theme->config;

		$this->remove( $this->config['widget-areas'] );
		$this->add( $this->config['widget-areas'] );
		$this->front_page();
		$this->footer_credits();

	}

	/**
	 * Removes default widget areas.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $config Widget areas config.
	 *
	 * @return void
	 */
	public function remove( $config ) {

		$config = array_fill_keys( array_keys( $config ), null );

		$defaults = array(
			'after-entry'  => null,
			'header-right' => null,
			'sidebar'      => null,
			'sidebar-alt'  => null,
		);

		foreach ( $defaults as $default => $location ) {

			if ( ! array_key_exists( $default, $config ) ) {

				unregister_sidebar( $default );

				if ( 'after-entry' === $default ) {

					remove_theme_support( 'genesis-after-entry-widget-area' );

				}
			}
		}

	}

	/**
	 * Add custom widget areas defined in config.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $config Widget areas config.
	 *
	 * @return void
	 */
	public function add( $config ) {

		foreach ( $config as $id => $location ) {

			if ( is_numeric( str_replace( 'footer-', '', $id ) ) ) {

				add_theme_support( 'genesis-footer-widgets', str_replace( 'footer-', '', $id ) );

			} elseif ( 'after-entry' !== $id ) {

				$name        = ucwords( str_replace( '-', ' ', $id ) );
				$description = $name . ' widget area';

				if ( 'front-page-1' === $id ) {

					genesis_register_sidebar(
						array(
							'name'         => $name,
							'description'  => $description,
							'id'           => $id,
							'before_title' => '<h1 itemprop="headline">',
							'after_title'  => '</h1>',
						)
					);

				} else {

					genesis_register_sidebar(
						array(
							'name'        => $name,
							'description' => $description,
							'id'          => $id,
						)
					);

				}

				if ( ! empty( $location ) && true === apply_filters( "child_theme_{$id}", true ) ) {

					add_action(
						$location, function () use ( $id ) {

							if ( 'front-page-1' === $id ) {

								ob_start();
								the_custom_header_markup();
								$custom_header = ob_get_clean();

								genesis_widget_area(
									$id, array(
										'before'       => '<div class="' . $id . ' widget-area hero-section" role="banner">' . $custom_header . '<div class="wrap">',
										'after'        => '</div></div>',
										'before_title' => '<h1 itemprop="headline">',
										'after_title'  => '</h1>',
									)
								);

							} else {

								genesis_widget_area(
									$id, array(
										'before' => '<div class="' . $id . ' widget-area"><div class="wrap">',
										'after'  => '</div></div>',
									)
								);

							}

						}
					);

				}
			}
		}

	}

	/**
	 * Display front page widget areas if active.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function front_page() {

		if ( is_admin() || ! is_front_page() || ! $this->theme->utilities->has_front_page_widgets() ) {

			return;

		}

		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

		remove_theme_support( 'hero-section' );

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action(
			'genesis_loop', function () {

				do_action( 'child_theme_front_page_widgets' );

			}
		);

	}

	/**
	 * Display footer credits widget area if active.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function footer_credits() {

		if ( is_admin() || ! is_active_sidebar( 'footer-credits' ) ) {

			return;

		}

		remove_action( 'genesis_footer', 'genesis_do_footer' );

	}

}
