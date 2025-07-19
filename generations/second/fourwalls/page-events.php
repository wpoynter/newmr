<?php

get_header();

$up_query = new WP_Query(array(
	'post_type' => 'event',
	'meta_query' => array(
		array(
				'key' => 'event_events_page',
				'value' => 'yes',
				'compare' => '='
		),
		array(
		    'key' => 'event_date_to',
			'value' => mktime(23, 59, 59),
			'compare' => '>='
		),
		array(
			'key' => 'event_events_page',
			'value' => 'yes',
			'compare' => '='
		)
	),
	'post_parent'	=> 0,
	'posts_per_page'=> -1,
	'meta_key'		=> 'event_date_to',
	'orderby'		=> 'meta_value_num',
	'order'			=> 'ASC'
));
$open_query = new WP_Query(array(
	'post_type'		=> 'event',
	'meta_query'	=> array(
		array(
				'key' => 'event_events_page',
				'value' => 'yes',
				'compare' => '='
		),
		array(
		    'key' => 'event_date_from',
			'value' => '',
			'compare' => '='
		),
		array(
		    'key' => 'event_date_to',
			'value' => '',
			'compare' => '='
		)
	),
	'post_parent'	=> 0,
	'posts_per_page'=> -1
));
$down_query = new WP_Query(array(
	'post_type'		=> 'event',
	'meta_query'	=> array(
		array(
				'key' => 'event_events_page',
				'value' => 'yes',
				'compare' => '='
		),
		array(
		    'key' => 'event_date_to',
			'value' => mktime(23, 59, 59),
			'compare' => '<'
		),
		array(
		    'key' => 'event_date_to',
			'value' => '',
			'compare' => '!='
		)
	),
	'post_parent'	=> 0,
	'posts_per_page'=> -1,
	'meta_key'		=> 'event_date_to',
	'orderby'		=> 'meta_value_num',
	'order'			=> 'DESC'
));

?>

	<div id="primary" class="content-area content-width full-width-page">
		<div id="content" class="site-content events-page" role="main">
		<?php if ($up_query->have_posts()) : ?>

			<h1 class="entry-title event-category">Upcoming Events</h1>
			<?php /* The loop */ ?>
			<?php while ($up_query->have_posts()) : $up_query->the_post(); ?>
				<?php get_template_part( 'excerpt', get_post_type() ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
			
		<?php if ($open_query->have_posts()) : ?>

			<?php /* The loop */ ?>
			<?php while ($open_query->have_posts()) : $open_query->the_post(); ?>
				<?php get_template_part( 'excerpt', get_post_type() ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
				
		<?php if ($down_query->have_posts()) : ?>
			<?php /* The loop */ $years = array(); ?>
			<?php while ($down_query->have_posts()) : $down_query->the_post(); ?>
			<?php 
				$datestring = get_post_meta(get_the_ID(), 'event_date_from', true);
				$year = date("Y",$datestring);
				if (!in_array($year, $years)) :
					$years[] = $year; ?>
				<h1 class="entry-title event-category"><?php echo $year; ?></h1>		
			<?php endif; ?>
				<?php get_template_part( 'excerpt', get_post_type() ); ?>
			<?php endwhile; ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php

get_footer();

?>