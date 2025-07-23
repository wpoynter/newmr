<?php
/**
 * Speaker card partial.
 *
 * @package NewMR
 */

?>
<article class="presenter flex items-center gap-3 mb-4">
<?php the_post_thumbnail( array( 80, 80 ), array( 'class' => 'rounded-full' ) ); ?>
<div>
<h2 class="font-semibold text-lg mb-1"><?php the_title(); ?></h2>
<?php
$company = get_post_meta( get_the_ID(), 'person_company', true );
if ( $company ) :
	?>
<span class="block text-sm text-gray-500"><?php echo esc_html( $company ); ?></span>
<?php endif; ?>
<?php
$country = get_post_meta( get_the_ID(), 'person_country', true );
if ( $country ) :
	?>
<span class="block text-sm text-gray-500"><?php echo esc_html( $country ); ?></span>
<?php endif; ?>
</div>
</article>
