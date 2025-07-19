<?php if (strlen(get_the_content()) > 1): ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-excerpt">
		<?php the_excerpt(); ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fourwalls' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
</article><!-- #post -->

<?php endif; ?>