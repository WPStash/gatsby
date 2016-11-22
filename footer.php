<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gatsby
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php if ( is_active_sidebar( 'footer' ) ) { ?>
		<div class="footer-widgets">
			<div class="container">
				<?php
						dynamic_sidebar( 'footer' );
				?>
			</div>
		</div>
		<?php } ?>

		<div class="site-info">
			<div class="container">

				<div class="site-copyright">
					<?php printf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'gatsby' ), date('Y'), get_bloginfo( 'name' ) ); ?>
				</div>

				<div class="theme-info">
						<?php do_action('gatsby_theme_info'); ?>
				</div>

			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
