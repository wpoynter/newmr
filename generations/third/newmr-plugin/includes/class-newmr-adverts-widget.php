<?php
/**
 * Adverts widget for NewMR.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Adverts_Widget' ) ) {
	/**
	 * Display adverts connected to presentations or events.
	 */
	class NewMR_Adverts_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'newmr_adverts',
				__( 'Adverts', 'newmr' ),
				array(
					'description' => __( 'Displays adverts for events and presentations.', 'newmr' ),
				)
			);
		}

		/**
		 * Output widget content.
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Widget settings.
		 */
		public function widget( $args, $instance ) {
			unset( $instance );

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			$e_post = get_post();

			if ( $e_post && 'presentation' === $e_post->post_type ) {
				$links = new WP_Query(
					array(
						'connected_type'  => 'presentation_to_event',
						'connected_items' => $e_post,
						'nopaging'        => true,
					)
				);
				if ( $links->have_posts() ) {
						$e_post = $links->post;
				}
			}

			$event = new WP_Query(
				array(
					'connected_type'  => 'event_to_advert',
					'connected_items' => $e_post,
					'nopaging'        => true,
				)
			);

			$pres = new WP_Query(
				array(
					'connected_type'  => 'presentation_to_advert',
					'connected_items' => get_post(),
					'nopaging'        => true,
				)
			);

			$all_adverts = new WP_Query(
				array(
					'post_type'      => 'advert',
					'posts_per_page' => -1,
				)
			);

			if ( $event->have_posts() || $pres->have_posts() ) {
				while ( $pres->have_posts() ) {
					$pres->the_post();
					$link = get_post_meta( get_the_ID(), 'advert_link', true );
					?>
<div class="advert-wrapper">
					<?php if ( strlen( $link ) > 1 ) : ?>
<a href="<?php echo esc_url( $link ); ?>" onClick="ga('send', 'event', 'Advert', 'Click', '<?php echo esc_js( get_the_title() ); ?>');" target="_blank">
						<?php the_content(); ?>
</a>
<?php else : ?>
	<?php the_content(); ?>
<?php endif; ?>
</div>
					<?php
				}
				while ( $event->have_posts() ) {
					$event->the_post();
					$link = get_post_meta( get_the_ID(), 'advert_link', true );
					?>
<div class="advert-wrapper">
					<?php if ( strlen( $link ) > 1 ) : ?>
<a href="<?php echo esc_url( $link ); ?>" onClick="ga('send', 'event', 'Advert', 'Click', '<?php echo esc_js( get_the_title() ); ?>');" target="_blank">
						<?php the_content(); ?>
</a>
<?php else : ?>
	<?php the_content(); ?>
<?php endif; ?>
</div>
					<?php
				}
			} else {
				?>
<div class="advert-wrapper">
</div>
				<?php
				if ( $all_adverts->have_posts() ) {
					while ( $all_adverts->have_posts() ) {
						$all_adverts->the_post();
						$site = get_post_meta( get_the_ID(), 'advert_site', true );
						$link = get_post_meta( get_the_ID(), 'advert_link', true );
						if ( 'yes' === $site ) :
							?>
<div class="advert-wrapper">
							<?php if ( strlen( $link ) > 1 ) : ?>
<a href="<?php echo esc_url( $link ); ?>" onClick="ga('send', 'event', 'Advert', 'Click', '<?php echo esc_js( get_the_title() ); ?>');" target="_blank">
								<?php the_content(); ?>
</a>
<?php else : ?>
	<?php the_content(); ?>
<?php endif; ?>
</div>
								<?php
					endif;
					}
				}
			}

			wp_reset_postdata();

			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Output the settings form.
		 *
		 * @param array $instance Widget instance.
		 */
		public function form( $instance ) {
			unset( $instance );
		}

		/**
		 * Process widget options to be saved.
		 *
		 * @param array $new_instance New settings.
		 * @param array $old_instance Old settings.
		 *
		 * @return array Unmodified settings.
		 */
		public function update( $new_instance, $old_instance ) {
			unset( $new_instance );
			return $old_instance;
		}
	}
}
