<?php
$connected = new WP_Query(array(
	'connected_type' => 'presentation_to_event',
	'connected_items' => get_post(),
	'nopaging' => true,
));

if ($connected->post_count > 0):

?>

<article id="post-<?php the_ID(); ?>" <?php post_class();  ?>>
	<div class="entry-excerpt">

		<?php if ( '1' == get_option( 'wp_mobile_featured_images' )) : ?>
			<div class="entry-thumbnail">
				<a href="<?php echo site_url('/play-again/' . get_post()->post_name) ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jetpack' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="<?php the_ID(); ?>" class="minileven-featured-thumbnail"><?php the_post_thumbnail(array(200,200)); ?></a>
			</div><!-- .entry-thumbnail -->
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
		&nbsp;|&nbsp;<span class="free-play-again">Free</span>
			<?php endif; ?>
		<a href="<?php echo site_url('/play-again/' . get_post()->post_name) ?>" rel="bookmark" class="cover"></a>

	</div><!-- .entry-excerpt -->

</article><!-- #post -->

<?php endif; ?>