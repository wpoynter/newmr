<?php

class Adverts extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'adverts_widget', // Base ID
			__('Adverts', 'text_domain'), // Name
			array( 'description' => __( 'This widget displays all site wide adverts.', 'fourwalls' ), )
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		
		$e_post = get_post();
		
		if ($e_post->post_type == 'presentation') {
			$links = new WP_Query(array(
				'connected_type' => 'presentation_to_event',
				'connected_items' => $e_post,
				'nopaging' => true,
			));
			if ($links->have_posts())
				$e_post = $links->post;
		}
		
		$event = new WP_Query(array(
			'connected_type' => 'event_to_advert',
			'connected_items' => $e_post,
			'nopaging' => true,
		));
		
		$pres = new WP_Query(array(
			'connected_type' => 'presentation_to_advert',
			'connected_items' => get_post(),
			'nopaging' => true,
		));
		
		$the_query = new WP_Query(array(
		    'post_type' => 'advert',
		    'posts_per_page' => -1
	    ));
		
		if ($event->have_posts() || $pres->have_posts()) {
			while ( $pres->have_posts() ) {
				$pres->the_post();
				$site = get_post_meta(get_the_ID(), 'advert_site', true);
				$link = get_post_meta(get_the_ID(), 'advert_link', true);
				?>
				<div class="advert-wrapper">
					<?php if (strlen($link) > 1): ?>
					<a href="<?php echo $link; ?>" 
					   onClick="ga('send', 'event', 'Advert', 'Click', '<?php the_title(); ?>');" 
					   target="_blank">
						<?php the_content(); ?>
					</a>
					<?php else: ?>
					<?php the_content(); ?>
					<?php endif;?>
				</div>
				<?php
			}
			while ( $event->have_posts() ) {
				$event->the_post();
				$site = get_post_meta(get_the_ID(), 'advert_site', true);
				$link = get_post_meta(get_the_ID(), 'advert_link', true);
				 ?>
				<div class="advert-wrapper">
					<?php if (strlen($link) > 1): ?>
					<a href="<?php echo $link; ?>" 
					   onClick="ga('send', 'event', 'Advert', 'Click', '<?php the_title(); ?>');" 
					   target="_blank">
						<?php the_content(); ?>
					</a>
					<?php else: ?>
					<?php the_content(); ?>
					<?php endif;?>
				</div>
			<?php }
		} else {
			// The Loop
			?>
			<div class="advert-wrapper">
			</div>
			<?php
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$site = get_post_meta(get_the_ID(), 'advert_site', true);
					$link = get_post_meta(get_the_ID(), 'advert_link', true);
					if ($site == "yes") : ?>
					<div class="advert-wrapper">
						<?php if (strlen($link) > 1): ?>
						<a href="<?php echo $link; ?>" 
						   onClick="ga('send', 'event', 'Advert', 'Click', '<?php the_title(); ?>');" 
						   target="_blank">
							<?php the_content(); ?>
						</a>
						<?php else: ?>
						<?php the_content(); ?>
						<?php endif;?>
					</div>
					<?php else: ?>
					<?php endif;
				}
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		
		echo $args['after_widget'];
	}

	/**
	 * Ouputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function(){
     register_widget( 'Adverts' );
});

?>
