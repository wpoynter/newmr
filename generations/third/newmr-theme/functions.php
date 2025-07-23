<?php
/**
 * Theme bootstrap file.
 *
 * @package NewMR
 */

/**
 * Theme functions and definitions
 */
function newmr_theme_setup() {
	add_theme_support( 'wp-block-styles' );
}

add_action( 'after_setup_theme', 'newmr_theme_setup' );

/**
 * Enqueue the compiled Tailwind CSS if present.
 */
function newmr_enqueue_assets() {
	$css = get_theme_file_path( 'dist/style.css' );
	if ( file_exists( $css ) ) {
		wp_enqueue_style(
			'newmr-theme',
			get_theme_file_uri( 'dist/style.css' ),
			array(),
			filemtime( $css )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'newmr_enqueue_assets' );

/**
 * Output the donate box content.
 */
function donate_box() {
		echo apply_filters( 'the_content', stripslashes( get_option( 'newmr_front_middle_left' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Output the About NewMR box content.
 */
function about_newmr_box() {
		echo apply_filters( 'the_content', stripslashes( get_option( 'newmr_front_bottom_right' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display link selected for the left footer.
 */
function left_footer_link() {
		$name = get_option( 'newmr_left_footer_link' );
	if ( '' === $name ) {
			return;
	}
		$query = new WP_Query( 'pagename=' . $name );
	if ( $query->have_posts() ) {
			$query->the_post();
			echo '<a href="' . esc_url( get_permalink() ) . '" class="left-link">' . esc_html( get_the_title() ) . '</a>';
			wp_reset_postdata();
	}
}

/**
 * Display link selected for the right footer.
 */
function right_footer_link() {
		$name = get_option( 'newmr_right_footer_link' );
	if ( '' === $name ) {
			return;
	}
		$query = new WP_Query( 'pagename=' . $name );
	if ( $query->have_posts() ) {
			$query->the_post();
			echo '<a href="' . esc_url( get_permalink() ) . '" class="right-link">' . esc_html( get_the_title() ) . '</a>';
			wp_reset_postdata();
	}
}

/**
 * Return the slug of the selected featured video.
 *
 * @return string
 */
function featured_video_slug() {
		return get_option( 'newmr_featured_video', '' );
}

/**
 * Output event lists for the Events page.
 *
 * Displays upcoming, open, and past events using the excerpt templates.
 *
 * @return string Event listings markup.
 */
function newmr_events_page_shortcode() {
		$today = mktime( 23, 59, 59 );
		ob_start();
	// Container wrapper.
		echo '<div class="space-y-12">';

		$up_query = new WP_Query(
			array(
				'post_type'      => 'event',
				'post_parent'    => 0,
				'posts_per_page' => -1,
				'meta_key'       => 'event_date_to',
				'orderby'        => 'meta_value_num',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => 'event_events_page',
						'value'   => 'yes',
						'compare' => '=',
					),
					array(
						'key'     => 'event_date_to',
						'value'   => $today,
						'compare' => '>=',
					),
				),
			)
		);

	if ( $up_query->have_posts() ) {
			echo '<section class="space-y-6">';
			echo '<h2 class="text-2xl font-bold">' . esc_html__( 'Upcoming Events', 'newmr' ) . '</h2>';
		while ( $up_query->have_posts() ) {
				$up_query->the_post();
				get_template_part( 'excerpt', get_post_type() );
		}
			echo '</section>';
			wp_reset_postdata();
	}

		$open_query = new WP_Query(
			array(
				'post_type'      => 'event',
				'post_parent'    => 0,
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => 'event_events_page',
						'value'   => 'yes',
						'compare' => '=',
					),
					array(
						'key'     => 'event_date_from',
						'value'   => '',
						'compare' => '=',
					),
					array(
						'key'     => 'event_date_to',
						'value'   => '',
						'compare' => '=',
					),
				),
			)
		);

	if ( $open_query->have_posts() ) {
			echo '<section class="space-y-6">';
			echo '<h2 class="text-2xl font-bold">' . esc_html__( 'Open Events', 'newmr' ) . '</h2>';
		while ( $open_query->have_posts() ) {
				$open_query->the_post();
				get_template_part( 'excerpt', get_post_type() );
		}
			echo '</section>';
			wp_reset_postdata();
	}

		$down_query = new WP_Query(
			array(
				'post_type'      => 'event',
				'post_parent'    => 0,
				'posts_per_page' => -1,
				'meta_key'       => 'event_date_to',
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
				'meta_query'     => array(
					array(
						'key'     => 'event_events_page',
						'value'   => 'yes',
						'compare' => '=',
					),
					array(
						'key'     => 'event_date_to',
						'value'   => $today,
						'compare' => '<',
					),
					array(
						'key'     => 'event_date_to',
						'value'   => '',
						'compare' => '!=',
					),
				),
			)
		);

	if ( $down_query->have_posts() ) {
			echo '<section class="space-y-6">';
			$years = array();
		while ( $down_query->have_posts() ) {
				$down_query->the_post();
				$datestring = get_post_meta( get_the_ID(), 'event_date_from', true );
				$year       = gmdate( 'Y', $datestring );
			if ( ! in_array( $year, $years, true ) ) {
					$years[] = $year;
					echo '<h2 class="text-2xl font-bold">' . esc_html( $year ) . '</h2>';
			}
				get_template_part( 'excerpt', get_post_type() );
		}
			echo '</section>';
			wp_reset_postdata();
	}

		echo '</div>';
		return ob_get_clean();
}
add_shortcode( 'events_page', 'newmr_events_page_shortcode' );

/**
 * Register helper shortcodes so block templates can invoke theme functions.
 */
add_shortcode( 'donate_box', 'donate_box' );
add_shortcode( 'about_newmr_box', 'about_newmr_box' );
add_shortcode( 'left_footer_link', 'left_footer_link' );
add_shortcode( 'right_footer_link', 'right_footer_link' );

/**
 * Shortcode to output the person's company.
 *
 * @return string HTML markup for the company field.
 */
function newmr_person_company_shortcode() {
		$company = get_post_meta( get_the_ID(), 'person_company', true );
	if ( ! $company ) {
			return '';
	}

		return '<span class="block text-sm text-gray-500">' . esc_html( $company ) . '</span>';
}
add_shortcode( 'person_company', 'newmr_person_company_shortcode' );

/**
 * Shortcode to output the person's country.
 *
 * @return string HTML markup for the country field.
 */
function newmr_person_country_shortcode() {
		$country = get_post_meta( get_the_ID(), 'person_country', true );
	if ( ! $country ) {
			return '';
	}

		return '<span class="block text-sm text-gray-500">' . esc_html( $country ) . '</span>';
}
add_shortcode( 'person_country', 'newmr_person_country_shortcode' );
 * Output the current person's company meta value.
 *
 * @return string
 */
function newmr_person_company() {
	return '<span class="block text-sm text-gray-500">' . esc_html( get_post_meta( get_the_ID(), 'person_company', true ) ) . '</span>';
}

/**
 * Output the current person's country meta value.
 *
 * @return string
 */
function newmr_person_country() {
	return '<span class="block text-sm text-gray-500">' . esc_html( get_post_meta( get_the_ID(), 'person_country', true ) ) . '</span>';
}

add_shortcode( 'person_company', 'newmr_person_company' );
add_shortcode( 'person_country', 'newmr_person_country' );

/**
 * Return formatted event date range based on meta fields.
 *
 * @return string Event dates HTML
 */
function newmr_event_dates() {
		$from = get_post_meta( get_the_ID(), 'event_date_from', true );
		$to   = get_post_meta( get_the_ID(), 'event_date_to', true );
	if ( strlen( $from ) < 1 ) {
			return '';
	}
	if ( $from === $to ) {
			$dates = date_i18n( 'jS F', $from );
	} elseif ( gmdate( 'F', $from ) === gmdate( 'F', $to ) ) {
			$dates = date_i18n( 'jS', $from ) . ' - ' . date_i18n( 'jS F', $to );
	} else {
			$dates = date_i18n( 'jS F', $from ) . ' - ' . date_i18n( 'jS F', $to );
	}
		return '<span class="event-dates">' . esc_html( $dates ) . '</span>';
}
add_shortcode( 'event_dates', 'newmr_event_dates' );

/**
 * Output a "Free" badge when the event_free meta equals "yes".
 *
 * @return string
 */
function newmr_free_badge() {
		$is_free = get_post_meta( get_the_ID(), 'event_free', true );
	if ( 'yes' === $is_free ) {
			return '<span class="free-badge text-green-600">' . esc_html__( 'Free', 'newmr' ) . '</span>';
	}
		return '';
}
add_shortcode( 'free_badge', 'newmr_free_badge' );
