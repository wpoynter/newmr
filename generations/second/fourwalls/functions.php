<?php

require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/theme-settings.php';

require get_template_directory() . '/widgets/adverts.php';
require get_template_directory() . '/widgets/adverts-v2.php';

add_action('init','add_get_val');
function add_get_val() { 
    global $wp; 
    $wp->add_query_var('dev'); 
}

 function ww_load_dashicons(){
     wp_enqueue_style('dashicons');
 }
 add_action('wp_enqueue_scripts', 'ww_load_dashicons');

function scripts_and_styles() {
	wp_dequeue_style('genericons');
	wp_enqueue_style( 'fourwalls-fonts', fourwalls_fonts_url(), array(), null );
	wp_enqueue_script( 'jquery-dotdotdot', get_template_directory_uri() . '/js/jquery.dotdotdot.min.js', array( 'jquery' ), '2014-06-06', true );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'jquery' ), '2014-06-14', true );
	wp_enqueue_script( 'fourwalls-func-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2013-02-23', true );
	wp_enqueue_script( 'fourwalls-anim-script', get_template_directory_uri() . '/js/animation.js', array('jquery', 'jquery-ui-core', 'jquery-effects-core'), '2014-02-24', true );
	wp_enqueue_script( 'fourwalls-pos-script', get_template_directory_uri() . '/js/positioning.js', array('jquery'), '2014-03-02', true );
	wp_enqueue_script( 'fourwalls-link-script', get_template_directory_uri() . '/js/link.js', array('jquery'), '2014-03-03', true );
	// Loads our main stylesheet.
	if ( get_query_var('dev') ) {
	    wp_enqueue_style( 'fourwalls-style', get_stylesheet_directory_uri() . '/style-dev.css', array(), '2024-02-09' );
	} else {
    	wp_enqueue_style( 'fourwalls-style', get_stylesheet_uri(), array(), '2014-02-21' );
	}
	wp_enqueue_style( 'genericons', get_stylesheet_directory_uri() . '/fonts/genericons.css', array(), '3.0.3' );
}
add_action( 'wp_enqueue_scripts', 'scripts_and_styles' );

function add_admin_scripts() {
	wp_enqueue_style('jquery-ui-stylesheet', '//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script( 
			'fourwalls-admin-script', 
			get_template_directory_uri() . '/js/admin.js', 
			array('jquery','jquery-effects-core','jquery-ui-datepicker'), 
			'2014-02-23', 
			true );
	wp_enqueue_style( 'fourwalls-admin-style', get_stylesheet_directory_uri() . '/admin/admin.css', array(), '2014-09-29' );
}

add_action('admin_enqueue_scripts', 'add_admin_scripts',100);

function fourwalls_setup() {
	
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', fourwalls_fonts_url() ) );
	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'twentythirteen' ) );

	add_image_size('Booth',300,250,true);
	add_image_size('Advert',230,115,true);
	add_image_size('Event',220,200,true);
	
	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 480, 210, true );
}
add_action( 'after_setup_theme', 'fourwalls_setup' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function fourwalls_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'fourwalls' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'fourwalls_wp_title', 10, 2 );

function fourwalls_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'fourwalls' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'fourwalls' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Register one widget areas.
 *
 * @return void
 */
function fourwalls_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Widget Area', 'fourwalls' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'fourwalls' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'fourwalls_widgets_init' );

add_action('edit_form_after_editor', 'extra_editor_page');

function extra_editor_page() {
	
	global $post;
	if( 'presentation' == $post->post_type ) {
		$presentation_synopsis = get_post_meta($post->ID, 'presentation_synopsis', true);
		echo '<h2>Synopsis</h2>';
		echo wp_editor( 
				$presentation_synopsis, 
				'presentation_synopsis', 
				array( 
					'textarea_name' => 'presentation_synopsis' 
				) 
			);
	}
}

