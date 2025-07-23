<?php
/**
 * Speaker card partial.
 *
 * @package NewMR
 */

?>
<article class="speaker-card flex items-center gap-4 p-4 shadow rounded-lg">
		<figure class="flex items-center gap-4">
				<?php
				the_post_thumbnail(
					array( 96, 96 ),
					array(
						'class' => 'rounded-full w-24 h-24 object-cover',
						/* translators: %s: speaker name */
						'alt'   => sprintf( esc_attr__( 'Photo of %s', 'newmr' ), get_the_title() ),
					)
				);
				?>
				<figcaption>
						<h2 class="font-semibold text-lg mb-1"><?php the_title(); ?></h2>
						<?php
						$company = get_post_meta( get_the_ID(), 'person_company', true );
						if ( $company ) :
							?>
						<span class="block text-sm text-gray-500"><?php echo esc_html( $company ); ?></span>
						<?php endif; ?>
				</figcaption>
		</figure>
</article>
