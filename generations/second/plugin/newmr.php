<?php

/**
 * Plugin Name: NewMR
 * Description: NewMR's custom plugin to provide specialist functionality.
 * Version: 1.0
 * Author: Will Poynter
 * Author URI: http://williampoynter.co.uk
 */

define('EP_EVENT', 8192);

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
//set_error_handler("exception_error_handler");

// if (!class_exists('Gamajo_Dashboard_Glancer')) {
// 	include 'includes/class-gamajo-dashboard-glancer.php';
// }

// if (!class_exists('Video_Importer')) {
// 	include 'includes/class-video-importer.php';
// }

// function jetpackme_is_mobile() {
 
//     if ( ! function_exists( 'jetpack_is_mobile' ) )
//         return false;
 
//     if ( isset( $_COOKIE['akm_mobile'] ) && $_COOKIE['akm_mobile'] == 'false' )
//         return false;
  
//     return jetpack_is_mobile();
// }

// function disable_orig_mobile_theme( $theme_path ) {
// 	remove_filter('theme_root', 'minileven_theme_root');
// 	return $theme_path;
// }
// add_filter( 'theme_root', 'disable_orig_mobile_theme', 1 );

// function disable_orig_mobile_theme_uri( $theme_path ) {
// 	remove_filter('theme_root_uri', 'minileven_theme_root_uri');
// 	return $theme_path;
// }
// add_filter( 'theme_root_uri', 'disable_orig_mobile_theme', 1 );

// function swap_mobile_theme( $theme_path ) {
// 	if ( jetpack_check_mobile() ) {
// 		return $theme_path . "/fourwalls/mobile/";
// 	}
// 	return $theme_path;
// }
// add_filter( 'theme_root', 'swap_mobile_theme', 11 );

// function swap_mobile_theme_uri( $theme_root_uri ) {
// 	if ( jetpack_check_mobile() ) {
// 		return plugins_url( $theme_root_uri . '/fourwalls/mobile', 'minileven.php' );
// 	}

// 	return $theme_root_uri;
// }

// add_filter( 'theme_root_uri', 'minileven_theme_root_uri', 11 );

function event_permalink($permalink, $post_id, $leavename) {
	$ancestors = get_ancestors($post_id->ID, 'event');
	$top_ID = empty($ancestors) ? $post_id->ID : end($ancestors);
    $post = get_post($top_ID);
    $rewritecode = array(
        '%eyear%',
		'%year%',
        '%monthnum%',
        '%day%',
        '%hour%',
        '%minute%',
        '%second%',
        $leavename? '' : '%postname%',
        '%post_id%',
		'%parent_id%',
        '%category%',
        '%author%',
        $leavename? '' : '%pagename%',
    );
 
    if ( '' != $permalink && 
			!in_array($post->post_status, array('draft', 'pending', 'auto-draft')) && 
			in_array($post->post_type, array('event')) ) {
        $unixtime = strtotime($post->post_date);
		$unixtime_from = get_post_meta($post->ID, 'event_date_from', true);
     
        $category = '';
        if ( strpos($permalink, '%category%') !== false ) {
            $cats = get_the_category($post->ID);
            if ( $cats ) {
                usort($cats, '_usort_terms_by_ID'); // order by ID
                $category = $cats[0]->slug;
                if ( $parent = $cats[0]->parent )
                    $category = get_category_parents($parent, false, '/', true) . $category;
            }
            // show default category in permalinks, without
            // having to assign it explicitly
            if ( empty($category) ) {
                $default_category = get_category( get_option( 'default_category' ) );
                $category = is_wp_error( $default_category ) ? '' : $default_category->slug;
            }
        }
     
        $author = '';
        if ( strpos($permalink, '%author%') !== false ) {
            $authordata = get_userdata($post->post_author);
            $author = $authordata->user_nicename;
        }
     
        $date = explode(" ",date('Y m d H i s', $unixtime));
        $rewritereplace =
        array(
			date('Y', $unixtime_from),
            $date[0],
            $date[1],
            $date[2],
            $date[3],
            $date[4],
            $date[5],
            $post->post_name,
			$post_id->ID,
            $post->ID,
            $category,
            $author,
            $post->post_name,
        );
        $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
    } else { // if they're not using the fancy permalink option
    }
    return $permalink;
}
add_filter('post_type_link', 'event_permalink', 10, 3); 