function add_meta_properties() {
    add_meta_box('booth_properties',
        'Booth Properties',
        'display_booth_meta_box',
        'booth', 'normal', 'high'
    );
	add_meta_box('advert_properties',
        'Advert Properties',
        'display_advert_meta_box',
        'advert', 'normal', 'high'
    );
	add_meta_box('event_properties',
        'Event Properties',
        'display_event_meta_box',
        'event', 'normal', 'high'
    );
	add_meta_box('presentation_properties',
        'Presentation Properties',
        'display_presentation_meta_box',
        'presentation', 'normal', 'high'
    );
	add_meta_box('person_properties',
        'Person Properties',
        'display_person_meta_box',
        'person', 'normal', 'high'
    );
}
add_action('admin_init', 'add_meta_properties');

function display_booth_meta_box($booth) {
	$booth_link = esc_html(get_post_meta($booth->ID, 'booth_link', true));
    ?>
    <table>
        <tr>
            <td style="width: 150px">Link</td>
            <td><input type="text" size="80" name="booth_link" value="<?php echo $booth_link; ?>" /></td>
        </tr>
    </table>
    <?php
}

function display_advert_meta_box($advert) {
	$advert_link = esc_html(get_post_meta($advert->ID, 'advert_link', true));
	$advert_site = esc_html(get_post_meta($advert->ID, 'advert_site', true));
    ?>
    <table>
        <tr>
            <td style="width: 150px">Link</td>
            <td><input type="text" size="80" name="advert_link" value="<?php echo $advert_link; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Site Wide</td>
            <td>
				<select style="width: 140px" name="advert_site">
					<option value="yes" <?php echo selected('yes', $advert_site); ?> >Yes</option>
					<option value="no" <?php echo selected('no', $advert_site); ?> >No</option>
                </select>
			</td>
        </tr>
    </table>
    <?php
}

function display_event_meta_box($event) {
	$event_pdf = esc_html(get_post_meta($event->ID, 'event_pdf', true));
	$event_free = esc_html(get_post_meta($event->ID, 'event_free', true));
	$event_date_from = esc_html(get_post_meta($event->ID, 'event_date_from', true));
	$event_date_to = esc_html(get_post_meta($event->ID, 'event_date_to', true));
	$event_events_page = esc_html(get_post_meta($event->ID, 'event_events_page', true));
	$event_play_again = esc_html(get_post_meta($event->ID, 'event_play_again', true));
	$event_external = esc_html(get_post_meta($event->ID, 'event_external', true));
	$display_date_from =($event_date_from == "") ? "" : date("d-m-Y", $event_date_from);
	$display_date_to =($event_date_to == "") ? "" : date("d-m-Y", $event_date_to);
    ?>
    <table>
        <tr>
            <td style="width: 150px">PDF URI</td>
            <td><input id="event_pdf" type="text" size="80" name="event_pdf" value="<?php echo $event_pdf; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Site Wide</td>
            <td>
				<select style="width: 140px" name="event_free">
					<option value="yes" <?php echo selected('yes', $event_free); ?> >Yes</option>
					<option value="no" <?php echo selected('no', $event_free); ?> >No</option>
                </select>
			</td>
        </tr>
		<tr>
			<td style="width:150px">Date From</td>
			<td>
				<input type="text" size="80" name="event_date_from" class="date-input" value="<?php echo $display_date_from; ?>" />
			</td>
		</tr>
		<tr>
			<td style="width:150px">Date To</td>
			<td>
				<input type="text" size="80" name="event_date_to" class="date-input" value="<?php echo $display_date_to; ?>" />
			</td>
		</tr>
		<tr>
            <td style="width: 150px">Show on Events Page</td>
            <td>
				<select style="width: 140px" name="event_events_page">
					<option value="yes" <?php echo selected('yes', $event_events_page); ?> >Yes</option>
					<option value="no" <?php echo selected('no', $event_events_page); ?> >No</option>
                </select>
			</td>
        </tr>
		<tr>
            <td style="width: 150px">Show on Play Again</td>
            <td>
				<select style="width: 140px" name="event_play_again">
					<option value="yes" <?php echo selected('yes', $event_play_again); ?> >Yes</option>
					<option value="no" <?php echo selected('no', $event_play_again); ?> >No</option>
                </select>
			</td>
        </tr>
		<tr>
            <td style="width: 150px">External Link</td>
            <td><input type="text" size="80" name="event_external" value="<?php echo $event_external; ?>" /></td>
        </tr>
    </table>
    <?php
}

