<?php
/**
 * Child Theme Library
 *
 * WARNING: This file is a part of the core Child Theme Library.
 * DO NOT edit this file under any circumstances. Please use
 * the functions.php file to make any theme modifications.
 *
 * @package   SEOThemes\ChildThemeLibrary\Admin
 * @link      https://github.com/seothemes/child-theme-library
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {

	die;

}

add_action( 'customize_register', 'child_theme_customize_register' );
/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 *
 * @access public
 * @param  object $wp_customize Global customizer object.
 *
 * @throws \Exception If no sub-config is found.
 *
 * @return void
 */
function child_theme_customize_register( $wp_customize ) {

	global $wp_customize;

	$wp_customize->remove_control( 'background_color' );
	$wp_customize->remove_control( 'header_textcolor' );

	$colors = child_theme_get_config( 'colors' );

	/*
	| ------------------------------------------------------------------
	| Logo Size
	| ------------------------------------------------------------------
	|
	| Adds the logo size setting to the Customizer. The logo size
	| setting adds a number field control which outputs inline
	| CSS to change the width of the site logo in the theme.
	|
	*/
	$wp_customize->add_setting(
		'child_theme_logo_size',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 100,
			'sanitize_callback' => 'child_theme_sanitize_number',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'child_theme_logo_size',
		array(
			'label'       => __( 'Logo Size', 'child-theme-library' ),
			'description' => __( 'Set the logo size in pixels. Default is 100.', 'child-theme-library' ),
			'settings'    => 'child_theme_logo_size',
			'section'     => 'title_tagline',
			'type'        => 'number',
			'priority'    => 8,
		)
	) );

	/*
	| ------------------------------------------------------------------
	| Sticky Header
	| ------------------------------------------------------------------
	|
	| Adds the sticky header setting to the Customizer. This setting
	| provides users with the option to have a sticky site header
	| that remains at the top of the screen viewport on scroll.
	|
	*/
	$wp_customize->add_setting(
		'child_theme_sticky_header',
		array(
			'capability' => 'edit_theme_options',
			'default'    => false,
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
		$wp_customize,
		'child_theme_sticky_header',
		array(
			'label'    => __( 'Enable sticky header', 'child-theme-library' ),
			'settings' => 'child_theme_sticky_header',
			'section'  => 'genesis_layout',
			'type'     => 'checkbox',
		)
	) );

	/*
	| ------------------------------------------------------------------
	| Colors
	| ------------------------------------------------------------------
	|
	| Adds the color settings to the Customizer. Loops through an
	| array of custom colors defined in the child theme config
	| file to output a new setting and control for each one.
	|
	*/
	foreach ( $colors as $color => $settings ) {

		$setting = "child_theme_{$color}_color";
		$label   = ucwords( str_replace( '_', ' ', $color ) ) . __( ' Color', 'child-theme-library' );

		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $settings['value'],
				'sanitize_callback' => 'child_theme_sanitize_rgba_color',
			)
		);

		$wp_customize->add_control(
			new RGBA_Customizer_Control(
				$wp_customize,
				$setting,
				array(
					'section'      => 'colors',
					'label'        => $label,
					'settings'     => $setting,
					'show_opacity' => true,
					'palette'      => true,
				)
			)
		);
	}
}