function create_post_types() {
	register_post_type( 'booth',
		array(
			'labels' => array(
				'name' => __( 'eXhibition' ),
				'singular_name' => __( 'Booth' ),
				'add_new_item' => __( 'Add New Booth' ),
				'edit_item' => __( 'Edit Booth' )
			),
		'public' => true,
		'has_archive' => true,
		'show_in_nav_menus' => false,
		'menu_position' => 15,
		'menu_icon' => 'dashicons-visibility',
		'supports' => array('title','editor','page-attributes'),
		'rewrite' => array( 'slug' => 'exhibition', 'with_front' => false )
		)
	);
	register_post_type( 'advert',
		array(
			'labels' => array(
				'name' => __( 'Adverts' ),
				'singular_name' => __( 'Advert' ),
				'add_new_item' => __( 'Add New Advert' ),
				'edit_item' => __( 'Edit Advert' )
			),
		'public' => true,
		'show_in_nav_menus' => false,
		'menu_position' => 16,
		'menu_icon' => 'dashicons-star-filled',
		'supports' => array('title','editor','page-attributes')
		)
	);
	register_post_type( 'event',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'add_new_item' => __( 'Add New Event' ),
				'edit_item' => __( 'Edit Event' )
			),
		'public' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'show_in_nav_menus' => true,
		'menu_position' => 17,
		'menu_icon' => 'dashicons-calendar',
		'hierarchical' => true,
		'supports' => array('title','editor','page-attributes','thumbnail','revisions','shortlinks'),
		'rewrite' => false
		)
	);
	register_post_type( 'presentation',
		array(
			'labels' => array(
				'name' => __( 'Presentations' ),
				'singular_name' => __( 'Presentation' ),
				'add_new_item' => __( 'Add New Presentation' ),
				'edit_item' => __( 'Edit Presentation' )
			),
		'public' => true,
		'show_in_nav_menus' => false,
		'menu_position' => 18,
		'menu_icon' => 'dashicons-video-alt3',
		'supports' => array('title','editor','page-attributes','revisions','shortlinks'),
		'rewrite' => array( 'slug' => 'presentations', 'with_front' => false  ),
		'taxonomies' => array('topic')
		)
	);
	register_taxonomy('topic', 'presentation', 
		array(
			'labels'			=> array(
				'name'							=>	'Topics',
				'singular_name'					=>	'Topic',
				'all_items'						=>	'All Topics',
				'edit_item'						=>	'Edit Topic',
				'view_item'						=>	'View Topic',
				'update_item'					=>	'Update Topic',
				'add_new_item'					=>	'Add New Topic',
				'new_item_name'					=>	'New Topic Name',
				'search_items'					=>	'Search Topics',
				'popular_items'					=>	'Popular Topics',
				'separate_items_with_commas'	=>	'Separate topics with commas',
				'add_or_remove_items'			=>	'Add or remove topics',
				'choose_from_most_used'			=>	'Choose from the most used topics',
				'not_found'						=>	'No topics found'
			),
			'show_admin_column'	=> true,
			'rewrite'			=> array(
				'slug'							=>	'topic',
				'with_front'					=>	false
			),
		) 
	);
	register_post_type( 'person',
		array(
			'labels' => array(
				'name' => __( 'People' ),
				'singular_name' => __( 'Person' ),
				'add_new_item' => __( 'Add New Person' ),
				'edit_item' => __( 'Edit Person' )
			),
		'public' => true,
		'has_archive' => true,
		'show_in_nav_menus' => false,
		'menu_position' => 19,
		'menu_icon' => 'dashicons-id',
		'supports' => array('title','editor','thumbnail','shortlinks'),
		'rewrite' => array( 'slug' => 'people', 'with_front' => false  )
		)
	);
	add_rewrite_rule('^play-again/([^/]*)/([^/]*)/?',
			'index.php?pagename=play-again&one=$matches[1]&two=$matches[2]','top');
	add_rewrite_rule('^play-again/([^/]*)/?','index.php?pagename=play-again&one=$matches[1]','top');
	
	add_rewrite_tag('%one%','([^&]+)');
	add_rewrite_tag('%two%','([^&]+)');
	
	$event_structure = '/events/%eyear%/%event%/';
	add_rewrite_tag("%event%", '(.?.+?)', "event=");
	add_rewrite_tag('%eyear%','([\d{4}]+)');
	add_permastruct('event', $event_structure, array(
		'with_front' => false,
		'ep_mask' => EP_EVENT,
		'paged' => false,
		'feed' => false,
		'endpoints' => true));
	add_rewrite_endpoint( 'speakers', EP_EVENT );
	add_rewrite_rule('([^/]*)', 'index.php?post_type=post&name=$matches[1]', 'bottom');
}
add_action( 'init', 'create_post_types' );