function display_presentation_meta_box($presentation) {
	$presentation_slides = esc_html(get_post_meta($presentation->ID, 'presentation_slides', true));
	$presentation_hash = esc_html(get_post_meta($presentation->ID, 'presentation_hash', true));
	$presentation_session = esc_html(get_post_meta($presentation->ID, 'presentation_session', true));
	$presentation_order = esc_html(get_post_meta($presentation->ID, 'presentation_order', true));
	$presentation_mp4file = esc_html(get_post_meta($presentation->ID, 'presentation_mp4file', true));
	$presentation_webmfile = esc_html(get_post_meta($presentation->ID, 'presentation_webmfile', true));
	$presentation_ogvfile = esc_html(get_post_meta($presentation->ID, 'presentation_ogvfile', true));
	$presentation_splash = esc_html(get_post_meta($presentation->ID, 'presentation_splash', true));
	$presentation_screencast_downloads = esc_html(get_post_meta($presentation->ID, 'presentation_screencast_downloads', true));
	$presentation_screencast_plays = esc_html(get_post_meta($presentation->ID, 'presentation_screencast_plays', true));
	$presentation_event_id = esc_html(get_post_meta($presentation->ID, 'presentation_event_id', true));
	$presentation_speaker_1 = esc_html(get_post_meta($presentation->ID, 'presentation_speaker_1', true));
	$presentation_speaker_2 = esc_html(get_post_meta($presentation->ID, 'presentation_speaker_2', true));
    ?>
    <table>
        <tr>
            <td style="width: 150px">Slides</td>
            <td><input type="text" size="80" name="presentation_slides" value="<?php echo $presentation_slides; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Session</td>
            <td><input type="text" size="80" name="presentation_session" value="<?php echo $presentation_session; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Session Order</td>
            <td><input type="text" size="80" name="presentation_order" value="<?php echo $presentation_order; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">MP4 File</td>
            <td><input type="text" size="80" name="presentation_mp4file" value="<?php echo $presentation_mp4file; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">WebM File</td>
            <td><input type="text" size="80" name="presentation_webmfile" value="<?php echo $presentation_webmfile; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">OGV File</td>
            <td><input type="text" size="80" name="presentation_ogvfile" value="<?php echo $presentation_ogvfile; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Splash</td>
            <td><input type="text" size="80" name="presentation_splash" value="<?php echo $presentation_splash; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Screencast Downloads</td>
            <td><input type="text" disabled="disabled" size="80" name="presentation_screencast_downloads" value="<?php echo $presentation_screencast_downloads; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Screencast Plays</td>
            <td><input type="text" disabled="disabled" size="80" name="presentation_screencast_plays" value="<?php echo $presentation_screencast_plays; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Old Hash</td>
            <td><input type="text" disabled="disabled" size="80" name="presentation_hash" value="<?php echo $presentation_hash; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Old Event ID</td>
            <td><input type="text" disabled="disabled" size="80" name="presentation_event_id" value="<?php echo $presentation_event_id; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Old Speaker 1 ID</td>
            <td><input type="text" disabled="disabled" size="80" name="presentation_speaker_1" value="<?php echo $presentation_speaker_1; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Old Speaker 2 ID</td>
            <td><input type="text" disabled="disabled" size="80" name="presentation_speaker_2" value="<?php echo $presentation_speaker_2; ?>" /></td>
        </tr>
    </table>
    <?php
}

