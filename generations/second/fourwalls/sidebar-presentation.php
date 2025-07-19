	<?php

	$people = new WP_Query(array(
		'connected_type' => 'presentation_to_person',
		'connected_items' => get_post(),
		'nopaging' => true,
	));

	if ($people->have_posts()): ?>
	<div id="presenters">
		<?php while($people->have_posts()): $people->the_post(); ?>
		<div class="presenter">
			<?php the_post_thumbnail(array(80,80)); ?>
			<h4><?php the_title(); ?></h4>
			<span class="company"><?php echo get_post_meta(get_the_ID(), 'person_company', true); ?></span>
			<span class="country"><?php echo get_post_meta(get_the_ID(), 'person_country', true); ?></span>
		</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php endif; ?>

<?php get_sidebar(); ?>