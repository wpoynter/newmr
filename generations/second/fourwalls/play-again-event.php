<?php
$connected = new WP_Query(array(
	'connected_type' => 'presentation_to_event',
	'connected_items' => get_post(),
	'nopaging' => true,
));

if ($connected->post_count > 0):

?>

<article id="post-<?php the_ID(); ?>" <?php post_class();  ?> itemscope itemtype="http://schema.org/Event">
    <meta itemprop="location" content="Virtual"/>
	<div class="entry-excerpt">

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(array(120,120)); ?>
		</div>
		<?php endif; ?>

		<h2 class="entry-title" itemprop="name">
			<?php the_title(); ?>
		</h2>
		<?php 
			$datestring_from = get_post_meta(get_the_ID(), 'event_date_from', true);
			$datestring_to = get_post_meta(get_the_ID(), 'event_date_to', true);
			if (strlen($datestring_from) > 1) : ?>
		<span itemprop="startDate" content="<?php echo date("Y-m-d",$datestring_from); ?>">
			<?php if ($datestring_from == $datestring_to)
				echo date("j F Y", $datestring_from);
			else {
				if (date("F", $datestring_from) == date("F", $datestring_to))
					echo date("j", $datestring_from) . ' - ' . date("j F Y", $datestring_to);
				else
					echo date("j F Y", $datestring_from) . ' - ' . date("j F Y", $datestring_to);
			} ?>
		</span>
			<?php endif; ?>
		<a href="<?php echo site_url('/play-again/' . get_post()->post_name) ?>" rel="bookmark" class="cover"></a>

	</div><!-- .entry-excerpt -->

</article><!-- #post -->

<?php endif; ?>