function display_person_meta_box($person) {
	$person_company = esc_html(get_post_meta($person->ID, 'person_company', true));
	$person_country = esc_html(get_post_meta($person->ID, 'person_country', true));
    ?>
    <table>
        <tr>
            <td style="width: 150px">Company</td>
            <td><input type="text" size="80" name="person_company" value="<?php echo $person_company; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 150px">Country</td>
            <td><input type="text" size="80" name="person_country" value="<?php echo $person_country; ?>" /></td>
        </tr>
    </table>
    <?php
}

function add_fields($post_id, $post) {
    if ( $post->post_type == 'booth' ) {
		if ( isset( $_POST['booth_link'] ) ) {
            update_post_meta( $post_id, 'booth_link', $_POST['booth_link'] );
        }
    } else if ( $post->post_type == 'advert' ) {
		if ( isset( $_POST['advert_link'] ) ) {
            update_post_meta( $post_id, 'advert_link', $_POST['advert_link'] );
        }
		if ( isset( $_POST['advert_site'] ) ) {
            update_post_meta( $post_id, 'advert_site', $_POST['advert_site'] );
        }
    } else if ( $post->post_type == 'event' ) {
		if ( isset( $_POST['event_summary'] ) ) {
            update_post_meta( $post_id, 'event_summary', $_POST['event_summary'] );
        }
		if ( isset( $_POST['event_pdf'] ) ) {
            update_post_meta( $post_id, 'event_pdf', $_POST['event_pdf'] );
        }
		if ( isset( $_POST['event_free'] ) ) {
            update_post_meta( $post_id, 'event_free', $_POST['event_free'] );
        }
		if (isset($_POST['event_date_from']) && strlen($_POST['event_date_from']) > 1) {
			$formatted_date = $_POST['event_date_from'];
			$date_pieces = explode('-', $formatted_date);
            update_post_meta( $post_id, 'event_date_from', mktime(0, 0, 0, $date_pieces[1], $date_pieces[0], $date_pieces[2]) );
        }
		if ((isset($_POST['event_date_from']) || isset($_POST['event_date_to']))  && strlen($_POST['event_date_from']) > 1) {
			if (isset($_POST['event_date_to']) && strlen($_POST['event_date_to']) > 1) {
				$formatted_date = $_POST['event_date_to'];
				$date_pieces = explode('-', $formatted_date);
				update_post_meta( $post_id, 'event_date_to', mktime(0, 0, 0, $date_pieces[1], $date_pieces[0], $date_pieces[2]) );
			} else {
				$formatted_date = $_POST['event_date_from'];
				$date_pieces = explode('-', $formatted_date);
				update_post_meta( $post_id, 'event_date_to', mktime(0, 0, 0, $date_pieces[1], $date_pieces[0], $date_pieces[2]) );
			}
        }
		if ( isset( $_POST['event_events_page'] ) ) {
            update_post_meta( $post_id, 'event_events_page', $_POST['event_events_page'] );
        }
		if ( isset( $_POST['event_play_again'] ) ) {
            update_post_meta( $post_id, 'event_play_again', $_POST['event_play_again'] );
        }
		if ( isset( $_POST['event_external'] ) ) {
            update_post_meta( $post_id, 'event_external', $_POST['event_external'] );
        }
    } else if ( $post->post_type == 'presentation' ) {
		if ( isset( $_POST['presentation_slides'] ) ) {
            update_post_meta( $post_id, 'presentation_slides', $_POST['presentation_slides'] );
        }
		if ( isset( $_POST['presentation_hash'] ) ) {
            update_post_meta( $post_id, 'presentation_hash', $_POST['presentation_hash'] );
        }
		if ( isset( $_POST['presentation_session'] ) ) {
            update_post_meta( $post_id, 'presentation_session', $_POST['presentation_session'] );
        }
		if ( isset( $_POST['presentation_order'] ) ) {
            update_post_meta( $post_id, 'presentation_order', $_POST['presentation_order'] );
        }
		if ( isset( $_POST['presentation_mp4file'] ) ) {
            update_post_meta( $post_id, 'presentation_mp4file', $_POST['presentation_mp4file'] );
        }
		if ( isset( $_POST['presentation_webmfile'] ) ) {
            update_post_meta( $post_id, 'presentation_webmfile', $_POST['presentation_webmfile'] );
        }
		if ( isset( $_POST['presentation_ogvfile'] ) ) {
            update_post_meta( $post_id, 'presentation_ogvfile', $_POST['presentation_ogvfile'] );
        }
		if ( isset( $_POST['presentation_splash'] ) ) {
            update_post_meta( $post_id, 'presentation_splash', $_POST['presentation_splash'] );
        }
		if ( isset( $_POST['presentation_screencast_downloads'] ) ) {
            update_post_meta( $post_id, 'presentation_screencast_downloads', $_POST['presentation_screencast_downloads'] );
        }
		if ( isset( $_POST['presentation_screencast_plays'] ) ) {
            update_post_meta( $post_id, 'presentation_screencast_plays', $_POST['presentation_screencast_plays'] );
        }
		if ( isset( $_POST['presentation_event_id'] ) ) {
            update_post_meta( $post_id, 'presentation_event_id', $_POST['presentation_event_id'] );
        }
		if ( isset( $_POST['presentation_speaker_1'] ) ) {
            update_post_meta( $post_id, 'presentation_speaker_1', $_POST['presentation_speaker_1'] );
        }
		if ( isset( $_POST['presentation_speaker_2'] ) ) {
            update_post_meta( $post_id, 'presentation_speaker_2', $_POST['presentation_speaker_2'] );
        }
		if ( isset( $_POST['presentation_synopsis'] ) ) {
            update_post_meta( $post_id, 'presentation_synopsis', $_POST['presentation_synopsis'] );
        }
    } else if ( $post->post_type == 'person' ) {
		if ( isset( $_POST['person_company'] ) ) {
            update_post_meta( $post_id, 'person_company', $_POST['person_company'] );
        }
		if ( isset( $_POST['person_country'] ) ) {
            update_post_meta( $post_id, 'person_country', $_POST['person_country'] );
        }
    }
}
add_action( 'save_post', 'add_fields', 10, 2 );

