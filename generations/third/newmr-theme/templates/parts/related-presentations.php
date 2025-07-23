<?php
/**
 * Related presentations grid.
 *
 * @package NewMR
 */

$related = new WP_Query(
	array(
		'post_type'      => 'presentation',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
	)
);

if ( $related->have_posts() ) : ?>
<div class="related-presentations grid grid-cols-1 sm:grid-cols-3 gap-6">
	<?php
	while ( $related->have_posts() ) :
		$related->the_post();
		?>
<article class="shadow p-4 hover:shadow-lg transition">
<a href="<?php the_permalink(); ?>" class="block hover:underline">
		<?php the_title( '<h3 class="font-semibold mb-2">', '</h3>' ); ?>
</a>
</article>
		<?php
endwhile;
	wp_reset_postdata();
	?>
</div>
<?php endif; ?>
