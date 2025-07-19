	<?php

	$e_post = get_post();
	$pres = new WP_Query(array(
		'connected_type' => 'presentation_to_event',
		'connected_items' => get_post(),
		'nopaging' => true,
	));
	
	$readyCount = 0;
	while($pres->have_posts()) {
		$pres->the_post();
		if (strlen(get_the_content()) > 0)
			$readyCount++;
	}

	if ($readyCount > 0): ?>
	<div id="play-again-sidebar">
	    <div id="sidebar-container">
    	   <a href="<?php echo get_site_url() . '/play-again/' . $e_post->post_name ?>">
    			<h2>Play Again</h2>
    			<span><?php echo $pres->post_count ?> recording<?php echo $pres->post_count != 1 ? 's' : '';?></span>
    		</a>
	    </div>
	</div>
	<?php endif; ?>

<?php get_sidebar(); ?>