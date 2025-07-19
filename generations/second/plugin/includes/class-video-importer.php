<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

error_reporting(E_ALL);

if (!class_exists('Video_Importer')) {

	class Video_Importer {

		public $tobedone = array();
		public $processed = array();

		public function __construct() {
			add_action('admin_init', array($this, 'init'));
			add_action('admin_menu', array($this, 'admin_menu'));
			add_action('admin_footer', array($this, 'admin_footer'));
			add_action('wp_ajax_load_vimp', array($this, 'load_vimp'));
			add_action('wp_ajax_start_vimp', array($this, 'start_vimp'));
			add_action('wp_ajax_update_stats', array($this, 'update_stats'));
			add_action('run_vimp', array($this, 'run_vimp'));
		}

		function init() {
			$this->load_from_file();
		}

		function admin_menu() {
			add_submenu_page(
					'tools.php', 'Video Importer', 'Video Importer', 'import', 'newmr-video-importer', array(
				$this,
				'admin_page'
					)
			);
		}

		function admin_footer() {
			?>
			<script type="text/javascript" >
				jQuery(document).ready(function($) {

					jQuery('#update').click(function() {
						$.post(ajaxurl, {'action': 'update_stats'}, function(response) {
							var obj = JSON.parse(response);
							jQuery('textarea#presentations').val(obj.ifeed);
							jQuery('span#num-found').html(' (' + obj.icount + ')');
							jQuery('textarea#done').val(obj.ffeed);
							jQuery('span#num-done').html(' (' + obj.fcount + ')');
							if (obj.icount > 0)
								jQuery('#run').removeAttr('disabled');
							else
								jQuery('#run').attr('disabled', 'disabled');
						});
					});

					jQuery('#load-list').click(function() {
						jQuery('#status').text('Loading...');
						$.post(ajaxurl, {'action': 'load_vimp'}, function(response) {
							var obj = JSON.parse(response);
							jQuery('textarea#presentations').val(obj.feed);
							jQuery('span#num-found').html(' (' + obj.count + ')');
							if (obj.count > 0)
								jQuery('#run').removeAttr('disabled');
							else
								jQuery('#run').attr('disabled', 'disabled');
							jQuery('#status').text('Ready');
						});
					});

					jQuery('#run').click(function() {
						jQuery('#status').text('Starting...');
						$.post(ajaxurl, {'action': 'start_vimp'}, function(response) {
							jQuery('#status').text('Running');
						});
					});

				});
			</script> <?php

		}

		function load_vimp() {
			$query = new WP_Query('post_type=presentation&posts_per_page=-1');

			while ($query->have_posts()) {
				$query->the_post();
				$content = get_the_content();
				$mp4 = get_post_meta(get_the_ID(), 'prensentation_mp4file', true);
				$webm = get_post_meta(get_the_ID(), 'prensentation_webmfile', true);
				$ogv = get_post_meta(get_the_ID(), 'prensentation_ogvfile', true);
				if (strlen($content) < 1 && (strlen($mp4) > 4 && strlen($webm) > 4 && strlen($ogv) > 4)) {
					$this->tobedone[get_the_ID()] = html_entity_decode(get_the_title());
				}
			}
			$output['feed'] = implode("\n", $this->tobedone);
			$output['count'] = count($this->tobedone);

			$this->save_to_file();
			echo json_encode($output);
			die();
		}

		function start_vimp() {
			wp_schedule_single_event(time(), 'run_vimp');
			echo '';
			die();
		}

		function update_stats() {
			$output['ifeed'] = implode("\n", $this->tobedone);
			$output['icount'] = count($this->tobedone);
			$output['ffeed'] = implode("\n", $this->processed);
			$output['fcount'] = count($this->processed);
			echo json_encode($output);
			die();
		}

		function run_vimp() {
			$this->load_from_file();
			mail('poynter.william@gmail.com', 'DEBUG-AA', count($this->tobedone));
			while (count($this->tobedone) > 0) {
				reset($this->tobedone);
				$pres = array();
				$pres['ID'] = key($this->tobedone);
				$pres['title'] = array_shift($this->tobedone);
				

				$mp4 = get_post_meta(
						$pres['ID'], 'prensentation_mp4file', true);
				$webm = get_post_meta(
						$pres['ID'], 'prensentation_webmfile', true);
				$ogv = get_post_meta(
						$pres['ID'], 'prensentation_ogvfile', true);

				$post_id = wp_insert_post(array(
					'post_title' => $pres['title'],
					'post_status' => 'publish',
					'post_type' => 'flowplayer5'
				));

				$defaults = array(
					'fp5-max-width' => '',
					'fp5-width' => '',
					'fp5-height' => '',
					'fp5-user-id' => '0',
					'fp5-video-id' => '0',
					'fp5-ads-time' => '0',
					'fp5-duration' => '',
					'fp5-splash-image' => '',
					'fp5-mp4-video' => $mp4,
					'fp5-webm-video' => $webm,
					'fp5-ogg-video' => $ogv,
					'fp5-hls-video' => '',
					'fp5-vtt-subtitles' => '',
					'fp5-select-skin' => 'minimalist',
					'fp5-preload' => 'auto',
					'fp5-coloring' => 'default',
					'fp5-ad-type' => 'image_text',
					'fp5-flash-video' => '',
					'fp5-video-name' => '',
					'fp5-data-rtmp' => ''
				);

				// Check, validate and save checkboxes
				$checkboxes = array(
					'fp5-autoplay',
					'fp5-loop',
					'fp5-fixed-controls',
					'fp5-aspect-ratio',
					'fp5-fixed-width',
					'fp5-no-background',
					'fp5-aside-time',
					'fp5-no-hover',
					'fp5-no-mute',
					'fp5-no-time',
					'fp5-no-volume',
					'fp5-no-embed',
					'fp5-play-button'
				);

				foreach ($checkboxes as $checkbox) {
					update_post_meta(
							$post_id, $checkbox, ''
					);
				}

				// Check, validate and save keys
				$keys = array(
					'fp5-select-skin',
					'fp5-preload',
					'fp5-coloring',
					'fp5-ad-type'
				);

				foreach ($keys as $key) {
					if (isset($defaults[$key])) {
						update_post_meta(
								$post_id, $key, sanitize_key($defaults[$key])
						);
					}
				}

				// Check, validate and save urls
				$urls = array(
					'fp5-splash-image',
					'fp5-mp4-video',
					'fp5-webm-video',
					'fp5-ogg-video',
					'fp5-hls-video',
					'fp5-vtt-subtitles'
				);

				foreach ($urls as $url) {
					if (isset($defaults[$url])) {
						update_post_meta(
								$post_id, $url, esc_url_raw($defaults[$url])
						);
					}
				}

				// Check, validate and save numbers
				$numbers = array(
					'fp5-max-width',
					'fp5-width',
					'fp5-height',
					'fp5-user-id',
					'fp5-video-id',
					'fp5-ads-time',
					'fp5-duration'
				);

				foreach ($numbers as $number) {
					if (isset($defaults[$number])) {
						update_post_meta(
								$post_id, $number, absint($defaults[$number])
						);
					}
				}

				// Check, validate and save text fields
				$text_fields = array(
					'fp5-flash-video',
					'fp5-video-name',
					'fp5-data-rtmp'
				);

				foreach ($text_fields as $text_field) {
					if (isset($defaults[$text_field])) {
						update_post_meta(
								$post_id, $text_field, sanitize_text_field($defaults[$text_field])
						);
					}
				}
				$this->processed[] = $pres;
				$this->save_to_file();
				wp_update_post(array('ID' => $pres['ID'], 'post_content' => '[flowplayer id="' . $post_id . '"]'));
				return;
			}
		}

		function admin_page() {
			if (!current_user_can('import')) {
				wp_die('You do not have sufficient permissions to access this page.');
			}


			include('admin-page.inc');
		}
		
		function save_to_file() {
			$to_save = array();
			$to_save['tobedone'] = $this->tobedone;
			$to_save['processed'] = $this->processed;
			$fh = fopen(plugin_dir_path( __FILE__ ) . '/cache.txt', 'w');
			fwrite($fh, json_encode($to_save));
			fclose($fh);
		}
		
		function load_from_file() {
			$fh = fopen(plugin_dir_path( __FILE__ ) . '/cache.txt', 'r');
			$contents = json_decode(fread($fh, filesize(plugin_dir_path( __FILE__ ) . '/cache.txt')), true);
			$this->tobedone = $contents['tobedone'];
			$this->processed = $contents['processed'];
			fclose($fh);
		}

	}

	//$vimp = new Video_Importer();
}
?>