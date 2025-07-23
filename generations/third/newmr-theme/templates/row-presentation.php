<?php
/**
 * Presentation row partial.
 *
 * Displays speakers, title, watch link and slide download link.
 *
 * @package NewMR
 */

$connected = new WP_Query(
	array(
		'connected_type'  => 'presentation_to_person',
		'connected_items' => get_post(),
		'nopaging'        => true,
	)
);
$persons   = array();
while ( $connected->have_posts() ) {
	$connected->the_post();
	$persons[] = '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
}
wp_reset_postdata();
$people = implode( ', ', $persons );
$slides = get_post_meta( get_the_ID(), 'presentation_slides', true );
?>
<tr>
<td class="speaker-col p-2"><?php echo wp_kses_post( $people ); ?></td>
<td class="title-col p-2"><a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a></td>
<td class="watch-col p-2"><a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline">Watch</a></td>
<td class="download-col p-2">
<?php if ( $slides ) : ?>
<a href="<?php echo esc_url( $slides ); ?>" class="text-blue-600 hover:underline">Download</a>
<?php endif; ?>
</td>
</tr>
