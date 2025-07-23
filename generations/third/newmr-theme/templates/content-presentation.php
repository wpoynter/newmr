<?php
/**
 * Presentation content template.
 *
 * @package NewMR
 */

?>

<!-- wp:group {"tagName":"article","className":"prose"} -->
<article class="prose">
	<!-- wp:post-title {"level":2,"isLink":true,"className":"mb-2"} /-->

	<!-- wp:html -->
	<?php
	$content = trim( get_the_content() );
	if ( $content ) {
		the_content(); } else {
		$mp4      = get_post_meta( get_the_ID(), 'presentation_mp4file', true );
			$webm = get_post_meta( get_the_ID(), 'presentation_webmfile', true ); $ogv =
			get_post_meta( get_the_ID(), 'presentation_ogvfile', true ); if ( $mp4 ||
			$webm || $ogv ) {
				?>
	<video class="w-full rounded" controls preload="auto">
				<?php if ( $mp4 ) : ?>
	<source src="<?php echo esc_url( $mp4 ); ?>" type="video/mp4" />
	<?php endif; ?> <?php if ( $webm ) : ?>
	<source src="<?php echo esc_url( $webm ); ?>" type="video/webm" />
	<?php endif; ?> <?php if ( $ogv ) : ?>
	<source src="<?php echo esc_url( $ogv ); ?>" type="video/ogg" />
	<?php endif; ?>
	</video>
				<?php
			}
		}
		?>
	<!-- /wp:html -->

	<!-- wp:html -->
	<?php
	$slides = get_post_meta( get_the_ID(), 'presentation_slides', true ); if ( $slides ) :
		?>
	<div class="mt-4">
	<a class="btn text-sm" href="<?php echo esc_url( $slides ); ?>">
		<?php esc_html_e( 'Download Slides', 'newmr' ); ?>
	</a>
	</div>
	<?php endif; ?>
	<!-- /wp:html -->
</article>
<!-- /wp:group -->
