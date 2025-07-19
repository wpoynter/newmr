<?php

get_header();

?>

	<div id="primary" class="content-area content-width">
		<div id="content" class="site-content" role="main">
			
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class("front"); ?>>
					<header class="entry-header">
						
					</header><!-- .entry-header -->

					<div class="entry-content md:gap-4">
					    <div id="row-1">
					        <div id="box-1" class="front-page-box">
							<?php the_content(); ?>
						</div>
						<div id="box-2" class="front-page-box front-advert-container"><?php
							remove_all_filters('posts_orderby');
							$adverts_query = new WP_Query(
									array ( 
										'nopaging'  => true,
										'post_type' => 'advert',
										'orderby'   => 'menu_order'
							));
							if ( $adverts_query->have_posts() ) : $advert_pos = 0;
								while ($adverts_query->have_posts()) : $adverts_query->the_post();
									$site = get_post_meta(get_the_ID(), 'advert_site', true);
									$link = get_post_meta(get_the_ID(), 'advert_link', true);
									if ($site == "yes") : $advert_pos++; ?>
							<div class="moving-advert-wrapper <?php echo ($advert_pos < 4) ? "pos-" . $advert_pos : "oov"; ?>" >
								<a href="<?php echo $link; ?>" 
								   onClick="ga('send', 'event', 'Advert', 'Click', '<?php the_title(); ?>');" 
								   target="_blank" >
										<?php the_content(); ?>
								</a>
							</div>
									<?php endif;
								endwhile;
								wp_reset_postdata();
							endif;
						?></div>
					    </div>
					    <div id="row-2">
					        <div id="box-3" class="front-page-box">
							<?php donate_box(); ?>
						</div>
						<div id="box-4" class="front-page-box"><?php
							remove_all_filters('posts_orderby');
							$args = array ( 
								'orderby' => 'rand',
								'posts_per_page' => '1',
								'post_type' => 'presentation'
							);
							$featured_video = get_option("fourwalls_featured_video");
							if (strlen($featured_video) > 1)
								$args['name'] = $featured_video;
							$presentation_query = new WP_Query($args);
						
							if ( $presentation_query->have_posts() ) :
								while ($presentation_query->have_posts()) : $presentation_query->the_post();
									?>
									<?php get_template_part('slim', 'presentation'); ?>
								<?php endwhile;
								wp_reset_postdata();
							endif;
						?></div>
						<div id="box-5" class="front-page-box"><?php
							remove_all_filters('posts_orderby');
							$booth_query = new WP_Query(
									array ( 
										'orderby' => 'rand',
										'posts_per_page' => '1',
										'post_type' => 'booth'
							));
							if ( $booth_query->have_posts() ) :
								while ($booth_query->have_posts()) : $booth_query->the_post();
									$link = get_post_meta(get_the_ID(), 'booth_link', true);
									if (strlen($link) > 1) :
									?>
									<a href="<?php echo $link; ?>" 
									   onClick="ga('send', 'event', 'Booth', 'Click', '<?php the_title(); ?>');" 
									   target="_blank" >
									<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fourwalls' ) ); ?>
									</a>
									<?php else : ?>
									<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fourwalls' ) ); ?>
									<?php endif;
								endwhile;
								wp_reset_postdata();
							endif;
						?></div>
					    </div>
					    <div id="row-3">
					        <div id="box-6" class="front-page-box"><?php
						
    						function custom_excerpt_length( $length ) {
    							return 30;
    						}
    						add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
    						
    						$blog_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => '1'));
    						if ($blog_query->have_posts()) :
    							while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
    								
    							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    								<header class="entry-header">
    									<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
    									<div class="entry-thumbnail">
    										<a href="<?php the_permalink(); ?>" rel="bookmark">
    											<?php the_post_thumbnail(); ?>
    										</a>
    									</div>
    									<?php endif; ?>
    
    									<?php if ( is_single() ) : ?>
    									<h1 class="entry-title"><?php the_title(); ?></h1>
    									<?php else : ?>
    									<h1 class="entry-title">
    										<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
    									</h1>
    									<?php endif; // is_single() ?>
    
    								</header><!-- .entry-header -->
    
    								<div class="entry-excerpt">
    									<?php the_excerpt(); ?>
    									<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fourwalls' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
    								</div><!-- .entry-content -->
    
    								<footer class="entry-meta">
    									<?php if ( comments_open() && ! is_single() ) : ?>
    										<div class="comments-link">
    											<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'fourwalls' ) . '</span>', __( 'One comment so far', 'fourwalls' ), __( 'View all % comments', 'fourwalls' ) ); ?>
    										</div><!-- .comments-link -->
    									<?php endif; // comments_open() ?>
    
    									<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
    										<?php get_template_part( 'author-bio' ); ?>
    									<?php endif; ?>
    								</footer><!-- .entry-meta -->
    							</article><!-- #post -->
    							
    							<?php endwhile;
    						endif;
    						
    						?></div>
    						<div id="box-7" class="front-page-box">
    							<?php about_newmr_box(); ?>
    						</div>
					    </div>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

			<?php endwhile; ?>
			
		</div><!-- #content -->
	</div><!-- #primary -->
		
<?php		
		
get_footer();

?>