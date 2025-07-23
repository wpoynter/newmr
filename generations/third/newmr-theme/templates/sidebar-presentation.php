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
<!-- wp:group {"tagName":"aside","className":"p-4 bg-gray-50 hidden lg:block"} -->
<aside class="p-4 bg-gray-50 hidden lg:block" id="presenters">
	<?php
	while ( $people->have_posts() ) :
		$people->the_post();
		get_template_part( 'parts/speaker-card' );
endwhile;
	wp_reset_postdata();
	?>
</aside>
<!-- /wp:group -->
<?php endif; ?>
<aside class="hidden lg:block" aria-label="<?php esc_attr_e( 'Advertisement', 'newmr' ); ?>">
<?php get_sidebar(); ?>
</aside>
