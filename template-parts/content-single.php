<?php
/**
 * Template part for displaying page content in single.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gatsby
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php gatsby_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

    <?php if ( has_post_thumbnail() ) : ?>
    <div class="entry-thumb">
        <?php the_post_thumbnail( 'full' ); ?>
    </div>
    <?php endif; ?>

	<?php if ( ! empty ( get_the_content() ) ) { ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gatsby' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php } ?>

	<?php
	$prev_link = get_previous_post_link( '%link', '%title', true );
	$next_link = get_next_post_link( '%link', '%title', true );
	?>
	<?php if ( $prev_link || $next_link ) : ?>
	<div class="navigation">
		<div class="nav-links">
			<div class="nav-previous">
				<?php if ( $prev_link ) { ?>
				<span><?php esc_html_e( 'Previous article', 'gatsby' ) ?></span>
				<h5><?php echo $prev_link; ?></h5>
				<?php } ?>
			</div>
			<div class="nav-next">
				<?php if ( $next_link ) { ?>
				<span><?php esc_html_e( 'Next article', 'gatsby' ) ?></span>
				<h5><?php echo $next_link; ?></h5>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<footer class="entry-footer">
		<?php gatsby_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
