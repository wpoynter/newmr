		</div><!-- #main -->
		<footer id="mastfoot" class="site-footer" role="contentinfo">
			<div class="site-info">
				<?php do_action( 'fourwalls_credits' ); ?>
				<?php left_footer_link(); ?>
				<a href="<?php echo esc_url( __( 'http://www.thefutureplace.com/', 'fourwalls' ) ); ?>" title="<?php esc_attr_e( 'The Future Place Website', 'fourwalls' ); ?>"><?php printf( __( 'Owned by %s', 'fourwalls' ), '<strong>The Future Place</strong>' ); ?></a>
				<?php right_footer_link(); ?>
			</div><!-- .site-info -->
		</footer><!-- #mastfoot -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>