<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Minileven
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php if ( have_posts() ) : // Start the loop ?>
					<?php while ( have_posts() ) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">
									<?php if ( '1' == get_option( 'wp_mobile_featured_images' ) && is_home() || is_search() || is_archive() ) : ?>
										<div class="entry-thumbnail">
											<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'jetpack' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="<?php the_ID(); ?>" class="minileven-featured-thumbnail"><?php the_post_thumbnail(); ?></a>
										</div><!-- .entry-thumbnail -->
									<?php endif; ?>
								</header><!-- .entry-header -->

								<div class="entry-content">
								<?php if ( '1' == get_option( 'wp_mobile_excerpt' ) && ( is_home() || is_search() || is_archive() ) ) : ?>
									<?php echo minileven_excerpt( 300 ); ?>
								<?php else : ?>
									<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'jetpack' ) ); ?>
								<?php endif; ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'jetpack' ) . '</span>', 'after' => '</div>' ) ); ?>
								</div><!-- .entry-content -->

								<footer class="entry-meta">
									<?php if ( 'post' == get_post_type() ) : ?>
										<?php minileven_posted_on(); ?>
									<?php endif; ?>
									<?php if ( comments_open() ) : ?>
									<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'jetpack' ) . '</span>', __( '<b>1</b> Reply', 'jetpack' ), __( '<b>%</b> Replies', 'jetpack' ) ); ?></span>
									<?php endif; // End if comments_open() ?>
									<?php edit_post_link( __( 'Edit', 'jetpack' ), '<span class="edit-link">', '</span>' ); ?>
								</footer><!-- #entry-meta -->
							</article><!-- #post-<?php the_ID(); ?> -->

					<?php endwhile; ?>

				<?php else : ?>
					<article id="post-0" class="post error404 not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'jetpack' ); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'jetpack' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-0 -->

				<?php endif; ?>

			</div><!-- #content -->

			<?php minileven_content_nav( 'nav-below' ); ?>

		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>