<article id="post-<?php the_ID(); ?>" <?php post_class();  ?>>
	<div class="entry-excerpt">

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(array(120,120)); ?>
		</div>
		<?php endif; ?>

		<h2 class="entry-title">
			<?php the_title(); ?>
		</h2>
		<?php 
			$datestring_from = get_post_meta(get_the_ID(), 'event_date_from', true);
			$datestring_to = get_post_meta(get_the_ID(), 'event_date_to', true);
			if (strlen($datestring_from) > 1) : ?>
		<span>
			<?php if ($datestring_from == $datestring_to)
				echo date("jS F", $datestring_from);
			else {
				if (date("F", $datestring_from) == date("F", $datestring_to))
					echo date("jS", $datestring_from) . ' - ' . date("jS F", $datestring_to);
				else
					echo date("jS F", $datestring_from) . ' - ' . date("jS F", $datestring_to);
			} ?>
		</span>
			<?php endif; ?>
		<?php 
			$event_free = get_post_meta(get_the_ID(), 'event_free', true);
			if ($event_free == 'yes') : ?>
		<span class="free-play-again">Free</span>
			<?php endif; ?>
		<a href="<?php echo site_url('/play-again/' . get_post()->post_name) ?>" rel="bookmark" class="cover"></a>

	</div><!-- .entry-excerpt -->

</article><!-- #post -->