<?php
/**
 * Sidebar displayed on single event pages showing recordings link.
 *
 * @package NewMR
 */

$e_post      = get_post();
$pres        = new WP_Query(
	array(
		'connected_type'  => 'presentation_to_event',
		'connected_items' => $e_post,
		'nopaging'        => true,
	)
);
$ready_count = 0;
while ( $pres->have_posts() ) {
	$pres->the_post();
	if ( strlen( get_the_content() ) > 0 ) {
		++$ready_count;
	}
}
wp_reset_postdata();
if ( $ready_count > 0 ) : ?>
<!-- wp:group {"tagName":"aside","className":"p-4 bg-gray-50"} -->
<aside class="p-4 bg-gray-50" id="play-again-sidebar">
	<div id="sidebar-container">
	<a href="<?php echo esc_url( home_url( '/play-again/' ) . $e_post->post_name ); ?>" class="block">
		<h2 class="font-bold text-lg">Play Again</h2>
				<span><?php echo intval( $pres->post_count ); ?> recording<?php echo 1 !== $pres->post_count ? 's' : ''; ?></span>
	</a>
	</div>
</aside>
<!-- /wp:group -->
<?php endif; ?>
<?php get_sidebar(); ?>
