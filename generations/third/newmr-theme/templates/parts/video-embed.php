<?php
/**
 * Responsive video embed partial.
 *
 * @package NewMR
 */

$mp4  = get_post_meta( get_the_ID(), 'presentation_mp4file', true );
$webm = get_post_meta( get_the_ID(), 'presentation_webmfile', true );
$ogv  = get_post_meta( get_the_ID(), 'presentation_ogvfile', true );

if ( $mp4 || $webm || $ogv ) : ?>
<div class="aspect-w-16 aspect-h-9 mb-4">
<video class="w-full rounded-lg" controls preload="auto" loading="lazy">
	<?php if ( $mp4 ) : ?>
<source src="<?php echo esc_url( $mp4 ); ?>" type="video/mp4" />
	<?php endif; ?>
	<?php if ( $webm ) : ?>
<source src="<?php echo esc_url( $webm ); ?>" type="video/webm" />
	<?php endif; ?>
	<?php if ( $ogv ) : ?>
<source src="<?php echo esc_url( $ogv ); ?>" type="video/ogg" />
	<?php endif; ?>
</video>
</div>
<?php endif; ?>
