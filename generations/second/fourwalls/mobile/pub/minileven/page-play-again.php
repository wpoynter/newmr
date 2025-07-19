<?php

get_header();

if (isset($wp_query->query_vars['one']) && $wp->query_vars['one'] != '') {
	if (isset($wp_query->query_vars['two'])) {
		//Two parameters
	} else {

		$event_query = new WP_Query(array(
			'post_type'	=> 'event',
			'name'		=> $wp_query->query_vars['one']
		));
		if ($event_query->post_count > 0) {
			$connected = new WP_Query(array(
				'connected_type' => 'presentation_to_event',
				'connected_items' => $event_query->posts[0],
				'nopaging' => true,
			));
			$query = $connected;
			$event_query->the_post();
			?>

			<div id="primary">
				<div id="content" role="main">
				<?php if ($query->have_posts()) : ?>
					<header class="page-header">
						<h1 class="page-title">
							<?php the_title(); ?>
						</h1>
					</header>

					<?php /* The loop */ ?>
					<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php get_template_part( 'excerpt', 'presentation' ); ?>
					<?php endwhile; ?>
				<?php endif; ?>

				</div><!-- #content -->
			</div><!-- #primary -->

			<?php
		} else {
			$pres_query = new WP_Query(array(
				'post_type'	=> 'presentation',
				'name'		=> $wp_query->query_vars['one']
			));
			if ($pres_query->post_count > 0) {
				$pres_query->the_post(); ?>
			
				<div id="primary" class="content-area content-width">
					<div id="content" class="site-content  page-content-width" role="main">
				<?php get_template_part('content', 'presentation'); ?>
						
					</div><!-- #content -->
				</div><!-- #primary -->
				<?php get_template_part('sidebar', 'presentation'); ?>
				<?php
			}
		}
	}
} else {
	$query = new WP_Query(array(
		'post_type' => 'event',
		'posts_per_page'=> -1,
		'meta_query' => array(
			array(
				'key' => 'event_date_from',
				'value' => time(),
				'compare' => '<'
			),
			array(
				'key' => 'event_play_again',
				'value' => 'yes',
				'compare' => '='
			)
		),
		'meta_key'		=> 'event_date_to',
		'orderby'		=> 'meta_value_num',
		'order'			=> 'DESC'
	));
	
	?>

	<div id="primary" >
		<div id="content" role="main">
			<header class="page-header">
				<h1 class="page-title">
					Play Again
				</h1>
			</header>
		<?php if ($query->have_posts()) : ?>

			<?php /* The loop */ ?>
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php get_template_part( 'play-again', get_post_type() ); ?>
			<?php endwhile; ?>
		<?php endif; ?>

		</div><!-- #content -->
		
	</div><!-- #primary -->

<?php
}

get_footer();

?>