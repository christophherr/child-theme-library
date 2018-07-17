<?php
/**
 * Bootstraps the Child Theme Library Unit Tests.
 *
 * @package   SEOThemes\ChildThemeLibrary
 * @link      https://github.com/seothemes/child-theme-library
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-2.0-or-later
 */

namespace SEOThemes\ChildThemeLibrary\Tests\Unit;

/**
 * Initialize the test suite.
 *
 * @since  1.5.0
 *
 * @return void
 */
function init_test_suite() {
	check_readiness();
	init_constants();

	// Load the files.
	$child_theme_library_root_dir = rtrim( CHILD_THEME_LIBRARY_DIR, DIRECTORY_SEPARATOR );

	require_once $child_theme_library_root_dir . '/vendor/autoload.php';
	// require_once __DIR__ . '/test-case-trait.php';

	// Load Patchwork before everything else in order to allow us to redefine WordPress and Beans functions.
	require_once $child_theme_library_root_dir . '/vendor/brain/monkey/inc/patchwork-loader.php';

	// Let's define ABSPATH as it is in WordPress, i.e. relative to the filesystem's WordPress root path.
	if ( ! defined( 'ABSPATH' ) ) {
		define( 'ABSPATH', dirname( dirname( dirname( CHILD_THEME_LIBRARY_DIR ) ) ) . '/' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound -- Valid use case for our testing suite.
	}

	require_once CHILD_THEME_LIBRARY_TESTS_DIR . '/class-test-case.php';
}

/**
 * Check the system's readiness to run the tests.
 *
 * @since 1.5.0
 *
 * @return void
 */
function check_readiness() {
	if ( version_compare( phpversion(), '5.6.0', '<' ) ) {
		trigger_error( 'Child Theme Library Unit Tests require PHP 5.6 or higher.', E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- Valid use case for our testing suite.
	}
	if ( ! file_exists( dirname( dirname( dirname( __DIR__ ) ) ) . '/vendor/autoload.php' ) ) {
		trigger_error( 'Whoops, we need Composer before we start running tests.  Please type: `composer install`.  When done, try running `composer phpunit` again.', E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- Valid use case for our testing suite.
	}
}

/**
 * Initialize the constants.
 *
 * @since  1.5.0
 *
 * @return void
 */
function init_constants() {

	define( 'CHILD_THEME_LIBRARY_TESTS_DIR', __DIR__ . DIRECTORY_SEPARATOR );

	$child_theme_library_root_dir = dirname( dirname( dirname( __DIR__ ) ) ) . DIRECTORY_SEPARATOR;

	define( 'CHILD_THEME_LIBRARY_DIR', $child_theme_library_root_dir );

	define( 'CHILD_THEME_LIBRARY_SRC_DIR', CHILD_THEME_LIBRARY_DIR . 'src' . DIRECTORY_SEPARATOR );

}

init_test_suite();
