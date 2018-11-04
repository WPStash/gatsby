<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Gatsby
 */
/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function gatsby_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'gatsby_infinite_scroll_render',
		'footer'    => 'page',
	) );
	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'gatsby_jetpack_setup' );
/**
 * Custom render function for Infinite Scroll.
 */
function gatsby_infinite_scroll_render() {
    $homepage_layout = esc_attr( get_theme_mod( 'gatsby_homepage_layout', 'default' ) );

    $count = 0;
	while ( have_posts() ) {
		the_post();
		if ( is_search() || is_archive() ) :

            get_template_part( 'template-parts/content', 'grid' );

		else :
            switch ( $homepage_layout ) {
                case 'home1':
                    get_template_part( 'template-parts/content', 'grid-large' );
                    break;

                case 'home2':
                    get_template_part( 'template-parts/content', 'grid' );
                    break;

                case 'home3':
                    if ( $count == 0) {
                        get_template_part( 'template-parts/content', 'grid-large' );
                    }
                    else {
                        get_template_part( 'template-parts/content', 'list' );
                    }
                    break;

                case 'home4':
                    if ( $count == 0) {
                        get_template_part( 'template-parts/content', 'grid-large' );
                    }
                    else {
                        get_template_part( 'template-parts/content', 'grid' );
                    }
                    break;

                case 'home5':
                    if ( $count == 0) {
                        get_template_part( 'template-parts/content', 'grid-large' );
                    }
                    elseif ( $count < 5 ) {
                        get_template_part( 'template-parts/content', 'grid' );
                    }
                    else {
                        get_template_part( 'template-parts/content', 'list' );
                    }
                    break;

                default:
                    get_template_part( 'template-parts/content', 'list' );
                    break;
            }
		endif;
        $count++;
	}
}
