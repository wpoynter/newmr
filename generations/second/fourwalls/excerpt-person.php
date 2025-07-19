<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail(array(100,100)); ?>
			</a>
		</div>
		<h3 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"
			   onClick="ga('send', 'event', 'Person', 'Click', '<?php the_title(); ?>');" 
			   >
				<?php the_title(); ?>
			</a>
		</h3>
		<?php 
		
		$company = get_post_meta(get_the_ID(), 'person_company', true);
		$country = get_post_meta(get_the_ID(), 'person_country', true);
		
		if ($company) echo "<span class='company' >$company</span>";
		if ($country) echo "<span class='country' >$country</span>";
		?>
	</div><!-- .entry-content -->
</article><!-- #post -->