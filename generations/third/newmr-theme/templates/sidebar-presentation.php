<?php
/**
 * Sidebar for single presentation pages showing presenters.
 *
 * @package NewMR
 */

$people = new WP_Query(
	array(
		'connected_type'  => 'presentation_to_person',
		'connected_items' => get_post(),
		'nopaging'        => true,
	)
);
if ( $people->have_posts() ) : ?>
<!-- wp:group {"tagName":"aside","className":"p-4 bg-gray-50"} -->
<aside class="p-4 bg-gray-50" id="presenters">
	<?php
	while ( $people->have_posts() ) :
		$people->the_post();
		?>
	<div class="presenter flex items-center gap-3 mb-4">
		<?php the_post_thumbnail( array( 80, 80 ) ); ?>
	<div>
		<h4 class="font-semibold"><?php the_title(); ?></h4>
		<span class="block text-sm text-gray-500"><?php echo esc_html( get_post_meta( get_the_ID(), 'person_company', true ) ); ?></span>
		<span class="block text-sm text-gray-500"><?php echo esc_html( get_post_meta( get_the_ID(), 'person_country', true ) ); ?></span>
	</div>
	</div>
		<?php
	endwhile;
	wp_reset_postdata();
	?>
</aside>
<!-- /wp:group -->
<?php endif; ?>
<?php get_sidebar(); ?>
