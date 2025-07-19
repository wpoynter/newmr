<?php

get_header();

?>

	<div id="primary" class="content-area content-width">
		<div id="content" class="site-content" role="main">
		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'excerpt', get_post_format() ); ?>
			<?php endwhile; ?>


		<?php else : ?>
			<?php get_template_part( 'excerpt', 'none' ); ?>
		<?php endif; ?>

		<?php paging_nav(); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php

get_footer();

?>
