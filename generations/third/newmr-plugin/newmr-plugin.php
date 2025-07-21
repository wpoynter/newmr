<?php
/**
 * Plugin Name: NewMR Plugin
 * Plugin URI: https://example.com/
 * Description: Skeleton plugin for the third generation of NewMR.
 * Version: 0.1.0
 * Author: NewMR Team
 * Author URI: https://example.com/
 * License: GPL2
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Constants for custom rewrite endpoints.
 */
if ( ! defined( 'EP_EVENT' ) ) {
		define( 'EP_EVENT', 8192 );
}

/**
 * Register all custom post types and taxonomies.
 */
function newmr_register_post_types() {
		register_post_type(
			'booth',
			array(
				'labels'            => array(
					'name'          => __( 'eXhibition', 'newmr' ),
					'singular_name' => __( 'Booth', 'newmr' ),
					'add_new_item'  => __( 'Add New Booth', 'newmr' ),
					'edit_item'     => __( 'Edit Booth', 'newmr' ),
				),
				'public'            => true,
				'has_archive'       => true,
				'show_in_nav_menus' => false,
				'menu_position'     => 15,
				'menu_icon'         => 'dashicons-visibility',
				'supports'          => array( 'title', 'editor', 'page-attributes' ),
				'rewrite'           => array(
					'slug'       => 'exhibition',
					'with_front' => false,
				),
			)
		);

		register_post_type(
			'advert',
			array(
				'labels'            => array(
					'name'          => __( 'Adverts', 'newmr' ),
					'singular_name' => __( 'Advert', 'newmr' ),
					'add_new_item'  => __( 'Add New Advert', 'newmr' ),
					'edit_item'     => __( 'Edit Advert', 'newmr' ),
				),
				'public'            => true,
				'show_in_nav_menus' => false,
				'menu_position'     => 16,
				'menu_icon'         => 'dashicons-star-filled',
				'supports'          => array( 'title', 'editor', 'page-attributes' ),
			)
		);

		register_post_type(
			'event',
			array(
				'labels'             => array(
					'name'          => __( 'Events', 'newmr' ),
					'singular_name' => __( 'Event', 'newmr' ),
					'add_new_item'  => __( 'Add New Event', 'newmr' ),
					'edit_item'     => __( 'Edit Event', 'newmr' ),
				),
				'public'             => true,
				'publicly_queryable' => true,
				'query_var'          => true,
				'show_in_nav_menus'  => true,
				'menu_position'      => 17,
				'menu_icon'          => 'dashicons-calendar',
				'hierarchical'       => true,
				'supports'           => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'revisions', 'shortlinks' ),
				'rewrite'            => false,
			)
		);

		register_post_type(
			'presentation',
			array(
				'labels'            => array(
					'name'          => __( 'Presentations', 'newmr' ),
					'singular_name' => __( 'Presentation', 'newmr' ),
					'add_new_item'  => __( 'Add New Presentation', 'newmr' ),
					'edit_item'     => __( 'Edit Presentation', 'newmr' ),
				),
				'public'            => true,
				'show_in_nav_menus' => false,
				'menu_position'     => 18,
				'menu_icon'         => 'dashicons-video-alt3',
				'supports'          => array( 'title', 'editor', 'page-attributes', 'revisions', 'shortlinks' ),
				'rewrite'           => array(
					'slug'       => 'presentations',
					'with_front' => false,
				),
				'taxonomies'        => array( 'topic' ),
			)
		);

		register_taxonomy(
			'topic',
			'presentation',
			array(
				'labels'            => array(
					'name'                       => __( 'Topics', 'newmr' ),
					'singular_name'              => __( 'Topic', 'newmr' ),
					'all_items'                  => __( 'All Topics', 'newmr' ),
					'edit_item'                  => __( 'Edit Topic', 'newmr' ),
					'view_item'                  => __( 'View Topic', 'newmr' ),
					'update_item'                => __( 'Update Topic', 'newmr' ),
					'add_new_item'               => __( 'Add New Topic', 'newmr' ),
					'new_item_name'              => __( 'New Topic Name', 'newmr' ),
					'search_items'               => __( 'Search Topics', 'newmr' ),
					'popular_items'              => __( 'Popular Topics', 'newmr' ),
					'separate_items_with_commas' => __( 'Separate topics with commas', 'newmr' ),
					'add_or_remove_items'        => __( 'Add or remove topics', 'newmr' ),
					'choose_from_most_used'      => __( 'Choose from the most used topics', 'newmr' ),
					'not_found'                  => __( 'No topics found', 'newmr' ),
				),
				'show_admin_column' => true,
				'rewrite'           => array(
					'slug'       => 'topic',
					'with_front' => false,
				),
			)
		);

		register_post_type(
			'person',
			array(
				'labels'            => array(
					'name'          => __( 'People', 'newmr' ),
					'singular_name' => __( 'Person', 'newmr' ),
					'add_new_item'  => __( 'Add New Person', 'newmr' ),
					'edit_item'     => __( 'Edit Person', 'newmr' ),
				),
				'public'            => true,
				'has_archive'       => true,
				'show_in_nav_menus' => false,
				'menu_position'     => 19,
				'menu_icon'         => 'dashicons-id',
				'supports'          => array( 'title', 'editor', 'thumbnail', 'shortlinks' ),
				'rewrite'           => array(
					'slug'       => 'people',
					'with_front' => false,
				),
			)
		);

		add_rewrite_rule(
			'^play-again/([^/]*)/([^/]*)/?$',
			'index.php?pagename=play-again&one=$matches[1]&two=$matches[2]',
			'top'
		);
		add_rewrite_rule(
			'^play-again/([^/]*)/?$',
			'index.php?pagename=play-again&one=$matches[1]',
			'top'
		);

		add_rewrite_tag( '%one%', '([^&]+)' );
		add_rewrite_tag( '%two%', '([^&]+)' );

		add_rewrite_tag( '%event%', '(.?.+?)', 'event=' );
		add_rewrite_tag( '%eyear%', '([0-9]{4})' );
		add_permastruct(
			'event',
			'/events/%eyear%/%event%/',
			array(
				'with_front' => false,
				'ep_mask'    => EP_EVENT,
				'paged'      => false,
				'feed'       => false,
				'endpoints'  => true,
			)
		);

				add_rewrite_endpoint( 'speakers', EP_EVENT );

				add_rewrite_rule(
					'([^/]*)',
					'index.php?post_type=post&name=$matches[1]',
					'bottom'
				);
}
add_action( 'init', 'newmr_register_post_types' );

