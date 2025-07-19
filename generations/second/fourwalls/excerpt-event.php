<article id="post-<?php the_ID(); ?>" <?php post_class();  ?>>
	<div class="entry-excerpt">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('Event'); ?></a>
		</div>
		<?php endif; ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<h4 class="entry-title">
				<?php the_title(); ?>
			</h4>
		</a>
		<?php 
			$datestring_from = get_post_meta(get_the_ID(), 'event_date_from', true);
			$datestring_to = get_post_meta(get_the_ID(), 'event_date_to', true);
			if (strlen($datestring_from) > 1) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark"><span>
			<?php if ($datestring_from == $datestring_to)
				echo date("jS F", $datestring_from);
			else {
				if (date("F", $datestring_from) == date("F", $datestring_to))
					echo date("jS", $datestring_from) . ' - ' . date("jS F", $datestring_to);
				else
					echo date("jS F", $datestring_from) . ' - ' . date("jS F", $datestring_to);
			} ?>
		</span></a>
			<?php endif;
		?>
		<a href="<?php the_permalink(); ?>" rel="bookmark" class="cover"></a>

	</div><!-- .entry-excerpt -->

</article><!-- #post -->
