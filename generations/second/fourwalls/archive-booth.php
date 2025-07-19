<?php get_header(); ?>

	<div id="primary" class="content-area content-width">
		<div id="content" class="site-content" role="main">

			<header class="archive-header">
				<h1 class="archive-title">eXhibition</h1>
			</header><!-- .archive-header -->

			<?php /* The loop */ $postCol = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $postCol++; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('col-' . $postCol); ?>>
					<div class="entry-content">
						<?php 
							$link = get_post_meta(get_the_ID(), 'booth_link', true);
							if (strlen($link) > 1) :
							?>
						<a href="<?php echo $link; ?>"
						   onClick="ga('send', 'event', 'Booth', 'Click', '<?php the_title(); ?>');" 
						   target="_blank" >
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fourwalls' ) ); ?>
						</a>
						<?php else : ?>
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fourwalls' ) ); ?>
						<?php endif; ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
				<?php if ($postCol > 2) $postCol = 0; ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>