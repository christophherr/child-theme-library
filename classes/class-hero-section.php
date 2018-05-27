<?php
/**
 * Description.
 *
 * @package   SEOThemes\Core\Classes
 * @since     1.0.0
 * @link      https://github.com/seothemes/genesis-starter
 * @author    SEO Themes
 * @copyright Copyright © 2018 SEO Themes
 * @license   GPL-2.0+
 */

namespace SEOThemes\Core\Classes;

class Hero_Section {

	public function __construct() {

		$this->register_default_headers();

		add_action( 'genesis_before', array( $this, __NAMESPACE__ . '\setup' ) );

	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_default_headers() {

		register_default_headers( array(
			'child' => array(
				'url' => '%2$s/assets/images/hero.jpg',
				'thumbnail_url' => '%2$s/assets/images/hero.jpg',
				'description' => __( 'Hero Image', CHILD_THEME_HANDLE ),
			),
		) );

	}

	/**
	 * Set up hero section.
	 *
	 * Removes and repositions the title on all possible types of pages. Wrapped
	 * up into one function so it can easily be unhooked from genesis_before.
	 *
	 * @since  2.2.4
	 *
	 * @return void
	 */
	function setup() {

		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
		remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_open', 5, 3 );
		remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_close', 15, 3 );
		remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
		remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
		remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
		remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

		add_filter( 'woocommerce_show_page_title', '__return_null' );
		add_filter( 'genesis_search_title_output', '__return_false' );

		add_action( 'genesis_hero_section', 'genesis_do_posts_page_heading' );
		add_action( 'genesis_hero_section', 'genesis_do_date_archive_title' );
		add_action( 'genesis_hero_section', 'genesis_do_taxonomy_title_description' );
		add_action( 'genesis_hero_section', 'genesis_do_author_title_description' );
		add_action( 'genesis_hero_section', 'genesis_do_cpt_archive_title_description' );
		add_action( 'genesis_hero_section', array( $this, __NAMESPACE__ . '\title' ), 10 );
		add_action( 'genesis_hero_section', array( $this, __NAMESPACE__ . '\excerpt' ), 20 );
		add_action( 'be_title_toggle_remove', array( $this, __NAMESPACE__ . '\title_toggle' ) );
		add_action( 'genesis_before_content', array( $this, __NAMESPACE__ . '\remove_404_title' ) );
		add_action( 'genesis_before_content_sidebar_wrap', array( $this, __NAMESPACE__ . '\display' ) );

	}

	/**
	 * Remove default title of 404 pages.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function remove_404_title() {

		if ( is_404() ) {

			add_filter( 'genesis_markup_entry-title_open', '__return_false' );
			add_filter( 'genesis_markup_entry-title_content', '__return_false' );
			add_filter( 'genesis_markup_entry-title_close', '__return_false' );

		}

	}

	/**
	 * Integrate with Genesis Title Toggle plugin
	 *
	 * @since  1.0.0
	 *
	 * @author Bill Erickson
	 * @link   https://www.billerickson.net/code/genesis-title-toggle-theme-integration
	 *
	 * @return void
	 */
	public function title_toggle() {

		remove_action( 'genesis_hero_section', __NAMESPACE__ . '\page_title', 10 );
		remove_action( 'genesis_hero_section', __NAMESPACE__ . '\page_excerpt', 20 );

	}

	/**
	 * Display title in hero section.
	 *
	 * Works out the correct title to display in the hero section on a per page
	 * basis. Also adds the entry title back in to the entry inside the loop.
	 *
	 * @since  2.2.4
	 *
	 * @todo   Update 404 title when Genesis 2.6 is released.
	 *
	 * @return void
	 */
	public function title() {

		// Add post titles back inside posts loop.
		if ( is_home() || is_archive() || is_category() || is_tag() || is_tax() || is_search() || is_page_template( 'page_blog.php' ) ) {

			add_action( 'genesis_entry_header', 'genesis_do_post_title', 2 );

		}

		if ( class_exists( 'WooCommerce' ) && is_shop() ) {

			genesis_markup( array(
				'open'    => '<h1 %s>',
				'close'   => '</h1>',
				'content' => get_the_title( wc_get_page_id( 'shop' ) ),
				'context' => 'entry-title',
			) );

		} elseif ( 'posts' === get_option( 'show_on_front' ) && is_home() ) {

			genesis_markup( array(
				'open'    => '<h1 %s>',
				'close'   => '</h1>',
				'content' => apply_filters( 'genesis_starter_latest_posts_title', __( 'Latest Posts', CHILD_THEME_HANDLE ) ),
				'context' => 'entry-title',
			) );

		} elseif ( is_404() ) {

			genesis_markup( array(
				'open'    => '<h1 %s>',
				'close'   => '</h1>',
				'content' => apply_filters( 'genesis_404_entry_title', __( 'Not found, error 404', CHILD_THEME_HANDLE ) ),
				'context' => 'entry-title',
			) );

		} elseif ( is_search() ) {

			genesis_markup( array(
				'open'    => '<h1 %s>',
				'close'   => '</h1>',
				'content' => apply_filters( 'genesis_search_title_text', __( 'Search results for: ', CHILD_THEME_HANDLE ) ) . get_search_query(),
				'context' => 'entry-title',
			) );

		} elseif ( is_page_template( 'page_blog.php' ) ) {

			do_action( 'genesis_archive_title_descriptions', get_the_title(), '', 'posts-page-description' );

		} elseif ( is_single() || is_singular() ) {

			genesis_do_post_title();

		}

	}

	/**
	 * Display page excerpt.
	 *
	 * Prints the correct excerpt on a per page basis. If on the WooCommerce shop
	 * page then the products result count is be displayed instead of the page
	 * excerpt. Also, if on a single product then no excerpt will be output.
	 *
	 * @since  2.2.4
	 *
	 * @return void
	 */
	public function excerpt() {

		if ( class_exists( 'WooCommerce' ) && is_shop() ) {

			woocommerce_result_count();

		} elseif ( is_home() ) {

			printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt( get_option( 'page_for_posts' ) ) ) );

		} elseif ( is_search() ) {

			$id = get_page_by_path( 'search' );

			if ( has_excerpt( $id ) ) {

				printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt( $id ) ) );

			}
		} elseif ( is_404() ) {

			$id = get_page_by_path( 'error' );

			if ( has_excerpt( $id ) ) {

				printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt( $id ) ) );

			}
		} elseif ( ( is_single() || is_singular() ) && ! is_singular( 'product' ) && has_excerpt() ) {

			printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt() ) );

		}
	}

	/**
	 * Display the hero section.
	 *
	 * Conditionally outputs the opening and closing hero section markup and runs
	 * the hero_section hook which all of our hero functions are hooked to.
	 *
	 * @since  2.2.4
	 *
	 * @return void
	 */
	public function display() {

		// Output hero section markup.
		genesis_markup( array(
			'open'    => '<section %s><div class="wrap">',
			'context' => 'hero-section',
		) );

		/**
		 * Do hero section hook.
		 *
		 * @hooked genesis_starter_page_title - 10
		 * @hooked genesis_starter_page_excerpt - 20
		 * @hooked genesis_do_posts_page_heading
		 * @hooked genesis_do_date_archive_title
		 * @hooked genesis_do_blog_template_heading
		 * @hooked genesis_do_taxonomy_title_description
		 * @hooked genesis_do_author_title_description
		 * @hooked genesis_do_cpt_archive_title_description
		 */
		do_action( 'genesis_hero_section' );

		// Output hero section markup.
		genesis_markup( array(
			'close'   => '</div></section>',
			'context' => 'hero-section',
		) );

	}

}