<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package gatsby
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gatsby_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_front_page() || is_home() ) {
		$homepage_layout = esc_attr( get_theme_mod( 'gatsby_homepage_layout', 'default' ) );
		$classes[] = 'homepage-'.$homepage_layout;
	}

	if ( is_page_template( 'template-fullwidth.php' )) {
		$classes[] = 'full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'gatsby_body_classes' );



function gatsby_no_thumbnail_class( $classes ) {
	global $post;
	if ( ! has_post_thumbnail( $post->ID ) ) {
		$classes[] = 'no-post-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'gatsby_no_thumbnail_class' );

/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
if ( ! function_exists( 'gatsby_custom_excerpt_length' ) ) :
function gatsby_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'gatsby_custom_excerpt_length', 999 );
endif;

if ( ! function_exists( 'gatsby_excerpt_more' ) ) :
function gatsby_excerpt_more( $more ) {
	return sprintf( '... <a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( '[Continue Reading]', 'gatsby' )
    );
}
add_filter( 'excerpt_more', 'gatsby_excerpt_more' );
endif;



/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function gatsby_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="search-form" action="' . esc_url( home_url( '/' ) ) . '" >
    <label for="s">
		<span class="screen-reader-text">' . __( 'Search for:', 'gatsby' ) . '</span>
		<input type="text" class="search-field" placeholder="'. esc_attr__( 'Search', 'gatsby' ) .'" value="' . get_search_query() . '" name="s" id="s" />
	</label>
	<button type="submit" class="search-submit">
        <i class="fa fa-search"></i>
    </button>
    </form>';

    return $form;
}
add_filter( 'get_search_form', 'gatsby_search_form' );
