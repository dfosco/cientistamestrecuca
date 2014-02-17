<?php
class zephyr_walker_comment extends Walker_Comment {
    var $tree_type = 'comment';
    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
    function __construct() { 
        $GLOBALS['comment_num'] = 0;
        ?>
        <ul class="comments-list">        
    <?php }     
    function start_lvl( &$output, $depth = 0, $args = array() ) {      
        $GLOBALS['comment_depth'] = $depth + 1;
		$GLOBALS['comment_subnum'] = 0;
        ?>
		<ul class="children col-md-offset-1">
    <?php }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>
        </ul>
    <?php }
    function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0) {
        global $post;
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $object;
        if ( $depth > 1 ) {
        	$GLOBALS['comment_subnum'] = $GLOBALS['comment_subnum'] + 1;
        	$num =  $GLOBALS['comment_num'].'.'.$GLOBALS['comment_subnum'];
        } else {
        	$GLOBALS['comment_num'] = $GLOBALS['comment_num'] + 1;
			$num = $GLOBALS['comment_num'];
        }
        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>  
        <li <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
			<div class="row">
				<div class="col-md-1">
					<?php echo ( $args['avatar_size'] != 0 ? get_avatar( $object, 52 ) :'' ); ?>
				</div>
				<div class="col-md-11">
					<h5><?php echo get_comment_author_link(); ?> <span class="postauthorcomment accentbg"><?php _e('AUTHOR', 'zephyr'); ?></span><span class="commnum"><?php echo $num; ?></span></h5>
					<div class="comment-text">
						<?php if( !$object->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php __e('Your comment is awaiting moderation.', 'zephyr'); ?></em>                     
							<?php else: comment_text(); ?>
							<?php endif; ?>
					</div>
					<div class="comment-reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></div>
				</div>
			</div>
    <?php }
    function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>
        </li>
    <?php }
    function __destruct() { ?>
    </ul>
    <?php }
}