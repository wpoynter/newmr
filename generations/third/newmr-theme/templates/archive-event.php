<?php
/**
 * Event archive template with custom loops.
 *
 * @package NewMR
 */

get_header();
?>
<main id="content" class="prose mx-auto py-8 space-y-12">
<?php
$today_end = mktime( 23, 59, 59 );

$base_args = array(
	'post_type'      => 'event',
	'posts_per_page' => -1,
	'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => 'event_events_page',
				'value'   => 'yes',
				'compare' => '=',
			),
	),
);

$upcoming = new WP_Query(
	array_merge(
		$base_args,
		array(
			'meta_query' => array_merge( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				$base_args['meta_query'],
				array(
														array(
															'key' => 'event_date_to',
															'value' => $today_end,
															'compare' => '>=',
														),
													)
			),
			'meta_key'   => 'event_date_to', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'orderby'    => 'meta_value_num',
			'order'      => 'ASC',
		)
	)
);

$open = new WP_Query(
	array_merge(
		$base_args,
		array(
			'meta_query' => array_merge( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				$base_args['meta_query'],
				array(
					array(
						'key'     => 'event_date_from',
						'value'   => '',
						'compare' => '=',
					),
					array(
						'key'     => 'event_date_to',
						'value'   => '',
						'compare' => '=',
					),
				)
			),
		)
	)
);

$past = new WP_Query(
	array_merge(
		$base_args,
		array(
			'meta_query' => array_merge( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				$base_args['meta_query'],
				array(
														array(
															'key' => 'event_date_to',
															'value' => $today_end,
															'compare' => '<',
														),
														array(
															'key' => 'event_date_to',
															'value' => '',
															'compare' => '!=',
														),
													)
			),
			'meta_key'   => 'event_date_to', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'orderby'    => 'meta_value_num',
			'order'      => 'DESC',
		)
	)
);
?>
<?php if ( $upcoming->have_posts() ) : ?>
	<section class="space-y-6">
	<h1 class="text-3xl font-bold"><?php esc_html_e( 'Upcoming Events', 'newmr' ); ?></h1>
	<div class="space-y-8">
		<?php
		while ( $upcoming->have_posts() ) :
			$upcoming->the_post();
			get_template_part( 'excerpt', 'event' );
		endwhile;
		?>
	</div>
	</section>
<?php endif; ?>

<?php if ( $open->have_posts() ) : ?>
	<section class="space-y-6">
	<h1 class="text-3xl font-bold"><?php esc_html_e( 'Open Events', 'newmr' ); ?></h1>
	<div class="space-y-8">
		<?php
		while ( $open->have_posts() ) :
			$open->the_post();
			get_template_part( 'excerpt', 'event' );
		endwhile;
		?>
	</div>
	</section>
<?php endif; ?>

<?php if ( $past->have_posts() ) : ?>
		<?php
		$years = array();
		while ( $past->have_posts() ) :
				$past->the_post();
				$date_string = get_post_meta( get_the_ID(), 'event_date_from', true );
				$event_year  = $date_string ? gmdate( 'Y', $date_string ) : get_the_date( 'Y' );
			if ( ! in_array( $event_year, $years, true ) ) :
				if ( ! empty( $years ) ) :
						echo '</div></section>'; // Close previous section.
					endif;
					$years[] = $event_year;
				?>
						<section class="space-y-6">
								<h1 class="text-3xl font-bold mt-8"><?php echo esc_html( $event_year ); ?></h1>
								<div class="space-y-8">
						<?php
				endif;
				get_template_part( 'excerpt', 'event' );
		endwhile;
		?>
								</div>
						</section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</main>
<?php
get_footer();
