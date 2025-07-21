<?php
/**
 * Admin settings for NewMR.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Settings' ) ) {
	/**
	 * Admin page for managing NewMR settings.
	 */
	class NewMR_Settings {
		/**
		 * Setup hooks.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_page' ) );
		}

		/**
		 * Register settings page under "Settings".
		 */
		public function register_page() {
			add_options_page(
				__( 'NewMR Settings', 'newmr' ),
				__( 'NewMR Settings', 'newmr' ),
				'manage_options',
				'newmr-settings',
				array( $this, 'render_page' )
			);
		}

		/**
		 * Render the settings page.
		 */
		public function render_page() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have permission to access this page.', 'newmr' ) );
			}

			if ( isset( $_POST['newmr_settings_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['newmr_settings_nonce'] ) ), 'newmr_save_settings' ) ) {
				if ( isset( $_POST['front_middle_left'] ) ) {
					update_option( 'newmr_front_middle_left', wp_kses_post( wp_unslash( $_POST['front_middle_left'] ) ) );
				}
				if ( isset( $_POST['front_bottom_right'] ) ) {
					update_option( 'newmr_front_bottom_right', wp_kses_post( wp_unslash( $_POST['front_bottom_right'] ) ) );
				}
				if ( isset( $_POST['ga_tracking_code'] ) ) {
					update_option( 'newmr_ga_tracking_code', sanitize_text_field( wp_unslash( $_POST['ga_tracking_code'] ) ) );
				}
				if ( isset( $_POST['left_footer_link'] ) ) {
					update_option( 'newmr_left_footer_link', sanitize_text_field( wp_unslash( $_POST['left_footer_link'] ) ) );
				}
				if ( isset( $_POST['right_footer_link'] ) ) {
					update_option( 'newmr_right_footer_link', sanitize_text_field( wp_unslash( $_POST['right_footer_link'] ) ) );
				}
				if ( isset( $_POST['featured_video'] ) ) {
					update_option( 'newmr_featured_video', sanitize_text_field( wp_unslash( $_POST['featured_video'] ) ) );
				}
				echo '<div class="updated"><p>' . esc_html__( 'Settings saved.', 'newmr' ) . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			$front_middle_left  = get_option( 'newmr_front_middle_left', '' );
			$front_bottom_right = get_option( 'newmr_front_bottom_right', '' );
			$ga_tracking_code   = get_option( 'newmr_ga_tracking_code', '' );
			$left_footer_link   = get_option( 'newmr_left_footer_link', '' );
			$right_footer_link  = get_option( 'newmr_right_footer_link', '' );
			$featured_video     = get_option( 'newmr_featured_video', '' );
			?>
			<div class="wrap">
				<h1><?php esc_html_e( 'NewMR Settings', 'newmr' ); ?></h1>
				<form method="post" action="">
					<?php wp_nonce_field( 'newmr_save_settings', 'newmr_settings_nonce' ); ?>
					<p>
						<label for="front_middle_left"><strong><?php esc_html_e( 'Front Middle Left (Donate Box):', 'newmr' ); ?></strong></label><br />
						<textarea name="front_middle_left" id="front_middle_left" style="width:90%;height:100px;" ><?php echo esc_textarea( $front_middle_left ); ?></textarea>
					</p>
					<p>
						<label for="front_bottom_right"><strong><?php esc_html_e( 'Front Bottom Right (About NewMR Box):', 'newmr' ); ?></strong></label><br />
						<textarea name="front_bottom_right" id="front_bottom_right" style="width:90%;height:200px;" ><?php echo esc_textarea( $front_bottom_right ); ?></textarea>
					</p>
					<p>
						<label for="ga_tracking_code"><strong><?php esc_html_e( 'Google Analytics Tracking:', 'newmr' ); ?></strong></label>
						<input name="ga_tracking_code" id="ga_tracking_code" type="text" value="<?php echo esc_attr( $ga_tracking_code ); ?>" class="regular-text" />
					</p>
					<p>
						<label for="left_footer_link"><strong><?php esc_html_e( 'Left Footer Link:', 'newmr' ); ?></strong></label>
						<select name="left_footer_link" id="left_footer_link">
							<option value=""><?php esc_html_e( '--Select a Page--', 'newmr' ); ?></option>
							<?php
							$query = new WP_Query(
								array(
									'post_type' => 'page',
									'nopaging'  => true,
								)
							);
							while ( $query->have_posts() ) {
								$query->the_post();
								$pagename = get_post()->post_name;
								echo '<option value="' . esc_attr( $pagename ) . '" ' . selected( $pagename, $left_footer_link, false ) . '>' . esc_html( get_the_title() ) . '</option>';
							}
							wp_reset_postdata();
							?>
						</select>
					</p>
					<p>
						<label for="right_footer_link"><strong><?php esc_html_e( 'Right Footer Link:', 'newmr' ); ?></strong></label>
						<select name="right_footer_link" id="right_footer_link">
							<option value=""><?php esc_html_e( '--Select a Page--', 'newmr' ); ?></option>
							<?php
							$query = new WP_Query(
								array(
									'post_type' => 'page',
									'nopaging'  => true,
								)
							);
							while ( $query->have_posts() ) {
								$query->the_post();
								$pagename = get_post()->post_name;
								echo '<option value="' . esc_attr( $pagename ) . '" ' . selected( $pagename, $right_footer_link, false ) . '>' . esc_html( get_the_title() ) . '</option>';
							}
							wp_reset_postdata();
							?>
						</select>
					</p>
					<p>
						<label for="featured_video"><strong><?php esc_html_e( 'Featured Video:', 'newmr' ); ?></strong></label>
						<select name="featured_video" id="featured_video" style="width:83%;">
							<option value=""><?php esc_html_e( '--Select a Presentation--', 'newmr' ); ?></option>
							<?php
							$query = new WP_Query(
								array(
									'post_type' => 'presentation',
									'nopaging'  => true,
									'orderby'   => 'date',
									'order'     => 'DESC',
								)
							);
							while ( $query->have_posts() ) {
								$query->the_post();
								$name = get_post()->post_name;
								echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $featured_video, false ) . '>' . esc_html( get_the_title() ) . '</option>';
							}
							wp_reset_postdata();
							?>
						</select>
					</p>
					<p>
						<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Settings', 'newmr' ); ?>" />
					</p>
				</form>
			</div>
			<?php
		}
	}
}
