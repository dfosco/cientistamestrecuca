<aside id="comments" class="post-comments col-md-11">
	<h4 class="border"><?php comments_number( __('No comments', 'zephyr'), __('One comment', 'zephyr'), '%'.__(' comments', 'zephyr') ); ?></h4>
	<?php $comments = wp_list_comments( array( 'walker' => new zephyr_walker_comment ) ); ?>
</aside>
<?php if ( comments_open() ) { ?>
<div class="add-comment col-md-11">
<?php 
$zephyr_cform_args = array(
  'id_form'           => 'commentform',
  'id_submit'         => 'submit',
  'title_reply'       => '',
  'title_reply_to'    => '',
  'cancel_reply_link' => __( 'Cancel Reply', 'zephyr' ),
  'label_submit'      => __( 'SEND', 'zephyr' ),
  'comment_field' =>  '<div class="form-row"><label for="comment">' . __( 'YOUR MESSAGE', 'zephyr' ) .
    '</label><textarea id="comment" name="comment" aria-required="true">' .
    '</textarea></div>',

  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( 'You must be <a href="%s">logged in</a> to post a comment.', 'zephyr' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p>',

  'logged_in_as' => '<p class="logged-in-as">' .
    sprintf(
    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'zephyr' ),
      admin_url( 'profile.php' ),
      $user_identity,
      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
    ) . '</p>',

  'comment_notes_before' => '',

  'comment_notes_after' => '',

  'fields' => apply_filters( 'comment_form_default_fields', array(

    'author' =>
      '<div class="form-row">' .
      '<label for="author">' . __( 'NAME', 'zephyr' ) . ( $req ? '<span class="required">*</span>' : '' ).'</label> ' .
      '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
      '" size="30"  /></div>',

    'email' =>
      '<div class="form-row"><label for="email">' . __( 'EMAIL', 'zephyr' ) . ( $req ? '<span class="required">*</span>' : '' ) .'</label> ' .
      '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" size="30" /></div>',

    'url' =>
      '<div class="form-row"><label for="url">' .
      __( 'WEBSITE', 'zephyr' ) . '</label>' .
      '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" size="30" /></div>'
    )
  ),
);
paginate_comments_links();
?>
	<h4 class="border"><?php _e('Add comment', 'zephyr'); ?></h4>
	<div class="comment-form col-md-6">
		<?php comment_form($zephyr_cform_args); ?>
	</div>
</div>
<?php } else { ?>
	<div class="add-comment col-md-11">
		<h4 class="border"><?php _e('Comments are closed.', 'zephyr'); ?></h4>
	</div>
<?php } ?>