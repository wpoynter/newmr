<?php
/**
 * Video importer for NewMR.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Video_Importer' ) ) {
	/**
	 * Handle conversion of presentation posts into Flowplayer entries.
	 */
	class NewMR_Video_Importer {
		/** Option names. */
		const TODO_OPTION = 'newmr_video_todo';
		const DONE_OPTION = 'newmr_video_done';

		/**
		 * Setup hooks.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_page' ) );
			add_action( 'wp_ajax_newmr_load_videos', array( $this, 'ajax_load' ) );
			add_action( 'wp_ajax_newmr_start_import', array( $this, 'ajax_start' ) );
			add_action( 'wp_ajax_newmr_update_stats', array( $this, 'ajax_stats' ) );
			add_action( 'newmr_run_video_import', array( $this, 'run_import' ) );
		}

		/**
		 * Register the admin page.
		 */
		public function register_page() {
			add_submenu_page(
				'tools.php',
				__( 'Video Importer', 'newmr' ),
				__( 'Video Importer', 'newmr' ),
				'import',
				'newmr-video-importer',
				array( $this, 'render_page' )
			);
		}

		/**
		 * Display the importer page.
		 */
		public function render_page() {
			if ( ! current_user_can( 'import' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'newmr' ) );
			}

			$todo = get_option( self::TODO_OPTION, array() );
			$done = get_option( self::DONE_OPTION, array() );
			?>
			<div class="wrap">
				<h1><?php esc_html_e( 'Video Importer', 'newmr' ); ?></h1>
				<p>
					<?php esc_html_e( 'Presentations to be imported', 'newmr' ); ?>
					<span id="num-found"></span>:
					<textarea id="presentations" readonly="readonly" style="width: 100%; height: 200px;"></textarea>
				</p>
				<p>
					<?php submit_button( __( 'Update', 'newmr' ), 'secondary', 'update', false ); ?>
					<?php submit_button( __( 'Load', 'newmr' ), 'secondary', 'load-list', false ); ?>
					<?php submit_button( __( 'Run', 'newmr' ), 'primary', 'run', false, array( 'disabled' => 'disabled' ) ); ?>
					<span id="status" style="margin-left: 20px;"></span>
				</p>
				<p>
					<?php esc_html_e( 'Presentations processed', 'newmr' ); ?>
					<span id="num-done"></span>:
					<textarea id="done" readonly="readonly" style="width: 100%; height: 200px;"></textarea>
				</p>
			</div>
			<script type="text/javascript">
var newmrImporter = { nonce: "<?php echo esc_js( wp_create_nonce( 'newmr_video_import' ) ); ?>" };
			jQuery(document).ready(function($){
				$('#update').on('click', function(){
					$.post(ajaxurl, { action: 'newmr_update_stats', nonce: newmrImporter.nonce }, function(resp){
						$('#presentations').val(resp.ifeed);
						$('#num-found').text(' (' + resp.icount + ')');
						$('#done').val(resp.ffeed);
						$('#num-done').text(' (' + resp.fcount + ')');
						if (resp.icount > 0) {
							$('#run').removeAttr('disabled');
						} else {
							$('#run').attr('disabled', 'disabled');
						}
					});
				});
				$('#load-list').on('click', function(){
					$('#status').text('Loading...');
					$.post(ajaxurl, { action: 'newmr_load_videos', nonce: newmrImporter.nonce }, function(resp){
						$('#presentations').val(resp.feed);
						$('#num-found').text(' (' + resp.count + ')');
						if (resp.count > 0) {
							$('#run').removeAttr('disabled');
						} else {
							$('#run').attr('disabled', 'disabled');
						}
						$('#status').text('Ready');
					});
				});
				$('#run').on('click', function(){
					$('#status').text('Starting...');
					$.post(ajaxurl, { action: 'newmr_start_import', nonce: newmrImporter.nonce }, function(){
						$('#status').text('Running');
					});
				});
			});
			</script>
			<?php
		}

		/**
		 * Load eligible presentations and store in options.
		 */
		public function ajax_load() {
			check_ajax_referer( 'newmr_video_import', 'nonce' );
			$query = new WP_Query(
				array(
					'post_type'      => 'presentation',
					'posts_per_page' => -1,
				)
			);
			$todo  = array();
			while ( $query->have_posts() ) {
				$query->the_post();
				$mp4  = get_post_meta( get_the_ID(), 'prensentation_mp4file', true );
				$webm = get_post_meta( get_the_ID(), 'prensentation_webmfile', true );
				$ogv  = get_post_meta( get_the_ID(), 'prensentation_ogvfile', true );
				if ( '' === get_the_content() && $mp4 && $webm && $ogv ) {
					$todo[ get_the_ID() ] = html_entity_decode( get_the_title() );
				}
			}
			wp_reset_postdata();
			update_option( self::TODO_OPTION, $todo );
			update_option( self::DONE_OPTION, array() );
			wp_send_json(
				array(
					'feed'  => implode( "\n", $todo ),
					'count' => count( $todo ),
				)
			);
		}

		/**
		 * Schedule the import event.
		 */
		public function ajax_start() {
			check_ajax_referer( 'newmr_video_import', 'nonce' );
			if ( ! wp_next_scheduled( 'newmr_run_video_import' ) ) {
				wp_schedule_single_event( time(), 'newmr_run_video_import' );
			}
			wp_send_json_success();
		}

		/**
		 * Return stats to the browser.
		 */
		public function ajax_stats() {
			check_ajax_referer( 'newmr_video_import', 'nonce' );
			$todo = get_option( self::TODO_OPTION, array() );
			$done = get_option( self::DONE_OPTION, array() );
			wp_send_json(
				array(
					'ifeed'  => implode( "\n", $todo ),
					'icount' => count( $todo ),
					'ffeed'  => implode( "\n", $done ),
					'fcount' => count( $done ),
				)
			);
		}

		/**
		 * Process a single presentation.
		 */
		public function run_import() {
			$todo = get_option( self::TODO_OPTION, array() );
			if ( empty( $todo ) ) {
				return;
			}
			$id    = key( $todo );
			$title = $todo[ $id ];
			unset( $todo[ $id ] );

			$mp4  = get_post_meta( $id, 'prensentation_mp4file', true );
			$webm = get_post_meta( $id, 'prensentation_webmfile', true );
			$ogv  = get_post_meta( $id, 'prensentation_ogvfile', true );

			$video_id = wp_insert_post(
				array(
					'post_title'  => $title,
					'post_status' => 'publish',
					'post_type'   => 'flowplayer5',
				)
			);

			update_post_meta( $video_id, 'fp5-mp4-video', esc_url_raw( $mp4 ) );
			update_post_meta( $video_id, 'fp5-webm-video', esc_url_raw( $webm ) );
			update_post_meta( $video_id, 'fp5-ogg-video', esc_url_raw( $ogv ) );

			wp_update_post(
				array(
					'ID'           => $id,
					'post_content' => '[flowplayer id="' . $video_id . '"]',
				)
			);

			$done   = get_option( self::DONE_OPTION, array() );
			$done[] = $title;

			update_option( self::TODO_OPTION, $todo );
			update_option( self::DONE_OPTION, $done );

			if ( ! empty( $todo ) ) {
				wp_schedule_single_event( time() + 1, 'newmr_run_video_import' );
			}
		}
	}
}
