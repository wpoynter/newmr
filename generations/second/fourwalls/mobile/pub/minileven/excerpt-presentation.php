<?php
/**
 * The default template for displaying content
 *
 * @package Minileven
 */

$connected = new WP_Query(array(
	'connected_type' => 'presentation_to_person',
	'connected_items' => get_post(),
	'nopaging' => true,
));
$title = get_the_title();
$permalink = get_permalink();
$slides = get_post_meta(get_the_ID(), 'presentation_slides', true);
$persons = array();
while ($connected->have_posts()) {
	$connected->the_post();
	$persons[] = '<a href="' . get_permalink() . '" >' . get_the_title() . '</a>';
}
wp_reset_postdata();
$people = implode(', ', $persons);
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( '1' == get_option( 'wp_mobile_featured_images' ) ) : ?>
				<div class="entry-thumbnail">
					<a href="<?php echo $permalink; ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jetpack' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="<?php the_ID(); ?>" class="minileven-featured-thumbnail"><?php the_post_thumbnail(); ?></a>
				</div><!-- .entry-thumbnail -->
			<?php endif; ?>
			<h3 class="entry-title"><a href="<?php echo $permalink; ?>" rel="bookmark"><?php echo $title; ?></a></h3>
		</header><!-- .entry-header -->

		<div class="entry-content">
			
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<?php echo $people; ?><?php echo (strlen($slides) > 1 ? '&nbsp;|&nbsp;<a href="' . $slides . '">Download Slides</a>' : ''); ?>
			<?php edit_post_link( __( 'Edit', 'jetpack' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- #entry-meta -->
	</article><!-- #post-<?php the_ID(); ?> -->