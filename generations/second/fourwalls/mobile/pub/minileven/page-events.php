<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Minileven
 */

$query = new WP_Query(array(
	'post_type' => 'event',
	'meta_query' => array(
		array(
			'key' => 'event_events_page',
			'value' => 'yes',
			'compare' => '='
		)
	),
	'posts_per_page'=> -1,
	'meta_key'		=> 'event_date_to',
	'orderby'		=> 'meta_value_num',
	'order'			=> 'DESC',
	'is_archive'	=> true
));

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<header class="page-header">
					<h1 class="page-title">
						Events
					</h1>
				</header>

				<?php if ( $query->is_search() ) : ?>
				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'jetpack' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
				<?php endif; ?>
				<?php if ( $query->have_posts() ) : // Start the loop ?>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'excerpt', 'event' ); ?>

					<?php endwhile; ?>

				<?php else : ?>
					<article id="post-0" class="post error404 not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'jetpack' ); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'jetpack' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-0 -->

				<?php endif; ?>

			</div><!-- #content -->

			<?php minileven_content_nav( 'nav-below' ); ?>

		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>