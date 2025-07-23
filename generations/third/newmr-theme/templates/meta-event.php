<?php
/**
 * Display event metadata for single event pages.
 *
 * @package NewMR
 */

$start    = get_post_meta( get_the_ID(), 'event_date_from', true );
$end      = get_post_meta( get_the_ID(), 'event_date_to', true );
$free     = get_post_meta( get_the_ID(), 'event_free', true );
$pdf      = get_post_meta( get_the_ID(), 'event_pdf', true );
$external = get_post_meta( get_the_ID(), 'event_external', true );

$has_meta = $start || $end || $free || $pdf || $external;
if ( ! $has_meta ) {
	return;
}
?>
<!-- wp:group {"className":"mt-4"} -->
<div class="mt-4">
	<dl class="grid grid-cols-1 text-base/6 sm:grid-cols-[min(50%,--spacing(80))_auto] sm:text-sm/6">
		<?php if ( $start ) : ?>
		<dt class="col-start-1 border-t border-zinc-950/5 pt-3 text-zinc-500 first:border-none sm:border-t sm:border-zinc-950/5 sm:py-3 dark:border-white/5 dark:text-zinc-400 sm:dark:border-white/5">Date</dt>
		<dd class="pt-1 pb-3 text-zinc-950 sm:border-t sm:border-zinc-950/5 sm:py-3 dark:text-white dark:sm:border-white/5">
			<?php echo esc_html( gmdate( 'j F Y', (int) $start ) ); ?>
			<?php if ( $end && $end !== $start ) : ?>
			– <?php echo esc_html( gmdate( 'j F Y', (int) $end ) ); ?>
			<?php endif; ?>
		</dd>
		<?php endif; ?>
		<?php if ( $free ) : ?>
		<dt class="col-start-1 border-t border-zinc-950/5 pt-3 text-zinc-500 first:border-none sm:border-t sm:border-zinc-950/5 sm:py-3 dark:border-white/5 dark:text-zinc-400 sm:dark:border-white/5">Free</dt>
		<dd class="pt-1 pb-3 text-zinc-950 sm:border-t sm:border-zinc-950/5 sm:py-3 dark:text-white dark:sm:border-white/5">
						<?php echo 'yes' === strtolower( $free ) ? esc_html__( 'Yes', 'newmr-theme' ) : esc_html__( 'No', 'newmr-theme' ); ?>
		</dd>
		<?php endif; ?>
		<?php if ( $pdf ) : ?>
		<dt class="col-start-1 border-t border-zinc-950/5 pt-3 text-zinc-500 first:border-none sm:border-t sm:border-zinc-950/5 sm:py-3 dark:border-white/5 dark:text-zinc-400 sm:dark:border-white/5">PDF</dt>
		<dd class="pt-1 pb-3 text-zinc-950 sm:border-t sm:border-zinc-950/5 sm:py-3 dark:text-white dark:sm:border-white/5">
			<a class="text-blue-600 hover:underline" href="<?php echo esc_url( $pdf ); ?>">
								<?php esc_html_e( 'Download', 'newmr-theme' ); ?>
			</a>
		</dd>
		<?php endif; ?>
		<?php if ( $external ) : ?>
		<dt class="col-start-1 border-t border-zinc-950/5 pt-3 text-zinc-500 first:border-none sm:border-t sm:border-zinc-950/5 sm:py-3 dark:border-white/5 dark:text-zinc-400 sm:dark:border-white/5">Website</dt>
		<dd class="pt-1 pb-3 text-zinc-950 sm:border-t sm:border-zinc-950/5 sm:py-3 dark:text-white dark:sm:border-white/5">
			<a class="text-blue-600 hover:underline" href="<?php echo esc_url( $external ); ?>">
								<?php esc_html_e( 'Visit', 'newmr-theme' ); ?>
			</a>
		</dd>
		<?php endif; ?>
	</dl>
</div>
<!-- /wp:group -->