/**
 * Placeholder for plugin activation hook.
 */
function newmr_plugin_activate() {
				newmr_register_post_types();
				add_option( 'newmr_front_middle_left', '' );
				add_option( 'newmr_front_bottom_right', '' );
				add_option( 'newmr_ga_tracking_code', '' );
				add_option( 'newmr_left_footer_link', '' );
				add_option( 'newmr_right_footer_link', '' );
				add_option( 'newmr_featured_video', '' );
				flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'newmr_plugin_activate' );

/**
 * Placeholder for plugin deactivation hook.
 */
function newmr_plugin_deactivate() {
		flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'newmr_plugin_deactivate' );

/**
 * Replace placeholders in event permalinks.
 *
 * @param string  $permalink Permalink.
 * @param WP_Post $post      Post object.
 * @param bool    $_leavename Leave post name. Unused.
 *
 * @return string
 */
function newmr_event_permalink( $permalink, $post, $_leavename ) {
		unset( $_leavename );

	if ( 'event' !== get_post_type( $post ) ) {
			return $permalink;
	}

		$date_from = get_post_meta( $post->ID, 'event_date_from', true );
	if ( $date_from ) {
			$year = gmdate( 'Y', strtotime( $date_from ) );
	} else {
			$year = get_post_time( 'Y', false, $post, true );
	}

		$permalink = str_replace( '%eyear%', $year, $permalink );
		$permalink = str_replace( '%event%', $post->post_name, $permalink );

		return $permalink;
}
add_filter( 'post_type_link', 'newmr_event_permalink', 10, 3 );

/**
 * Load additional modules.
 */
require_once __DIR__ . '/includes/class-newmr-dashboard-glancer.php';
require_once __DIR__ . '/includes/class-newmr-adverts-widget.php';
require_once __DIR__ . '/includes/class-newmr-settings.php';


// Register dashboard glancer items for custom post types.
$glancer = new NewMR_Dashboard_Glancer();
$glancer->add( array( 'advert', 'booth', 'event', 'presentation', 'person' ) );

// Register adverts widget.
add_action(
	'widgets_init',
	static function () {
								register_widget( 'NewMR_Adverts_Widget' );
	}
);

/**
 * Output Google Analytics script if tracking code is set.
 */
function newmr_output_ga() {
	if ( get_option( 'newmr_ga_tracking_code' ) ) {
			require __DIR__ . '/includes/googleanalytics.php';
	}
}
add_action( 'wp_head', 'newmr_output_ga' );

// Initialize settings page.
$newmr_settings = new NewMR_Settings();

/**
 * Normalize person slugs by replacing spaces with hyphens and lowering case.
 *
 * @param string $slug       Proposed slug.
 * @param int    $post_ID    Post ID.
 * @param string $post_status Post status.
 * @param string $post_type  Post type.
 * @param int    $post_parent Post parent ID.
 *
 * @return string Filtered slug.
 */
function newmr_person_unique_slug( $slug, $post_ID, $post_status, $post_type, $post_parent ) {
	unset( $post_ID, $post_status, $post_parent );

	if ( 'person' !== $post_type ) {
		return $slug;
	}

	return strtolower( str_replace( array( '%20', ' ' ), '-', $slug ) );
}
add_filter( 'wp_unique_post_slug', 'newmr_person_unique_slug', 10, 5 );

/**
 * Disable AddToAny sharing buttons on custom post types.
 *
 * @param bool $sharing_disabled Current disabled state.
 *
 * @return bool
 */
function share_in_posts( $sharing_disabled ) {
	global $post;

	return $sharing_disabled || in_array( $post->post_type, array( 'advert', 'booth', 'presentation', 'event', 'person' ), true );
}
add_filter( 'addtoany_sharing_disabled', 'share_in_posts' );

/**
 * Modify queries for custom post types.
 *
 * Replicates legacy behaviour for sorting and paging.
 *
 * @param WP_Query $query Query instance.
 */
function newmr_modify_queries( WP_Query $query ) {
	if ( is_admin() ) {
		return;
	}

	$type = $query->get( 'post_type' );

	if ( ! $query->get( 'posts_per_page' ) && $type ) {
		switch ( $type ) {
			case 'person':
				$query->set( 'posts_per_page', -1 );
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'ASC' );
				break;
			case 'booth':
				$query->set( 'posts_per_page', -1 );
				break;
		}
	}

	if ( 'booth' === $type || 'advert' === $type ) {
		$query->set( 'order', 'ASC' );
	}

	if ( 'person' === $type ) {
		$name   = $query->get( 'name' );
		$person = $query->get( 'person' );

		if ( $name ) {
			$query->set( 'name', strtolower( str_replace( array( '%20', ' ' ), '-', $name ) ) );
		}
		if ( $person ) {
			$query->set( 'person', strtolower( str_replace( array( '%20', ' ' ), '-', $person ) ) );
		}
	}
}
add_action( 'pre_get_posts', 'newmr_modify_queries' );
