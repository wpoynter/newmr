<?php
/**
 * Search results template grouping posts by type.
 *
 * @package NewMR
 */

get_header();
?>
<section id="primary" class="content-area content-width">
	<main id="search-main" class="prose mx-auto py-8">
<?php
if ( have_posts() ) :
	$blog_posts    = array();
	$events        = array();
	$presentations = array();
	while ( have_posts() ) :
		the_post();
		switch ( get_post_type() ) {
			case 'post':
				$blog_posts[] = get_post();
				break;
			case 'event':
				$events[] = get_post();
				break;
			case 'presentation':
				$presentations[] = get_post();
				break;
		}
	endwhile;
	?>
	<header class="mb-6">
		<h1 class="text-3xl font-bold">
	<?php
		esc_html_e( 'Search results for: ', 'newmr-theme' );
	echo esc_html( get_search_query() );
	?>
		</h1>
	</header>
	<article id="blogs-found" class="objects-found mb-8">
		<header>
		<h2>
			<?php echo $blog_posts ? count( $blog_posts ) . ' blog post' . ( count( $blog_posts ) !== 1 ? 's' : '' ) . ' found' : 'No blog posts found'; ?>
		</h2>
		</header>
		<?php if ( $blog_posts ) : ?>
		<div class="space-y-6">
			<?php
			foreach ( $blog_posts as $blog_post ) :
				setup_postdata( $blog_post );
				?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'prose' ); ?>>
			<!-- wp:post-title {"level":2,"isLink":true,"className":"mb-2"} /-->
			<!-- wp:post-excerpt /-->
			</article>
				<?php
		endforeach;
			wp_reset_postdata();
			?>
		</div>
		<?php endif; ?>
	</article>
	<article id="press-found" class="objects-found mb-8">
		<header>
		<h2>
			<?php echo $presentations ? count( $presentations ) . ' presentation' . ( count( $presentations ) !== 1 ? 's' : '' ) . ' found' : 'No presentations found'; ?>
		</h2>
		</header>
		<?php if ( $presentations ) : ?>
		<table class="min-w-full divide-y divide-gray-200">
		<thead>
			<tr class="bg-gray-50">
			<th class="speaker-col p-2 text-left">Speaker</th>
			<th class="title-col p-2 text-left">Title</th>
			<th class="watch-col p-2">Watch</th>
			<th class="download-col p-2">Download Slides</th>
			</tr>
		</thead>
		<tbody class="bg-white divide-y divide-gray-200">
			<?php
			foreach ( $presentations as $presentation_post ) :
				setup_postdata( $presentation_post );
				?>
			<tr>
			<td class="speaker-col p-2">
				<?php
				$connected           = new WP_Query(
					array(
						'connected_type'  => 'presentation_to_person',
						'connected_items' => $presentation_post,
						'nopaging'        => true,
					)
				);
							$persons = array();
				while ( $connected->have_posts() ) {
					$connected->the_post();
					$persons[] = '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
				}
							wp_reset_postdata();
				echo wp_kses_post( implode( ', ', $persons ) );
				?>
			</td>
			<td class="title-col p-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
			<td class="watch-col p-2"><a href="<?php the_permalink(); ?>">Watch</a></td>
			<td class="download-col p-2">
				<?php
				$slides = get_post_meta( get_the_ID(), 'presentation_slides', true );
				if ( $slides ) :
					?>
				<a href="<?php echo esc_url( $slides ); ?>">Download</a>
				<?php endif; ?>
			</td>
			</tr>
							<?php
			endforeach;
			wp_reset_postdata();
			?>
		</tbody>
		</table>
		<?php endif; ?>
	</article>
	<article id="events-found" class="objects-found mb-8">
		<header>
		<h2>
			<?php echo $events ? count( $events ) . ' event' . ( count( $events ) !== 1 ? 's' : '' ) . ' found' : 'No events found'; ?>
		</h2>
		</header>
		<?php if ( $events ) : ?>
		<div class="space-y-6">
			<?php
			foreach ( $events as $event_post ) :
				setup_postdata( $event_post );
				?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'prose' ); ?>>
				<!-- wp:post-title {"level":2,"isLink":true,"className":"mb-2"} /-->
				<!-- wp:post-excerpt /-->
			</article>
				<?php
			endforeach;
			wp_reset_postdata();
			?>
		</div>
		<?php endif; ?>
	</article>
<?php else : ?>
		<h2><?php esc_html_e( 'No results', 'newmr-theme' ); ?></h2>
<?php endif; ?>
	</main>
</section>
<?php
get_footer();
