<?php get_header(); ?>

	<div id="primary" class="content-area content-width">
		<div id="content" class="site-content page-content-width" role="main">

			<header class="archive-header">
				<h1 class="archive-title">NewMR People</h1>
			</header><!-- .archive-header -->

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
				<?php get_template_part( 'excerpt', get_post_type() ); ?>
				<?php endif; ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>