<?php
/**
 * Sushi Wordpress Starter 3.0 Theme Comments.
 *
 * @author Sushi Katana team
 * @copyright 2013 Sushi Digital Pty. Ltd.
 * @since Sashimi 3.0
 * @package WordPress
 * @subpackage Sushi_WP
 */
  
function single_list_comment( $comment, $args, $depth )
{
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-wrap">
			<div class="comment-author vcard">
			<?php echo get_avatar( $comment, $size = '78' ); ?>			
			</div>
			<div class="comment-blurb left">
				<div class="comment-meta commentmetadata">
					<?php echo sprintf( '<b class="fn"> %s</b>', get_comment_author_link() ); ?> <!-- - <span class="reply"><?php //comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => 3, 'reply_text' => 'Reply' ) )); ?></span> --> <br>
					<?php #edit_comment_link(__('(Edit)'),'  ','' ); ?>
					<a class="time" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
				</div>
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
			</div>
			<div class="clr"></div>
			<span class="reply"><?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => 3, 'reply_text' => 'Reply' ) )); ?></span>
		</div>	
<?php
}

/**
 * Renders Single comment form.
 */
function single_comment_form()
{
	$commenter = wp_get_current_commenter();
	$required = get_option( 'require_name_email' );
	$aria = ( $required ? ' aria-required="true"' : '' );
	$fields =  apply_filters( 'comment_form_default_fields', array(
		'author' => '<div class="comment-form-author">' .
			'<input id="author" name="author" type="text" placeholder="' . __( 'First name *' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria . ' /></div>',
		'lname' => '<div class="comment-form-lname">' .
			'<input id="lname" name="lname" type="text" placeholder="' . __( 'Last name' ) . '" value="' . esc_attr( $commenter['comment_lname'] ) . '" ' . $aria . ' /></div>',		
		'email'  => '<div class="comment-form-email">' .
			'<input id="email" name="email" type="text" placeholder="' . __( 'Email *' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria . ' /></div>',
	));
	$args = array(
		'fields' => $fields, //apply_filters( 'comment_form_default_fields', $fields ), 
		'title_reply' => 'Add Reply', //'Add Comment',
		'label_submit' => 'Submit', //'SAVE COMMENT',
		//'comment_notes_after' => '',
		'comment_notes_before' => '',
		'id_submit' => 'frost-submit',
		'comment_field' => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . _x( 'Your comment', 'noun' ) . '"></textarea></div>'
	);
	comment_form( $args );
}
//add_filter('comment_form_default_fields','single_comment_form');

//if (function_exists('bwp_capt_comment_form')) {bwp_capt_comment_form(array('comment_notes_after' => 'my_custom_comment_notes'));}

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php echo 'Comments'; //echo sprintf( _nx( 'One thought on &ldquo;%2$s&rdquo;', ' Comments (%1$s)', get_comments_number(), 'comments title', 'swp' ),	number_format_i18n( get_comments_number() ), "" );	?>
		</h2>
		<ul class="comment-list">
			<?php
				wp_list_comments( 'type=comment&callback=single_list_comment', null, 2 );
			?>
		</ul><!-- .comment-list -->
		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php echo 'Comment navigation'; ?></h1>
			<div class="nav-previous"><?php previous_comments_link( '&larr; Older Comments' ); ?></div>
			<div class="nav-next"><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'swp' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	<?php single_comment_form(); ?>
	<div class="clr"></div>
</div><!-- #comments -->