function my_insert_custom_image_sizes( $sizes ) {
	global $_wp_additional_image_sizes;
	if ( empty($_wp_additional_image_sizes) )
		return $sizes;

	foreach ( $_wp_additional_image_sizes as $id => $data ) {
		if ( !isset($sizes[$id]) )
			$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
	}

	return $sizes;
}
add_filter( 'image_size_names_choose', 'my_insert_custom_image_sizes' );

function strip_advert_filter($content) {
	if (get_post_type() != 'advert')
		return $content;
	$stripped = str_replace(array("\n", "\t", "\r"), '', $content);

	if (substr($stripped, 0, 3) == '<p>' && substr($stripped, -4) == '</p>') {
		return substr($stripped, 3, -4);
	} else { 
		return $stripped;
	}
}
add_filter( 'the_content', 'strip_advert_filter' );


function pres_unique_slug ($slug, $post_ID, $post_status, $post_type, $post_parent) {
	global $wpdb;
	
	if ($post_type == 'presentation') {
		$check_sql = "SELECT post_name FROM $wpdb->posts WHERE ID = %d LIMIT 1";
		$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $post_ID ) );
		if ($post_name_check === NULL) {
			$hash = "";
			srand(microtime(true));
			while (true) {
				$hash = substr(md5(rand()),0,8);
				$check_sql = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s LIMIT 1";
				$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $hash ) );
				if ($post_name_check === NULL) return $hash;
			}
		} else
			return $post_name_check;
	} else {
		return $slug;
	}
}
add_filter('wp_unique_post_slug', 'pres_unique_slug',10,5);

function donate_box() {
//	remove_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);
	echo apply_filters(
		'the_content', 
		stripslashes(get_option('fourwalls_front_middle_left'))
	);
//	add_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);
}

