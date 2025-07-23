<?php
/**
 * Table listing event presentations for replay.
 *
 * @package NewMR
 */

$event         = get_post();
$presentations = new WP_Query(
	array(
		'connected_type'  => 'presentation_to_event',
		'connected_items' => $event,
		'nopaging'        => true,
	)
);
if ( $presentations->have_posts() ) :
	?>
<div class="mx-auto max-w-4xl pb-8">
		<table class="min-w-full divide-y divide-gray-200 border border-gray-200">
				<thead class="bg-gray-50">
						<tr>
								<th scope="col" class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Title</th>
								<th scope="col" class="px-4 py-2 text-center text-sm font-semibold text-gray-900">Watch</th>
								<th scope="col" class="px-4 py-2 text-center text-sm font-semibold text-gray-900">Slides</th>
						</tr>
				</thead>
				<tbody class="divide-y divide-gray-200">
	<?php
	while ( $presentations->have_posts() ) :
			$presentations->the_post();
			$slides    = get_post_meta( get_the_ID(), 'presentation_slides', true );
			$has_video = strlen( get_the_content() ) > 0;
		?>
						<tr>
								<td class="px-4 py-2">
										<a class="font-medium text-blue-700 hover:underline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</td>
								<td class="px-4 py-2 text-center">
									<?php if ( $has_video ) : ?>
										<a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline">Watch</a>
										<?php endif; ?>
								</td>
								<td class="px-4 py-2 text-center">
									<?php if ( $slides ) : ?>
										<a href="<?php echo esc_url( $slides ); ?>" class="text-blue-600 hover:underline">Download</a>
										<?php endif; ?>
								</td>
						</tr>
				<?php
		endwhile;
		wp_reset_postdata();
	?>
				</tbody>
		</table>
</div>
	<?php
endif;
?>
