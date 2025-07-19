<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php 
		$content = get_the_content(); 
		if (strlen($content) > 0 ) 
			the_content();
		else {
			$mp4 = get_post_meta(get_the_ID(), 'prensentation_mp4file', true);
			$webm = get_post_meta(get_the_ID(), 'prensentation_webmfile', true);
			$ogv = get_post_meta(get_the_ID(), 'prensentation_ogvfile', true);
			$args = array(
				'webm' => $webm,
				'mp4' => $mp4,
				'ogg' => $ogv,
				'preload' => 'auto'
			);
			echo apply_filters('the_content', '[videojs mp4="' . $mp4 . '" ogg="' . $ogv . '" webm="' . $webm . '" preload="auto" width="640" height="480"]')
			?>
			<?php
		}
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fourwalls' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta  page-content-width">
		<?php edit_post_link( __( 'Edit', 'fourwalls' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->