<?php
/**
 * This is the template that displays the item block
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2015 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item, $Skin, $app_version;

// Default params:
$params = array_merge( array(
		'disp_title'        => true,
		'feature_block'     => false,
		'content_mode'      => 'auto',		// 'auto' will auto select depending on $disp-detail
		'item_class'        => 'evo_post',
		'item_type_class'   => 'evo_post__ptyp_',
		'item_status_class' => 'evo_post__',
		'item_disp_class'   => NULL,
		'image_class'       => 'img-responsive',
		'image_size'        => 'fit-1280x720',
		'author_link_text'  => 'preferredname',
	), $params );

echo '<div id="styled_content_block">'; // Beginning of post display
?>

<div id="<?php $Item->anchor_id() ?>" class="post <?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>">

	<?php
	$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)

	if( $params['disp_title'] && $disp == 'page' )
	{	// Display this on disp=page because there is already an item title widget in the item_single_header container for other cases:

		$title_before = '<h2 class="title">';
		$title_after  = '</h2>';
		if( $Item->is_intro() )
		{	// Display a link to edit the post only for intro post, because for all other posts it is displayed below under title
			$title_before = '<div class="post_title"><h2 class="title">';
			$title_after = '</h2>'.$Item->get_edit_link( array(
					'before' => '<div class="'.button_class( 'group' ).'">',
					'after'  => '</div>',
					'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
					'class'  => button_class( 'text' ),
				) ).'</div>';
		}

		$Item->title( array(
				'before'    => $title_before,
				'after'     => $title_after,
				'link_type' => $disp == 'page' ? '#' : 'permalink'
			) );
	}
	?>

	<?php
	if( ! $Item->is_intro()  )
	{	// Don't display these data for intro posts
		if( $disp == 'posts' )
		{
			// ------------------------- "Item in List" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_in_list', array(
				'widget_context' => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				// This will enclose each widget in a block:
				'block_start' => '<div class="evo_widget $wi_class$">',
				'block_end'   => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end'   => '</h3>',
				'author_link_text'  => $params['author_link_text'],
				// Controlling the title:
				'widget_item_title_params'  => array(
						'before' => '<h2 class="title">',
						'after'  => '</h2>',
					),
				// Item Visibility Badge widge template
				'widget_item_visibility_badge_display'  => ( ! $Item->is_intro() && $Item->status != 'published' ),
				'widget_item_visibility_badge_template' => '<div class="floatright">
						<span class="note status_$status$" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">
						<span>$status_title$</span></span></div>',
				// Template params for "Item Info Line" widget:
				'widget_item_info_line_before' => '<div class="small text-muted color-hover">',
				'widget_item_info_line_after'  => '</div>',
				'widget_item_info_line_params' => array(
						'before_flag'         => '<span>',
						'after_flag'          => '</span>',
						'before_permalink'    => '<span>',
						'after_permalink'     => '</span>',
						'before_author'       => '<span class="author"><i class="fa fa-user"></i>',
						'after_author'        => '</span>',
						'before_post_time'    => '<span class="time"><i class="fa fa-clock-o"></i>',
						'after_post_time'     => '</span>',
						'before_categories'   => '<span class="category"><i class="fa fa-archive"></i> ',
						'after_categories'    => '</span>',
						'before_last_touched' => '<span class="time"><i class="fa fa-clock-o"></i>'.T_('Last touched').': ',
						'after_last_touched'  => '</span>',
						'before_last_updated' => '<span class="time"><i class="fa fa-clock-o"></i>'.T_('Contents updated').': ',
						'after_last_updated'  => '</span>',
						'before_edit_link'    => '<span class="edit"><i class="fa fa-pencil"></i> ',
						'after_edit_link'     => '</span>',
						'edit_link_text'      => T_('Edit'),
						'format'              => '$flag$$permalink$$post_time$$author$$categories$$last_touched$$last_updated$$edit_link$',
					),
			) );
			// ----------------------------- END OF "Item in List" CONTAINER -----------------------------
		}
		elseif( $disp != 'page' )
		{
			// ------------------------- "Item Single - Header" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_single_header', array(
				'widget_context' => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				// This will enclose each widget in a block:
				'block_start' => '<div class="evo_widget $wi_class$">',
				'block_end'   => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end'   => '</h3>',
				'author_link_text'  => $params['author_link_text'],
				// Controlling the title:
				'widget_item_title_params'  => array(
						'before' => '<h2 class="title">',
						'after'  => '</h2>',
					),
				// Item Previous Next widget
				'widget_item_next_previous_params' => array(
						'block_start' => '<nav><ul class="pager">',
						'block_end' => '</ul></nav>',
						'prev_start' => '<li class="previous">',
						'prev_end' => '</li>',
						'next_start' => '<li class="next">',
						'next_end' => '</li>',
					),
				// Item Visibility Badge widge template
				'widget_item_visibility_badge_display'  => ( ! $Item->is_intro() && $Item->status != 'published' ),
				'widget_item_visibility_badge_template' => '<div class="floatright">
						<span class="note status_$status$" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">
						<span>$status_title$</span></span></div>',
				// Template params for "Item Info Line" widget:
				'widget_item_info_line_before' => '<div class="small text-muted color-hover">',
				'widget_item_info_line_after'  => '</div>',
				'widget_item_info_line_params' => array(
						'before_flag'         => '<span>',
						'after_flag'          => '</span>',
						'before_permalink'    => '<span>',
						'after_permalink'     => '</span>',
						'before_author'       => '<span class="author"><i class="fa fa-user"></i>',
						'after_author'        => '</span>',
						'before_post_time'    => '<span class="time"><i class="fa fa-clock-o"></i>',
						'after_post_time'     => '</span>',
						'before_categories'   => '<span class="category"><i class="fa fa-archive"></i> ',
						'after_categories'    => '</span>',
						'before_last_touched' => '<span class="time"><i class="fa fa-clock-o"></i>'.T_('Last touched').': ',
						'after_last_touched'  => '</span>',
						'before_last_updated' => '<span class="time"><i class="fa fa-clock-o"></i>'.T_('Contents updated').': ',
						'after_last_updated'  => '</span>',
						'before_edit_link'    => '<span class="edit"><i class="fa fa-pencil"></i> ',
						'after_edit_link'     => '</span>',
						'edit_link_text'      => T_('Edit'),
						'format'              => '$flag$$permalink$$post_time$$author$$categories$$last_touched$$last_updated$$edit_link$',
					),
			) );
			// ----------------------------- END OF "Item Single - Header" CONTAINER -----------------------------
		}
	?>

	<?php
	}
	?>

	<?php
	if( $disp == 'single' )
	{
		// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
		// Display container contents:
		widget_container( 'item_single', array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			'container_start' => '<div class="evo_container $wico_class$">',
			'container_end'   => '</div>',
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<div class="small">'.T_('Tags').': ',
			'widget_item_tags_after'     => '</div>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => $params,
		) );
		// ----------------------------- END OF "Item Single" CONTAINER -----------------------------
	}
	elseif( $disp == 'page' )
	{
		// Display container contents:
		widget_container( 'item_page', array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			'container_start' => '<div class="evo_container $wico_class$">',
			'container_end'   => '</div>',
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<div class="small">'.T_('Tags').': ',
			'widget_item_tags_after'     => '</div>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => $params,
		) );
	}
	else
	{
	// this will create a <section>
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', $params );
		// Note: You can customize the default item content by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
	// this will end a </section>


		if( ! $Item->is_intro() )
		{ // Don't display these data for intro posts
		// List all tags attached to this post:
		$Item->tags( array(
			'before'    => '<div class="small">'.T_('Tags').': ',
			'after'     => '</div>',
			'separator' => ', ',
		) );
	}
	?>

	<div class="small color-hover">
		<?php
			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
							'type' => 'comments',
							'link_before' => '<span><i class="fa fa-comments-o"></i>',
							'link_after' => '</span>',
							'link_text_zero' => '#',
							'link_text_one' => '#',
							'link_text_more' => '#',
							'link_title' => '#',
						) );

			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
							'type' => 'trackbacks',
							'link_before' => '<span>',
							'link_after' => '</span>',
							'link_text_zero' => '#',
							'link_text_one' => '#',
							'link_text_more' => '#',
							'link_title' => '#',
						) );
		?>
	</div>
	<?php } ?>

	<?php
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array_merge( array(
				'before_section_title' => '<div class="clearfix"></div><h2 class="comments_title">',
				'after_section_title'  => '</h2>',
				'author_link_text' => $params['author_link_text'],
			), $params ) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
	?>

	<?php
	if( evo_version_compare( $app_version, '6.7' ) >= 0 )
	{	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ WORKFLOW PROPERTIES INCLUDED HERE ------------------
		skin_include( '_item_workflow.inc.php' );
		// ---------------------- END OF WORKFLOW PROPERTIES ---------------------
	}
	?>

	<?php
	if( evo_version_compare( $app_version, '6.7' ) >= 0 )
	{	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ META COMMENTS INCLUDED HERE ------------------
		skin_include( '_item_meta_comments.inc.php', array(
				'comment_start'         => '<article class="evo_comment evo_comment__meta panel panel-default">',
				'comment_end'           => '</article>',
			) );
		// ---------------------- END OF META COMMENTS ---------------------
	}
	?>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</div>
<?php echo '</div>'; // End of post display ?>