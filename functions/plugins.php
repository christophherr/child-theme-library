<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary\Functions
 * @link      https://github.com/seothemes/child-theme-library
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-2.0+
 */

add_action( 'genesis_setup', 'child_theme_plugin_activation_class' );
/**
 * Instantiate the plugin activation class.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_plugin_activation_class() {

	new TGM_Plugin_Activation();

}

add_action( 'tgmpa_register', 'child_theme_required_plugins' );
/**
 * Register required plugins.
 *
 * The variables passed to the `tgmpa()` function should be:
 *
 * - an array of plugin arrays;
 * - optionally a configuration array.
 *
 * If you are not changing anything in the configuration array, you can remove the
 * array and remove the variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init`
 * action on priority 10.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_required_plugins() {

	$plugins = child_theme_get_config( 'plugins' );

	if ( class_exists( 'WooCommerce' ) ) {

		$plugins[] = array(
			'name'     => 'Genesis Connect WooCommerce',
			'slug'     => 'genesis-connect-woocommerce',
			'required' => true,
		);

	}

	$plugin_config = array(
		'id'           => CHILD_THEME_HANDLE,
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $plugin_config );

}

add_filter( 'simple_social_default_styles', 'child_theme_ssi_default_styles' );
/**
 * Simple Social Icons default settings.
 *
 * @since  1.0.0
 *
 * @param  array $defaults Default Simple Social Icons settings.
 *
 * @return array Custom settings.
 */
function child_theme_ssi_default_styles( $defaults ) {

	$settings = child_theme_get_config( 'simple-social-icons' );

	return wp_parse_args( $settings, $defaults );

}

add_action( 'wp_head', 'child_theme_remove_ssi_inline_styles', 1 );
/**
 * Remove Simple Social Icons inline CSS.
 *
 * No longer needed because we are generating custom CSS instead so removing
 * this means we don't need to use !important rules in the function below.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_remove_ssi_inline_styles() {

	global $wp_widget_factory;

	remove_action( 'wp_head', array( $wp_widget_factory->widgets['Simple_Social_Icons_Widget'], 'css' ) );

}

add_action( 'wp_head', 'child_theme_simple_social_icons_css' );
/**
 * Simple Social Icons multiple instances workaround.
 *
 * By default, Simple Social Icons only allows you to create one style for your
 * icons, even if you have multiple on one page. This function allows us to
 * output different styles for each widget displayed on the front end.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_simple_social_icons_css() {

	if ( ! class_exists( 'Simple_Social_Icons_Widget' ) ) {

		return;

	}

	$obj = new Simple_Social_Icons_Widget();

	$all_instances = $obj->get_settings();

	foreach ( $all_instances as $key => $options ) :

		$instance = wp_parse_args( $all_instances[ $key ] );
		$font_size = round( (int) $instance['size'] / 2 );
		$icon_padding = round( (int) $font_size / 2 );

		$css = '#' . $obj->id_base . '-' . $key . ' ul li a,
		#' . $obj->id_base . '-' . $key . ' ul li a:hover {
			background-color: ' . $instance['background_color'] . ';
			border-radius: ' . $instance['border_radius'] . 'px;
			color: ' . $instance['icon_color'] . ';
			border: ' . $instance['border_width'] . 'px ' . $instance['border_color'] . ' solid;
			font-size: ' . $font_size . 'px;
			padding: ' . $icon_padding . 'px;
		}

		#' . $obj->id_base . '-' . $key . ' ul li a:hover {
			background-color: ' . $instance['background_color_hover'] . ';
			border-color: ' . $instance['border_color_hover'] . ';
			color: ' . $instance['icon_color_hover'] . ';
		}';

		$css = child_theme_minify_css( $css );

		printf( '<style type="text/css" media="screen">%s</style>', $css );

	endforeach;

}

add_filter( 'genesis_widget_column_classes', 'child_theme_widget_columns' );
/**
 * Add additional column class to plugin.
 *
 * @since  1.0.0
 *
 * @param  array $column_classes Array of column classes.
 *
 * @return array Modified column classes.
 */
function child_theme_widget_columns( $column_classes ) {

	$column_classes[] = 'full-width';

	return $column_classes;

}

add_filter( 'gsw_settings_defaults', 'child_theme_testimonial_defaults' );
/**
 * Filter the default Genesis Testimonial Slider settings.
 *
 * @since  1.0.0
 *
 * @param  array $defaults Default plugin settings.
 *
 * @return array
 */
function child_theme_testimonial_defaults( $defaults ) {

	$config = child_theme_get_config( 'testimonial-slider' );

	return ( $config ? $config : $defaults );

}

add_filter( 'agm_custom_styles', 'child_theme_map_styles' );
/**
 * Add custom Google Map style.
 *
 * Adds a custom Google map style to the Google Map plugin used in the theme demo.
 * The JSON file used in this function can be found in the top level directory
 * of the theme. More information can be found by following the links below.
 *
 * @since  1.0.0
 *
 * @link   https://github.com/ankurk91/wp-google-map/wiki/How-to-add-your-own-styles
 * @link   https://snazzymaps.com/style/85413/cartagena
 * @param  array $json Array of JSON data.
 *
 * @return array
 */
function child_theme_map_styles( $json ) {

	$config = child_theme_get_config( 'map-style' );

	if ( ! is_readable( $config['style'] ) ) {

		return $json;

	}

	$config['style'] = json_decode( file_get_contents( $config['style'] ), true );

	array_push( $json, $config );

	return $json;

}

add_action( 'wp_enqueue_scripts', 'child_theme_remove_plugin_css' );
/**
 * Disable third party CSS that is included in theme.
 *
 * @since  1.0.0
 *
 * @return void
 */
function child_theme_remove_plugin_css() {

	add_filter( 'gs_faq_print_styles', '__return_false' );
	add_filter( 'genesis_portfolio_load_default_styles', '__return_false' );

}