add_action('parse_request', 'one_parse_request');
function one_parse_request($wp) {
    if (array_key_exists('one', $wp->query_vars) && $wp->query_vars['one'] != '') {
        $args = array(
			'posts_per_page' => 1,
			'post_type' => 'presentation',
			'meta_key' => 'presentation_hash',
			'meta_query' => array(
				array(
					'key'     => 'presentation_hash',
					'value'   => $wp->query_vars['one'],
					'compare' => '=',
				),
			)
		);
        $redirect_to_post = get_posts($args);
        foreach($redirect_to_post as $p) {
            $link = get_permalink($p->ID);
            wp_redirect( $link , 301 ); 
            exit;
        }
    }
}

function p2p_connections() {
	p2p_register_connection_type( array(
		'name' => 'presentation_to_event',
		'from' => 'presentation',
		'to' => 'event'
	) );
	
	p2p_register_connection_type( array(
		'name' => 'presentation_to_person',
		'from' => 'presentation',
		'to' => 'person'
	) );
	p2p_register_connection_type( array(
		'name' => 'presentation_to_advert',
		'from' => 'presentation',
		'to' => 'advert'
	) );
	p2p_register_connection_type( array(
		'name' => 'event_to_advert',
		'from' => 'event',
		'to' => 'advert'
	) );
}
add_action('p2p_init', 'p2p_connections');

function share_in_posts($sharing_disabled) {
	global $post;
	return $sharing_disabled || (
			$post->post_type == 'advert' || 
			$post->post_type == 'booth' ||
			$post->post_type == 'presentation' ||
			$post->post_type == 'event' ||
			$post->post_type == 'person' );
}

// add_filter('addtoany_sharing_disabled', 'share_in_posts');

function sort_custom_posts($q) {
	if ($q->get('post_type') == 'booth') {
		$q->set( 'order', 'ASC' );
	} else if ($q->get('post_type') == 'advert') {
		$q->set( 'order', 'ASC' );
	}
	if ($q->get('post_type') == 'person') {
		$q->set('name', str_replace(array('%20',' '),'-',strtolower($q->get('name'))));
		$q->set('person', str_replace(array('%20',' '),'-',strtolower($q->get('person'))));
	}
}
add_action( 'pre_get_posts', 'sort_custom_posts' );


function custom_glance_items() {
	$glancer = new Gamajo_Dashboard_Glancer;
	$glancer->add( array(
		'advert',
		'booth',
		'event',
		'presentation',
		'person'
	) );
}
add_action( 'dashboard_glance_items', 'custom_glance_items' );

?>
