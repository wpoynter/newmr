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
 * Register helper shortcodes so block templates can invoke theme functions.
 */
add_shortcode( 'donate_box', 'donate_box' );
add_shortcode( 'about_newmr_box', 'about_newmr_box' );
add_shortcode( 'left_footer_link', 'left_footer_link' );
add_shortcode( 'right_footer_link', 'right_footer_link' );

/**
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
