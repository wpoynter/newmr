<?php
/**
 * Shortcodes for NewMR.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Shortcodes' ) ) {
	/**
	 * Register shortcodes used by the NewMR project.
	 */
	class NewMR_Shortcodes {
		/**
		 * Setup shortcode registrations.
		 */
		public function __construct() {
			add_shortcode( 'events_page', array( $this, 'events_page_shortcode' ) );
			add_shortcode( 'donate_box', array( $this, 'donate_box' ) );
			add_shortcode( 'about_newmr_box', array( $this, 'about_newmr_box' ) );
			add_shortcode( 'left_footer_link', array( $this, 'left_footer_link' ) );
			add_shortcode( 'right_footer_link', array( $this, 'right_footer_link' ) );
			add_shortcode( 'person_company', array( $this, 'person_company_shortcode' ) );
			add_shortcode( 'person_country', array( $this, 'person_country_shortcode' ) );
			add_shortcode( 'person_company', array( $this, 'person_company' ) );
			add_shortcode( 'person_country', array( $this, 'person_country' ) );
			add_shortcode( 'event_dates', array( $this, 'event_dates' ) );
			add_shortcode( 'free_badge', array( $this, 'free_badge' ) );
		}

		/**
		 * Output the donate box content.
		 */
		public function donate_box() {
			echo apply_filters( 'the_content', stripslashes( get_option( 'newmr_front_middle_left' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Output the About NewMR box content.
		 */
		public function about_newmr_box() {
			echo apply_filters( 'the_content', stripslashes( get_option( 'newmr_front_bottom_right' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Display link selected for the left footer.
		 */
		public function left_footer_link() {
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
		public function right_footer_link() {
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
		 * Output event lists for the Events page.
		 *
		 * Displays upcoming, open, and past events using the excerpt templates.
		 *
		 * @return string Event listings markup.
		 */
		public function events_page_shortcode() {
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

		/**
		 * Shortcode to output the person's company.
		 *
		 * @return string HTML markup for the company field.
		 */
		public function person_company_shortcode() {
			$company = get_post_meta( get_the_ID(), 'person_company', true );
			if ( ! $company ) {
				return '';
			}

			return '<span class="block text-sm text-gray-500">' . esc_html( $company ) . '</span>';
		}

		/**
		 * Shortcode to output the person's country.
		 *
		 * @return string HTML markup for the country field.
		 */
		public function person_country_shortcode() {
			$country = get_post_meta( get_the_ID(), 'person_country', true );
			if ( ! $country ) {
				return '';
			}

			return '<span class="block text-sm text-gray-500">' . esc_html( $country ) . '</span>';
		}

		/**
		 * Output the current person's company meta value.
		 *
		 * @return string
		 */
		public function person_company() {
			return '<span class="block text-sm text-gray-500">' . esc_html( get_post_meta( get_the_ID(), 'person_company', true ) ) . '</span>';
		}

		/**
		 * Output the current person's country meta value.
		 *
		 * @return string
		 */
		public function person_country() {
			return '<span class="block text-sm text-gray-500">' . esc_html( get_post_meta( get_the_ID(), 'person_country', true ) ) . '</span>';
		}

		/**
		 * Return formatted event date range based on meta fields.
		 *
		 * @return string Event dates HTML
		 */
		public function event_dates() {
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

		/**
		 * Output a "Free" badge when the event_free meta equals "yes".
		 *
		 * @return string
		 */
		public function free_badge() {
			$is_free = get_post_meta( get_the_ID(), 'event_free', true );
			if ( 'yes' === $is_free ) {
				return '<span class="free-badge text-green-600">' . esc_html__( 'Free', 'newmr' ) . '</span>';
			}
			return '';
		}
	}
}