function about_newmr_box() {
//	remove_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);
	echo apply_filters(
		'the_content', 
		stripslashes(get_option('fourwalls_front_bottom_right'))
	);
//	add_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);
}

function left_footer_link() { 
	$name = get_option('fourwalls_left_footer_link');
	if ($name == '') return;
	$query = new WP_Query('pagename=' . $name);
	if ($query->post_count > 0):
		$query->the_post();
	?>
<a href="<?php the_permalink(); ?>" class="left-link"><?php the_title(); ?></a>
<?php
	endif;
}

function right_footer_link() {
	$name = get_option('fourwalls_right_footer_link');
	if ($name == '') return;
	$query = new WP_Query('pagename=' . $name);
	if ($query->post_count > 0):
		$query->the_post();
	?>
<a href="<?php the_permalink(); ?>" class="right-link"><?php the_title(); ?></a>
<?php
	endif;
	
}

function fourwalls_head() {
	if (is_front_page()):
	?>
	<style>
	/*@media (max-width: 999px) {*/

	/*	html {*/
	/*		min-width: 750px;*/
	/*	}*/

	/*	#box-2,*/
	/*	#box-4,*/
	/*	#box-6 {*/
	/*		display: none;*/
	/*	}*/

 	/*	#box-1 {*/
	/*		margin: 0 auto;*/
	/*		float: none;*/
	/*	}*/

	/*	#box-3, #box-5 {*/
	/*		margin-left: 40px;*/
	/*	}*/

	/*	#box-7 {*/
	/*		width: 710px;*/
	/*		height: auto;*/
	/*		margin-left: auto;*/
	/*		margin-right: auto;*/
	/*		float: none;*/
	/*	}*/

	/*	.entry-content {*/
	/*		width: 750px;*/
	/*		margin: 0 auto;*/
	/*	}*/

	/*}*/
	</style>

	<?php
	endif;
	?>
	<!--[if IE]>
	<style>a img {border: 0; outline: 0}</style>
	<![endif]-->
	<?php
}

function custom_blog_excerpt_length( $length ) {
	return 40;
}
add_filter('excerpt_length', 'custom_blog_excerpt_length', 998);

// Alter search posts per page
function pd_search_posts_per_page($query) {
    if ( $query->is_search ) {
        $query->set( 'posts_per_page', '-1' );
    }
    return $query;
}
add_filter( 'pre_get_posts','pd_search_posts_per_page' );

function posts_per_page( $query ) {
	if (isset($query->query_vars['posts_per_page'])) return $query;
	if (!isset($query->query_vars['post_type'])) return $query;
	switch ($query->query_vars['post_type']) {
        case 'person':
            $query->query_vars['posts_per_page'] = -1;
			$query->query_vars['orderby'] = 'title';
			$query->query_vars['order'] = 'ASC';
            break;
		case 'booth':
			$query->query_vars['posts_per_page'] = -1;
        default:
            break;
    }
    return $query;
}

if(!is_admin()) {
    add_filter('pre_get_posts', 'posts_per_page');
}

function fp5_has_shortcode( $has_shortcode ) {
	return (get_post_type() == 'presentation' || is_front_page() || $has_shortcode);
}
add_filter( 'fp5_filter_has_shortcode', 'fp5_has_shortcode' ); 

function paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'fourwalls' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'fourwalls' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

add_action( 'wp_head', 'wpse_70701_author_image' );

function wpse_70701_author_image() {
    if ( get_post_type() == 'person' ) {
       echo '<meta property="og:image" content="' . get_the_post_thumbnail_url(null, 'full') . '" /><meta property="og:title" content="' . get_the_title() . ' | NewMR" /><meta property="og:description" content="Visit NewMR to read my biography and to watch recordings of all my presentations at NewMR events" />';
    }
    else {
        // set the default fallback image (you may want to omit this section)
       echo '<meta property="og:image" content="' . get_site_icon_url() . '" />';
    }
}

?>
