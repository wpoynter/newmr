<?php
$connected = new WP_Query(array(
	'connected_type' => 'presentation_to_person',
	'connected_items' => get_post(),
	'nopaging' => true,
));

?>

<?php get_header(); ?>

	<div id="primary" class="content-area content-width">
		<div id="content" class="site-content single page-content-width" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<div class="entry-thumbnail">
							<?php the_post_thumbnail('thumbnail'); ?>
						</div>

						<h1 class="entry-title"><?php the_title(); ?></h1>
						<span class="company"><?php echo get_post_meta(get_the_ID(), 'person_company', true); ?></span>
						<span class="country"><?php echo get_post_meta(get_the_ID(), 'person_country', true); ?></span>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<h4>Biography</h4>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fourwalls' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'fourwalls' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->
				
				<div class="presentations-list">
				    <table>
						<tr class="headers"><th class="speaker-col">Speaker</th><th class="title-col">Title</th><th class="watch-col">Video</th><th class="download-col">Slides</th></tr>
					<?php /* The loop */ ?>
					<?php while ($connected->have_posts()) : $connected->the_post(); ?>
					<?php get_template_part( 'row', 'presentation' ); ?>
					<?php endwhile; ?>
					</table>
				</div>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>