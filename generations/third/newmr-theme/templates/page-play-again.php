<?php
/**
 * Template for the Play Again page listing recorded events or presentations.
 *
 * @package NewMR
 */

global $wp_query;
get_header();

if ( isset( $wp_query->query_vars['one'] ) && '' !== $wp_query->query_vars['one'] ) {
		$slug = isset( $wp_query->query_vars['two'] ) ? $wp_query->query_vars['two'] : $wp_query->query_vars['one'];

		$event_query = new WP_Query(
			array(
				'post_type' => 'event',
				'name'      => $wp_query->query_vars['one'],
			)
		);

	if ( $event_query->have_posts() ) {
			$event_post = $event_query->posts[0];
			$connected  = new WP_Query(
				array(
					'connected_type'  => 'presentation_to_event',
					'connected_items' => $event_post,
					'nopaging'        => true,
				)
			);
			$event_query->the_post();
		?>
<section id="primary" class="content-area content-width py-8">
		<main id="content" class="site-content" role="main">
		<?php if ( $connected->have_posts() ) : ?>
				<h1 class="text-3xl font-bold mb-6"><?php the_title(); ?></h1>
				<table class="min-w-full divide-y divide-gray-200">
						<thead>
								<tr class="bg-gray-50">
																				<th class="speaker-col p-2 text-left"><?php esc_html_e( 'Speaker', 'newmr-theme' ); ?></th>
																				<th class="title-col p-2 text-left"><?php esc_html_e( 'Title', 'newmr-theme' ); ?></th>
																				<th class="watch-col p-2 text-center"><?php esc_html_e( 'Video', 'newmr-theme' ); ?></th>
																				<th class="download-col p-2 text-center"><?php esc_html_e( 'Slides', 'newmr-theme' ); ?></th>
								</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
						<?php
						while ( $connected->have_posts() ) :
								$connected->the_post();
								$people_query = new WP_Query(
									array(
										'connected_type'  => 'presentation_to_person',
										'connected_items' => get_post(),
										'nopaging'        => true,
									)
								);
								$persons      = array();
							while ( $people_query->have_posts() ) {
									$people_query->the_post();
									$persons[] = '<a href="' . esc_url( get_permalink() ) . '" class="text-blue-600 hover:underline">' . esc_html( get_the_title() ) . '</a>';
							}
								wp_reset_postdata();
								$slides = get_post_meta( get_the_ID(), 'presentation_slides', true );
							?>
								<tr>
										<td class="p-2"><?php echo wp_kses_post( implode( ', ', $persons ) ); ?></td>
										<td class="p-2"><?php the_title(); ?></td>
																				<td class="p-2 text-center"><a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline"><?php esc_html_e( 'Watch', 'newmr-theme' ); ?></a></td>
										<td class="p-2 text-center">
												<?php if ( $slides ) : ?>
																				<a href="<?php echo esc_url( $slides ); ?>" class="text-blue-600 hover:underline"><?php esc_html_e( 'Download', 'newmr-theme' ); ?></a>
												<?php endif; ?>
										</td>
								</tr>
						<?php endwhile; ?>
						</tbody>
				</table>
		<?php endif; ?>
		</main>
</section>
				<?php
	} else {
			$pres_query = new WP_Query(
				array(
					'post_type' => 'presentation',
					'name'      => $slug,
				)
			);

		if ( $pres_query->have_posts() ) {
				$pres_query->the_post();
			?>
<section id="primary" class="content-area content-width">
		<main id="content" class="prose mx-auto py-8" role="main">
				<?php get_template_part( 'content', 'presentation' ); ?>
		</main>
</section>
			<?php get_template_part( 'sidebar', 'presentation' ); ?>
					<?php
		}
	}
} else {
		$query = new WP_Query(
			array(
				'post_type'      => 'event',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => 'event_date_from',
						'value'   => time(),
						'compare' => '<',
					),
					array(
						'key'     => 'event_play_again',
						'value'   => 'yes',
						'compare' => '=',
					),
				),
				'meta_key'       => 'event_date_to',
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
			)
		);
	?>
<section id="primary" class="content-area content-width py-8">
		<main id="content" class="space-y-8" role="main">
		<?php if ( $query->have_posts() ) : ?>
				<h1 class="text-3xl font-bold mb-6"><?php the_title(); ?></h1>
				<div class="grid gap-6 md:grid-cols-2">
				<?php
				while ( $query->have_posts() ) :
						$query->the_post();
					?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'flex gap-4 p-4 border rounded-lg shadow' ); ?>>
								<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
										<div class="flex-shrink-0">
												<?php the_post_thumbnail( array( 120, 120 ), array( 'class' => 'w-30 h-30 object-cover rounded' ) ); ?>
										</div>
								<?php endif; ?>
								<div>
										<h2 class="text-xl font-semibold">
												<a href="<?php echo esc_url( site_url( '/play-again/' . get_post()->post_name ) ); ?>" class="hover:underline">
														<?php the_title(); ?>
												</a>
										</h2>
										<?php
										$datestring_from = get_post_meta( get_the_ID(), 'event_date_from', true );
										$datestring_to   = get_post_meta( get_the_ID(), 'event_date_to', true );
										if ( $datestring_from ) :
											?>
												<p class="text-gray-500">
														<?php
														if ( $datestring_from === $datestring_to ) {
																echo esc_html( gmdate( 'j F Y', (int) $datestring_from ) );
														} elseif ( gmdate( 'F', (int) $datestring_from ) === gmdate( 'F', (int) $datestring_to ) ) {
																	echo esc_html( gmdate( 'j', (int) $datestring_from ) . ' - ' . gmdate( 'j F Y', (int) $datestring_to ) );
														} else {
																echo esc_html( gmdate( 'j F Y', (int) $datestring_from ) . ' - ' . gmdate( 'j F Y', (int) $datestring_to ) );
														}
														?>
												</p>
										<?php endif; ?>
								</div>
						</article>
				<?php endwhile; ?>
				</div>
		<?php endif; ?>
		</main>
</section>
		<?php
}
get_footer();
