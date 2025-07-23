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

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'newmr' ),
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Sidebar', 'newmr' ),
				'id'            => 'sidebar-1',
				'before_widget' => '<section class="mb-6">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="text-xl font-semibold mb-2">',
				'after_title'   => '</h2>',
			)
		);
}
add_action( 'after_setup_theme', 'newmr_theme_setup' );

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
 * Shortcode to list events for the events page.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function newmr_events_shortcode( $atts ) {
		$atts = shortcode_atts( array( 'status' => 'upcoming' ), $atts );

		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => -1,
			'meta_key'       => 'event_date_to', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
		);

		switch ( $atts['status'] ) {
			case 'open':
						$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						array(
							'key'   => 'event_events_page',
							'value' => 'yes',
						),
						array(
							'key'   => 'event_date_from',
							'value' => '',
						),
						array(
							'key'   => 'event_date_to',
							'value' => '',
						),
						);
				break;
			case 'past':
					$args['order']          = 'DESC';
						$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						array(
							'key'   => 'event_events_page',
							'value' => 'yes',
						),
						array(
							'key'     => 'event_date_to',
							'value'   => time(),
							'compare' => '<',
						),
						array(
							'key'     => 'event_date_to',
							'value'   => '',
							'compare' => '!=',
						),
						);
				break;
			default:
						$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						array(
							'key'   => 'event_events_page',
							'value' => 'yes',
						),
						array(
							'key'     => 'event_date_to',
							'value'   => time(),
							'compare' => '>=',
						),
						);
		}

		$query = new WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) {
				echo '<ul class="space-y-2">';
			while ( $query->have_posts() ) {
					$query->the_post();
					echo '<li><a class="text-blue-600 hover:underline" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
			}
				echo '</ul>';
		}
		wp_reset_postdata();

		return ob_get_clean();
}
add_shortcode( 'newmr_events', 'newmr_events_shortcode' );

/**
 * Shortcode to output Play Again tables.
 *
 * @return string
 */
function newmr_play_again_shortcode() {
		$events = new WP_Query(
			array(
				'post_type'      => 'event',
				'posts_per_page' => -1,
				'meta_key'       => 'event_date_to', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'   => 'event_play_again',
						'value' => 'yes',
					),
				),
			)
		);

		ob_start();
	while ( $events->have_posts() ) {
			$events->the_post();
			echo '<h2 class="text-2xl font-semibold mt-8">' . esc_html( get_the_title() ) . '</h2>';

			$connected = new WP_Query(
				array(
					'connected_type'  => 'presentation_to_event',
					'connected_items' => get_post(),
					'nopaging'        => true,
				)
			);

		if ( $connected->have_posts() ) {
			echo '<table class="min-w-full border-collapse my-4">';
			echo '<thead><tr><th class="px-2 py-1 text-left">Speaker</th><th class="px-2 py-1 text-left">Title</th><th class="px-2 py-1">Video</th><th class="px-2 py-1">Slides</th></tr></thead><tbody>';
			while ( $connected->have_posts() ) {
					$connected->the_post();

					$people = new WP_Query(
						array(
							'connected_type'  => 'presentation_to_person',
							'connected_items' => get_post(),
							'nopaging'        => true,
						)
					);

					$speakers = array();
				while ( $people->have_posts() ) {
					$people->the_post();
					$speakers[] = get_the_title();
				}
					wp_reset_postdata();

					$slides = get_post_meta( get_the_ID(), 'presentation_slides', true );
					echo '<tr class="border-t">';
					echo '<td class="px-2 py-1">' . esc_html( implode( ', ', $speakers ) ) . '</td>';
					echo '<td class="px-2 py-1">' . esc_html( get_the_title() ) . '</td>';
					echo '<td class="px-2 py-1"><a class="text-blue-600 hover:underline" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Watch', 'newmr' ) . '</a></td>';
					echo '<td class="px-2 py-1">';
				if ( $slides ) {
					echo '<a class="text-blue-600 hover:underline" href="' . esc_url( $slides ) . '">' . esc_html__( 'Download', 'newmr' ) . '</a>';
				}
					echo '</td></tr>';
			}
			echo '</tbody></table>';
			wp_reset_postdata();
		}
	}
		wp_reset_postdata();

		return ob_get_clean();
}
add_shortcode( 'newmr_play_again', 'newmr_play_again_shortcode' );

/**
 * Shortcode to list presenters for a presentation.
 *
 * @return string
 */
function newmr_presenters_shortcode() {
	if ( 'presentation' !== get_post_type() ) {
			return '';
	}

		$people = new WP_Query(
			array(
				'connected_type'  => 'presentation_to_person',
				'connected_items' => get_post(),
				'nopaging'        => true,
			)
		);

		ob_start();
	if ( $people->have_posts() ) {
			echo '<div class="space-y-4">';
		while ( $people->have_posts() ) {
				$people->the_post();
				echo '<div class="flex items-center space-x-2">';
			if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => 'w-10 h-10 object-cover rounded-full' ) );
			}
				echo '<div><p class="font-semibold">' . esc_html( get_the_title() ) . '</p>';
				$company = get_post_meta( get_the_ID(), 'person_company', true );
			if ( $company ) {
					echo '<p class="text-sm text-gray-600">' . esc_html( $company ) . '</p>';
			}
				echo '</div></div>';
		}
			echo '</div>';
	}
		wp_reset_postdata();

		return ob_get_clean();
}
add_shortcode( 'newmr_presenters', 'newmr_presenters_shortcode' );
