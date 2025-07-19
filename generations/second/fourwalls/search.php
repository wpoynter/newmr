<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage fourwalls
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area content-width">
		<main id="search-main" class="site-main">

		<?php if ( have_posts() ) :
		
		    $blog_posts    = array();
		    $events        = array();
		    $presentations = array();
		
		    while ( have_posts() ) :
		        the_post();
		        if (get_post_type() == 'post') :
		          array_push($blog_posts, $post);
		        elseif (get_post_type() == 'event') :
		            array_push($events, $post);
		        elseif (get_post_type() == 'presentation') :
		            array_push($presentations, $post);
		        endif;
		    endwhile;
		    
		    ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php _e( 'Search results for: ' ); ?><?php echo get_search_query(); ?>
				</h1>
			</header><!-- .page-header -->

			<article id="blogs-found" class="objects-found">
				<header>
				    <?php if (count($blog_posts) > 0) : ?>
					<a href="javascript://" onClick="jQuery('#blog-object-container').toggle(); return false;">
						<h2><?php echo count($blog_posts) ?> blog post<?php if (count($blog_posts) != 1) : echo 's'; endif ?> found</h2>
					</a>
					<?php else : ?>
					    <h2>No blog posts found</h2>
					<?php endif; ?>
				</header>
				<div id="blog-object-container" class="object-container">
				<?php
				foreach ($blog_posts as $post) :
			        get_template_part( 'excerpt', '' );
			    endforeach;

				?>
				</div>
			</article>
			<article id="press-found" class="objects-found">
				<header>
				    <?php if (count($presentations) > 0) : ?>
					<a href="javascript://" onClick="jQuery('#pres-object-container').toggle(); return false;">
						<h2><?php echo count($presentations) ?> presentation<?php if (count($presentations) != 1) : echo 's'; endif ?> found</h2>
					</a>
					<?php else : ?>
					    <h2>No presentations found</h2>
					<?php endif; ?>
				</header>
				<div id="pres-object-container" class="object-container">
					<table>
						<tr class="headers">
							<th class="speaker-col">Speaker</th>
							<th class="title-col">Title</th>
							<th class="watch-col">Watch<br/>Now</th>
							<th class="download-col">Download<br/>Slides</th>
						</tr>
						<?php 
						
						foreach ($presentations as $post) :
        			        get_template_part( 'row', 'presentation' );
        			    endforeach;
						
						?>
						</table>
					</div>
				</article>
				<article id="events-found" class="objects-found">
					<?php /* Event loop */ ?>
					<header>
					    <?php if (count($events) > 0) : ?>
						<a href="javascript://" onClick="jQuery('#event-object-container').toggle(); return false;">
							<h2><?php echo count($events) ?> event<?php if (count($events) != 1) : echo 's'; endif ?> found</h2>
						</a>
						<?php else : ?>
						    <h2>No events found</h2>
						<?php endif; ?>
					</header>
					<div id="event-object-container" class="object-container">
					<?php
					
					foreach ($events as $post) :
    			        get_template_part( 'excerpt', 'event' );
    			    endforeach;

					?>
					</div>
				</article>
				<?php

			// If no content, include the "No posts found" template.
		else :
			?> <h2>No results</h2> <?php

		endif;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
