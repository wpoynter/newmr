<?php
/**
 * Meta box registration for NewMR.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Meta_Boxes' ) ) {
	/**
	 * Register meta boxes and save metadata.
	 */
	class NewMR_Meta_Boxes {
		/**
		 * Setup hooks.
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'register_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_meta' ), 10, 2 );
		}

		/**
		 * Register meta boxes for custom post types.
		 */
		public function register_meta_boxes() {
			add_meta_box( 'booth_properties', __( 'Booth Properties', 'newmr' ), array( $this, 'display_booth_meta_box' ), 'booth', 'normal', 'high' );
			add_meta_box( 'advert_properties', __( 'Advert Properties', 'newmr' ), array( $this, 'display_advert_meta_box' ), 'advert', 'normal', 'high' );
			add_meta_box( 'event_properties', __( 'Event Properties', 'newmr' ), array( $this, 'display_event_meta_box' ), 'event', 'normal', 'high' );
			add_meta_box( 'presentation_properties', __( 'Presentation Properties', 'newmr' ), array( $this, 'display_presentation_meta_box' ), 'presentation', 'normal', 'high' );
			add_meta_box( 'person_properties', __( 'Person Properties', 'newmr' ), array( $this, 'display_person_meta_box' ), 'person', 'normal', 'high' );
		}

		/**
		 * Display booth meta box fields.
		 *
		 * @param WP_Post $post Post object.
		 */
		public function display_booth_meta_box( $post ) {
			$booth_link = esc_attr( get_post_meta( $post->ID, 'booth_link', true ) );
			wp_nonce_field( 'newmr_save_meta', 'newmr_meta_nonce' );
			?>
			<table>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Link', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="booth_link" value="<?php echo esc_attr( $booth_link ); ?>" /></td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Display advert meta box fields.
		 *
		 * @param WP_Post $post Post object.
		 */
		public function display_advert_meta_box( $post ) {
			$advert_link = esc_attr( get_post_meta( $post->ID, 'advert_link', true ) );
			$advert_site = esc_attr( get_post_meta( $post->ID, 'advert_site', true ) );
			wp_nonce_field( 'newmr_save_meta', 'newmr_meta_nonce' );
			?>
			<table>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Link', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="advert_link" value="<?php echo esc_attr( $advert_link ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Site Wide', 'newmr' ); ?></td>
					<td>
						<select style="width: 140px" name="advert_site">
							<option value="yes" <?php selected( 'yes', $advert_site ); ?>><?php esc_html_e( 'Yes', 'newmr' ); ?></option>
							<option value="no" <?php selected( 'no', $advert_site ); ?>><?php esc_html_e( 'No', 'newmr' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Display event meta box fields.
		 *
		 * @param WP_Post $post Post object.
		 */
		public function display_event_meta_box( $post ) {
			$event_pdf         = esc_attr( get_post_meta( $post->ID, 'event_pdf', true ) );
			$event_free        = esc_attr( get_post_meta( $post->ID, 'event_free', true ) );
			$event_date_from   = get_post_meta( $post->ID, 'event_date_from', true );
			$event_date_to     = get_post_meta( $post->ID, 'event_date_to', true );
			$event_events_page = esc_attr( get_post_meta( $post->ID, 'event_events_page', true ) );
			$event_play_again  = esc_attr( get_post_meta( $post->ID, 'event_play_again', true ) );
			$event_external    = esc_attr( get_post_meta( $post->ID, 'event_external', true ) );
			wp_nonce_field( 'newmr_save_meta', 'newmr_meta_nonce' );

			$display_date_from = $event_date_from ? gmdate( 'd-m-Y', (int) $event_date_from ) : '';
			$display_date_to   = $event_date_to ? gmdate( 'd-m-Y', (int) $event_date_to ) : '';
			?>
			<table>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'PDF URI', 'newmr' ); ?></td>
					<td><input id="event_pdf" type="text" size="80" name="event_pdf" value="<?php echo esc_attr( $event_pdf ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Site Wide', 'newmr' ); ?></td>
					<td>
						<select style="width: 140px" name="event_free">
							<option value="yes" <?php selected( 'yes', $event_free ); ?>><?php esc_html_e( 'Yes', 'newmr' ); ?></option>
							<option value="no" <?php selected( 'no', $event_free ); ?>><?php esc_html_e( 'No', 'newmr' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:150px"><?php esc_html_e( 'Date From', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="event_date_from" class="date-input" value="<?php echo esc_attr( $display_date_from ); ?>" /></td>
				</tr>
				<tr>
					<td style="width:150px"><?php esc_html_e( 'Date To', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="event_date_to" class="date-input" value="<?php echo esc_attr( $display_date_to ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Show on Events Page', 'newmr' ); ?></td>
					<td>
						<select style="width: 140px" name="event_events_page">
							<option value="yes" <?php selected( 'yes', $event_events_page ); ?>><?php esc_html_e( 'Yes', 'newmr' ); ?></option>
							<option value="no" <?php selected( 'no', $event_events_page ); ?>><?php esc_html_e( 'No', 'newmr' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Show on Play Again', 'newmr' ); ?></td>
					<td>
						<select style="width: 140px" name="event_play_again">
							<option value="yes" <?php selected( 'yes', $event_play_again ); ?>><?php esc_html_e( 'Yes', 'newmr' ); ?></option>
							<option value="no" <?php selected( 'no', $event_play_again ); ?>><?php esc_html_e( 'No', 'newmr' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'External Link', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="event_external" value="<?php echo esc_attr( $event_external ); ?>" /></td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Display presentation meta box fields.
		 *
		 * @param WP_Post $post Post object.
		 */
		public function display_presentation_meta_box( $post ) {
			$slides    = esc_attr( get_post_meta( $post->ID, 'presentation_slides', true ) );
			$hash      = esc_attr( get_post_meta( $post->ID, 'presentation_hash', true ) );
			$session   = esc_attr( get_post_meta( $post->ID, 'presentation_session', true ) );
			$order     = esc_attr( get_post_meta( $post->ID, 'presentation_order', true ) );
			$mp4file   = esc_attr( get_post_meta( $post->ID, 'presentation_mp4file', true ) );
			$webmfile  = esc_attr( get_post_meta( $post->ID, 'presentation_webmfile', true ) );
			$ogvfile   = esc_attr( get_post_meta( $post->ID, 'presentation_ogvfile', true ) );
			$splash    = esc_attr( get_post_meta( $post->ID, 'presentation_splash', true ) );
			$downloads = esc_attr( get_post_meta( $post->ID, 'presentation_screencast_downloads', true ) );
			$plays     = esc_attr( get_post_meta( $post->ID, 'presentation_screencast_plays', true ) );
			$event_id  = esc_attr( get_post_meta( $post->ID, 'presentation_event_id', true ) );
			$speaker_1 = esc_attr( get_post_meta( $post->ID, 'presentation_speaker_1', true ) );
			$speaker_2 = esc_attr( get_post_meta( $post->ID, 'presentation_speaker_2', true ) );
			wp_nonce_field( 'newmr_save_meta', 'newmr_meta_nonce' );
			?>
			<table>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Slides', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_slides" value="<?php echo esc_attr( $slides ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Session', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_session" value="<?php echo esc_attr( $session ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Session Order', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_order" value="<?php echo esc_attr( $order ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'MP4 File', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_mp4file" value="<?php echo esc_attr( $mp4file ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'WebM File', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_webmfile" value="<?php echo esc_attr( $webmfile ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'OGV File', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_ogvfile" value="<?php echo esc_attr( $ogvfile ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Splash', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="presentation_splash" value="<?php echo esc_attr( $splash ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Screencast Downloads', 'newmr' ); ?></td>
					<td><input type="text" disabled="disabled" size="80" name="presentation_screencast_downloads" value="<?php echo esc_attr( $downloads ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Screencast Plays', 'newmr' ); ?></td>
					<td><input type="text" disabled="disabled" size="80" name="presentation_screencast_plays" value="<?php echo esc_attr( $plays ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Old Hash', 'newmr' ); ?></td>
					<td><input type="text" disabled="disabled" size="80" name="presentation_hash" value="<?php echo esc_attr( $hash ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Old Event ID', 'newmr' ); ?></td>
					<td><input type="text" disabled="disabled" size="80" name="presentation_event_id" value="<?php echo esc_attr( $event_id ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Old Speaker 1 ID', 'newmr' ); ?></td>
					<td><input type="text" disabled="disabled" size="80" name="presentation_speaker_1" value="<?php echo esc_attr( $speaker_1 ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Old Speaker 2 ID', 'newmr' ); ?></td>
					<td><input type="text" disabled="disabled" size="80" name="presentation_speaker_2" value="<?php echo esc_attr( $speaker_2 ); ?>" /></td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Display person meta box fields.
		 *
		 * @param WP_Post $post Post object.
		 */
		public function display_person_meta_box( $post ) {
			$company = esc_attr( get_post_meta( $post->ID, 'person_company', true ) );
			$country = esc_attr( get_post_meta( $post->ID, 'person_country', true ) );
			wp_nonce_field( 'newmr_save_meta', 'newmr_meta_nonce' );
			?>
			<table>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Company', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="person_company" value="<?php echo esc_attr( $company ); ?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px"><?php esc_html_e( 'Country', 'newmr' ); ?></td>
					<td><input type="text" size="80" name="person_country" value="<?php echo esc_attr( $country ); ?>" /></td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Save meta box fields.
		 *
		 * @param int     $post_id Post ID.
		 * @param WP_Post $post    Post object.
		 */
		public function save_meta( $post_id, $post ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! isset( $_POST['newmr_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['newmr_meta_nonce'] ) ), 'newmr_save_meta' ) ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( 'booth' === $post->post_type ) {
				if ( isset( $_POST['booth_link'] ) ) {
					update_post_meta( $post_id, 'booth_link', sanitize_text_field( wp_unslash( $_POST['booth_link'] ) ) );
				}
			} elseif ( 'advert' === $post->post_type ) {
				if ( isset( $_POST['advert_link'] ) ) {
					update_post_meta( $post_id, 'advert_link', sanitize_text_field( wp_unslash( $_POST['advert_link'] ) ) );
				}
				if ( isset( $_POST['advert_site'] ) ) {
					update_post_meta( $post_id, 'advert_site', sanitize_text_field( wp_unslash( $_POST['advert_site'] ) ) );
				}
			} elseif ( 'event' === $post->post_type ) {
				if ( isset( $_POST['event_summary'] ) ) {
					update_post_meta( $post_id, 'event_summary', wp_kses_post( wp_unslash( $_POST['event_summary'] ) ) );
				}
				if ( isset( $_POST['event_pdf'] ) ) {
					update_post_meta( $post_id, 'event_pdf', sanitize_text_field( wp_unslash( $_POST['event_pdf'] ) ) );
				}
				if ( isset( $_POST['event_free'] ) ) {
					update_post_meta( $post_id, 'event_free', sanitize_text_field( wp_unslash( $_POST['event_free'] ) ) );
				}
				if ( isset( $_POST['event_date_from'] ) && strlen( sanitize_text_field( wp_unslash( $_POST['event_date_from'] ) ) ) > 1 ) {
					$formatted_date = sanitize_text_field( wp_unslash( $_POST['event_date_from'] ) );
					$date_pieces    = explode( '-', $formatted_date );
					update_post_meta( $post_id, 'event_date_from', mktime( 0, 0, 0, $date_pieces[1], $date_pieces[0], $date_pieces[2] ) );
				}
				if ( ( isset( $_POST['event_date_from'] ) || isset( $_POST['event_date_to'] ) ) && strlen( sanitize_text_field( wp_unslash( $_POST['event_date_from'] ) ) ) > 1 ) {
					if ( isset( $_POST['event_date_to'] ) && strlen( sanitize_text_field( wp_unslash( $_POST['event_date_to'] ) ) ) > 1 ) {
							$formatted_date = sanitize_text_field( wp_unslash( $_POST['event_date_to'] ) );
						$date_pieces        = explode( '-', $formatted_date );
						update_post_meta( $post_id, 'event_date_to', mktime( 0, 0, 0, $date_pieces[1], $date_pieces[0], $date_pieces[2] ) );
					} else {
						$formatted_date = sanitize_text_field( wp_unslash( $_POST['event_date_from'] ) );
						$date_pieces    = explode( '-', $formatted_date );
						update_post_meta( $post_id, 'event_date_to', mktime( 0, 0, 0, $date_pieces[1], $date_pieces[0], $date_pieces[2] ) );
					}
				}
				if ( isset( $_POST['event_events_page'] ) ) {
					update_post_meta( $post_id, 'event_events_page', sanitize_text_field( wp_unslash( $_POST['event_events_page'] ) ) );
				}
				if ( isset( $_POST['event_play_again'] ) ) {
					update_post_meta( $post_id, 'event_play_again', sanitize_text_field( wp_unslash( $_POST['event_play_again'] ) ) );
				}
				if ( isset( $_POST['event_external'] ) ) {
					update_post_meta( $post_id, 'event_external', sanitize_text_field( wp_unslash( $_POST['event_external'] ) ) );
				}
			} elseif ( 'presentation' === $post->post_type ) {
				if ( isset( $_POST['presentation_slides'] ) ) {
					update_post_meta( $post_id, 'presentation_slides', sanitize_text_field( wp_unslash( $_POST['presentation_slides'] ) ) );
				}
				if ( isset( $_POST['presentation_hash'] ) ) {
					update_post_meta( $post_id, 'presentation_hash', sanitize_text_field( wp_unslash( $_POST['presentation_hash'] ) ) );
				}
				if ( isset( $_POST['presentation_session'] ) ) {
					update_post_meta( $post_id, 'presentation_session', sanitize_text_field( wp_unslash( $_POST['presentation_session'] ) ) );
				}
				if ( isset( $_POST['presentation_order'] ) ) {
					update_post_meta( $post_id, 'presentation_order', sanitize_text_field( wp_unslash( $_POST['presentation_order'] ) ) );
				}
				if ( isset( $_POST['presentation_mp4file'] ) ) {
					update_post_meta( $post_id, 'presentation_mp4file', sanitize_text_field( wp_unslash( $_POST['presentation_mp4file'] ) ) );
				}
				if ( isset( $_POST['presentation_webmfile'] ) ) {
					update_post_meta( $post_id, 'presentation_webmfile', sanitize_text_field( wp_unslash( $_POST['presentation_webmfile'] ) ) );
				}
				if ( isset( $_POST['presentation_ogvfile'] ) ) {
					update_post_meta( $post_id, 'presentation_ogvfile', sanitize_text_field( wp_unslash( $_POST['presentation_ogvfile'] ) ) );
				}
				if ( isset( $_POST['presentation_splash'] ) ) {
					update_post_meta( $post_id, 'presentation_splash', sanitize_text_field( wp_unslash( $_POST['presentation_splash'] ) ) );
				}
				if ( isset( $_POST['presentation_screencast_downloads'] ) ) {
					update_post_meta( $post_id, 'presentation_screencast_downloads', sanitize_text_field( wp_unslash( $_POST['presentation_screencast_downloads'] ) ) );
				}
				if ( isset( $_POST['presentation_screencast_plays'] ) ) {
					update_post_meta( $post_id, 'presentation_screencast_plays', sanitize_text_field( wp_unslash( $_POST['presentation_screencast_plays'] ) ) );
				}
				if ( isset( $_POST['presentation_event_id'] ) ) {
					update_post_meta( $post_id, 'presentation_event_id', sanitize_text_field( wp_unslash( $_POST['presentation_event_id'] ) ) );
				}
				if ( isset( $_POST['presentation_speaker_1'] ) ) {
					update_post_meta( $post_id, 'presentation_speaker_1', sanitize_text_field( wp_unslash( $_POST['presentation_speaker_1'] ) ) );
				}
				if ( isset( $_POST['presentation_speaker_2'] ) ) {
					update_post_meta( $post_id, 'presentation_speaker_2', sanitize_text_field( wp_unslash( $_POST['presentation_speaker_2'] ) ) );
				}
				if ( isset( $_POST['presentation_synopsis'] ) ) {
					update_post_meta( $post_id, 'presentation_synopsis', wp_kses_post( wp_unslash( $_POST['presentation_synopsis'] ) ) );
				}
			} elseif ( 'person' === $post->post_type ) {
				if ( isset( $_POST['person_company'] ) ) {
					update_post_meta( $post_id, 'person_company', sanitize_text_field( wp_unslash( $_POST['person_company'] ) ) );
				}
				if ( isset( $_POST['person_country'] ) ) {
					update_post_meta( $post_id, 'person_country', sanitize_text_field( wp_unslash( $_POST['person_country'] ) ) );
				}
			}
		}
	}
}
