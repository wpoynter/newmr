<article id="post-<?php the_ID(); ?>" <?php post_class('slim'); ?>>
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

			echo Flowplayer5_Shortcode::create_fp5_video_output($args);
		}
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fourwalls' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
</article><!-- #post -->