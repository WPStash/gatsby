<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package gatsby
 */

if ( ! function_exists( 'gatsby_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function gatsby_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( ' on %s', 'post date', 'gatsby' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'gatsby' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	$categories_list = get_the_category_list( esc_html__( ', ', 'gatsby' ) );
	$posted_in = sprintf( esc_html__( ' in %1$s', 'gatsby' ),  $categories_list);


	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span><span class="posted-in">' . $posted_in . '</span>'; // WPCS: XSS OK.

}
endif;


if ( ! function_exists( 'gatsby_posted_on_second' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function gatsby_posted_on_second() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( ' on %s', 'post date', 'gatsby' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'gatsby' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	$categories_list = get_the_category_list( esc_html__( ', ', 'gatsby' ) );
	$posted_in = sprintf( esc_html__( ' in %1$s', 'gatsby' ),  $categories_list);


	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}
endif;


if ( ! function_exists( 'gatsby_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function gatsby_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$category_list = get_the_category_list( esc_html__( ', ', 'gatsby' ) );
		$tag_list      = get_the_tag_list( '', ', ', '' );
		if (  $tag_list != '' ) {
			echo '<div class="entry-taxonomies">';
			if ( $category_list ) {
				echo '<div class="entry-categories">';
					echo '<span>'. esc_html__( 'Posted in', 'gatsby' ) .'</span>';
					echo ' ' . $category_list;
				echo '</div>';
			}
			if ( $tag_list ) {
				echo '<div class="entry-tags">';
					echo '<span>'. esc_html__( 'Tagged in', 'gatsby' ) .'</span>';
					echo ' ' . $tag_list;
				echo '</div>';
			}
			echo '</div>';
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function gatsby_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'gatsby_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'gatsby_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so gatsby_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so gatsby_categorized_blog should return false.
		return false;
	}
}

if ( ! function_exists( 'gatsby_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own gatsby_comments(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @return void
 */
 function gatsby_comments( $comment, $args, $depth ) {
 	$GLOBALS['comment'] = $comment;
 	switch ( $comment->comment_type ) :
 		case 'pingback' :
 		case 'trackback' :
 	?>
 	<li class="pingback">
 		<p><?php _e( 'Pingback:', 'gatsby' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'gatsby' ), ' ' ); ?></p>
 	<?php
 			break;
 		default :
 	?>
 	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
 		<article id="comment-<?php comment_ID(); ?>" class="comment">
 			<div class="comment-author vcard">
 				<?php echo get_avatar( $comment, 60 ); ?>
 				<?php //printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
 			</div><!-- .comment-author .vcard -->

 			<div class="comment-wrapper">
 				<?php if ( $comment->comment_approved == '0' ) : ?>
 					<em><?php _e( 'Your comment is awaiting moderation.', 'gatsby' ); ?></em>
 				<?php endif; ?>

 				<div class="comment-meta comment-metadata">
 					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
 					<?php
 						/* translators: 1: date, 2: time */
 						printf( __( '%1$s at %2$s', 'gatsby' ), get_comment_date(), get_comment_time() ); ?>
 					</time></a>
 				</div><!-- .comment-meta .commentmetadata -->
 				<div class="comment-content"><?php comment_text(); ?></div>
 				<div class="comment-actions">
 					<?php comment_reply_link( array_merge( array( 'after' => '<i class="fa fa-reply"></i>' ), array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
 				</div><!-- .reply -->
 			</div> <!-- .comment-wrapper -->

 		</article><!-- #comment-## -->

 	<?php
 			break;
 	endswitch;
 }
endif;

/**
 * Flush out the transients used in gatsby_categorized_blog.
 */
function gatsby_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'gatsby_categories' );
}
add_action( 'edit_category', 'gatsby_category_transient_flusher' );
add_action( 'save_post',     'gatsby_category_transient_flusher' );


if ( ! function_exists( 'gatsby_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Twenty Sixteen 1.2
 */
function gatsby_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;


/**
 * Output the theme info to 'gatsby_theme_info' hook.
 */
if ( ! function_exists( 'gatsby_footer_credit' ) ) {
    /**
     * Add Copyright and Credit text to footer
     */
    function gatsby_footer_credit()
    {
        ?>
		<span class="theme-info-text">
        <?php printf( esc_html__( 'Gatsby Theme by %1$s', 'gatsby' ), '<a href="https://freeresponsivethemes.com/" rel="nofollow">FRT</a>' ); ?>
		</span>
        <?php
    }
}
add_action( 'gatsby_theme_info', 'gatsby_footer_credit' );
