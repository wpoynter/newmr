<?php get_header(); ?>

<div id="primary" class="content-area content-width">
	<div id="content" class="site-content  page-content-width" role="main">

		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part('content', 'presentation'); ?>
		
		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_template_part('sidebar', 'presentation'); ?>

<?php get_footer(); ?>