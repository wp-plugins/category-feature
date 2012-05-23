<?php

/**
 *
 * Class CF Widget
 *
 * @ Advanced Featured Post Widget
 *
 * building the actual widget
 *
 */
class Featured_Category_Widget extends WP_Widget {
 
function Featured_Category_Widget() {
	
	global $cfw_language_file;

	$widget_opts = array( 'description' => __('Configure the output and looks of the widget. Then display thumbnails and excerpts of posts in your widget areas.', $cfw_language_file) );
	$control_opts = array( 'width' => 400 );
	
	parent::WP_Widget(false, $name = 'Featured Category Widget', $widget_opts, $control_opts);

}
 
function form($instance) {
	
	global $cfw_language_file;
	
// setup some default settings

	$defaults = array( 'postcount' => 5, 'line' => 1, 'line_color' => '#dddddd', 'homepage' => 1, 'category' => 1);
	
	$instance = wp_parse_args( (array) $instance, $defaults );
	
	$title = esc_attr($instance['title']);
	$postcount = esc_attr($instance['postcount']);
	$offset = esc_attr($instance['offset']);
	$random = esc_attr($instance['random']);
	$home = esc_attr($instance['home']);
	$category_id = esc_attr($instance['category_id']);
	$wordcount = esc_attr($instance['wordcount']);
	$words = esc_attr($instance['words']);
	$readmore = esc_attr($instance['readmore']);
	$rmtext = esc_attr($instance['rmtext']);
	$adsense = esc_attr($instance['adsense']);
	$linespace = esc_attr($instance['linespace']);
	$line=esc_attr($instance['line']);
	$line_color=esc_attr($instance['line_color']);
	$style=esc_attr($instance['style']);
	$homepage=esc_attr($instance['homepage']);
	$frontpage=esc_attr($instance['frontpage']);
	$page=esc_attr($instance['page']);
	$category=esc_attr($instance['category']);
	$single=esc_attr($instance['single']);
	$date=esc_attr($instance['date']);
	$tag=esc_attr($instance['tag']);
	$attachment=esc_attr($instance['attachment']);
	$taxonomy=esc_attr($instance['taxonomy']);
	$author=esc_attr($instance['author']);
	$search=esc_attr($instance['search']);
	$not_found=esc_attr($instance['not_found']);
	
	$categories = get_categories('hide_empty=0');

?>
 
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>">
 <?php _e('Title:', $cfw_language_file); ?>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
 </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e('Category:', $cfw_language_file); ?></label>
  <select id="<?php echo $this->get_field_id( 'category_id' ); ?>" name="<?php echo $this->get_field_name( 'category_id' ); ?>" class="widefat" style="width:100%;">
  <?php
    
	foreach ( $categories as $cat ) :
	
		$selected = ( $cat->cat_ID == $instance['category_id'] ) ? 'selected="selected"' : '' ;
		$option = '<option value="'.$cat->cat_ID.'" '.$selected.' >'.$cat->cat_name.'</option>';
		echo $option;

	endforeach;
  ?>
  </select>
</p>
<p>
 <label for="<?php echo $this->get_field_id('postcount'); ?>">
 <?php _e('How many posts will be displayed in the widget:', $cfw_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" type="text" value="<?php echo $postcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('offset'); ?>">
 <?php _e('Offset (how many posts are spared out in the beginning):', $cfw_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('random'); ?>">
 <input id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" type="checkbox" value="1" <?php echo checked( 1, $random, false ); ?> />&nbsp;<?php _e('Check to display random post(s) instead of a standard loop:', $cfw_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('home'); ?>">
 <input id="<?php echo $this->get_field_id('home'); ?>" name="<?php echo $this->get_field_name('home'); ?>" type="checkbox" value="1" <?php echo checked( 1, $home, false ); ?> />&nbsp;<?php _e('Check to have the offset only on your frontpage:', $cfw_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('wordcount'); ?>">
 <?php _e('To overwrite the excerpt of WP, give here the number of sentenses from the post that you want to display:', $cfw_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('wordcount'); ?>" name="<?php echo $this->get_field_name('wordcount'); ?>" type="text" value="<?php echo $wordcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('words'); ?>">
 <input id="<?php echo $this->get_field_id('words'); ?>" name="<?php echo $this->get_field_name('words'); ?>" type="checkbox" value="1" <?php echo checked( 1, $words, false ); ?> />&nbsp;<?php _e('Check to display words instead of sentenses:', $cfw_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('linespace'); ?>">
 <input id="<?php echo $this->get_field_id('linespace'); ?>" name="<?php echo $this->get_field_name('linespace'); ?>" type="checkbox" value="1" <?php echo checked( 1, $linespace, false ); ?> />&nbsp;<?php _e('Check to have each sentense in a new line.', $cf_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line'); ?>">
 <?php _e('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', $cfw_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('line'); ?>" name="<?php echo $this->get_field_name('line'); ?>" type="text" value="<?php echo $line; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line_color'); ?>">
 <?php _e('The color of the line (e.g. #cccccc):', $cfw_language_file); ?>
 <input size="13" id="<?php echo $this->get_field_id('line_color'); ?>" name="<?php echo $this->get_field_name('line_color'); ?>" type="text" value="<?php echo $line_color; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('readmore'); ?>">
 <input id="<?php echo $this->get_field_id('readmore'); ?>" name="<?php echo $this->get_field_name('readmore'); ?>" type="checkbox" value="1" <?php echo checked( 1, $readmore, false ); ?> />&nbsp;<?php _e('Check to have an additional &#39;read more&#39; link at the end of the excerpt.', $cfw_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('rmtext'); ?>">
 <?php echo __('Write here some text for the &#39;read more&#39; link. By default, it is', $cfw_language_file).' [&#8230;]:'; ?>
 <input class="widefat" id="<?php echo $this->get_field_id('rmtext'); ?>" name="<?php echo $this->get_field_name('rmtext'); ?>" type="text" value="<?php echo $rmtext; ?>" />
 </label>
</p>
<?php
if (defined('AE_AD_TAGS') && AE_AD_TAGS==1) :
?>
<p>
 <label for="<?php echo $this->get_field_id('adsense'); ?>">
 <input id="<?php echo $this->get_field_id('adsense'); ?>" name="<?php echo $this->get_field_name('adsense'); ?>" type="checkbox" value="1" <?php echo checked( 1, $adsense, false ); ?> />&nbsp;<?php _e('Check if you want to invert the Google AdSense Tags that are defined with the Ads Easy Plugin. E.g. when they are turned off for the sidebar, they will appear in the widget.', $cfw_language_file); ?>
 </label>
</p>
<?php
endif;
?>
<p>
  <?php _e('Check, where you want to show the widget. By default, it is showing on the homepage and the category pages:', $cfw_language_file); ?>
</p>
<fieldset>
<p>
  <label for="<?php echo $this->get_field_id('homepage'); ?>">
    <input id="<?php echo $this->get_field_id('homepage'); ?>" name="<?php echo $this->get_field_name('homepage'); ?>" type="checkbox" value="1" <?php echo checked( 1, $homepage, false ); ?> />&nbsp;<?php _e('Homepage', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('frontpage'); ?>">
    <input id="<?php echo $this->get_field_id('frontpage'); ?>" name="<?php echo $this->get_field_name('frontpage'); ?>" type="checkbox" value="1" <?php echo checked( 1, $frontpage, false ); ?> />&nbsp;<?php _e('Frontpage (e.g. a static page as homepage)', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('page'); ?>">
    <input id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" type="checkbox" value="1" <?php echo checked( 1, $page, false ); ?> />&nbsp;<?php _e('&#34;Page&#34; pages', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('category'); ?>">
    <input id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="checkbox" value="1" <?php echo checked( 1, $category, false ); ?> />&nbsp;<?php _e('Category pages', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('single'); ?>">
    <input id="<?php echo $this->get_field_id('single'); ?>" name="<?php echo $this->get_field_name('single'); ?>" type="checkbox" value="1" <?php echo checked( 1, $single, false ); ?> />&nbsp;<?php _e('Single post pages', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('date'); ?>">
    <input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" value="1" <?php echo checked( 1, $date, false ); ?> />&nbsp;<?php _e('Archive pages', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('tag'); ?>">
    <input id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>"  type="checkbox" value="1" <?php echo checked( 1, $tag, false ); ?> />&nbsp;<?php _e('Tag pages', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('attachment'); ?>">
    <input id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" type="checkbox" value="1" <?php echo checked( 1, $attachment, false ); ?> />&nbsp;<?php _e('Attachments', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('taxonomy'); ?>">
    <input id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="checkbox" value="1" <?php echo checked( 1, $taxonomy, false ); ?> />&nbsp;<?php _e('Custom Taxonomy pages (only available, if having a plugin)', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('author'); ?>">
    <input id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" type="checkbox" value="1" <?php echo checked( 1, $author, false ); ?> />&nbsp;<?php _e('Author pages', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('search'); ?>">
    <input id="<?php echo $this->get_field_id('search'); ?>" name="<?php echo $this->get_field_name('search'); ?>" type="checkbox" value="1" <?php echo checked( 1, $search, false ); ?> />&nbsp;<?php _e('Search Results', $cfw_language_file); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('not_found'); ?>">
    <input id="<?php echo $this->get_field_id('not_found'); ?>" name="<?php echo $this->get_field_name('not_found'); ?>" type="checkbox" value="1" <?php echo checked( 1, $not_found, false ); ?> />&nbsp;<?php _e('&#34;Not Found&#34;', $cfw_language_file); ?>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('checkall'); ?>">
    <input id="<?php echo $this->get_field_id('checkall'); ?>" name="checkall" type="checkbox" />&nbsp;<?php _e('Check all', $cfw_language_file); ?>
  </label>
</p>    
</fieldset>
<p>
 <label for="<?php echo $this->get_field_id('style'); ?>">
 <?php _e('Here you can finally style the widget. Simply type something like<br /><strong>border-left: 1px dashed;<br />border-color: #000000;</strong><br />to get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', $cfw_language_file); ?>
 <textarea class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>"><?php echo $style; ?></textarea>
 </label>
</p>
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery("#<?php echo $this->get_field_id('style'); ?>").autoResize();
});
--></script>
<?php
} // form
 
function update($new_instance, $old_instance) {

$instance = $old_instance;

	$instance['title'] = strip_tags($new_instance['title']);
	$instance['postcount'] = strip_tags($new_instance['postcount']);
	$instance['offset'] = strip_tags($new_instance['offset']);
	$instance['random'] = strip_tags($new_instance['random']);
	$instance['home'] = strip_tags($new_instance['home']);
	$instance['category_id'] = strip_tags($new_instance['category_id']); 
	$instance['wordcount'] = strip_tags($new_instance['wordcount']);
	$instance['words'] = strip_tags($new_instance['words']);
	$instance['readmore'] = strip_tags($new_instance['readmore']);
	$instance['rmtext'] = strip_tags($new_instance['rmtext']);
	$instance['adsense'] = strip_tags($new_instance['adsense']);
	$instance['linespace'] = strip_tags($new_instance['linespace']);
	$instance['line'] = strip_tags($new_instance['line']);
	$instance['line_color'] = strip_tags($new_instance['line_color']);
	$instance['style'] = strip_tags($new_instance['style']);
	$instance['homepage'] = strip_tags($new_instance['homepage']);
	$instance['frontpage'] = strip_tags($new_instance['frontpage']);
	$instance['page'] = strip_tags($new_instance['page']);
	$instance['category'] = strip_tags($new_instance['category']);
	$instance['single'] = strip_tags($new_instance['single']);
	$instance['date'] = strip_tags($new_instance['date']); 
	$instance['tag'] = strip_tags($new_instance['tag']);
	$instance['attachment'] = strip_tags($new_instance['attachment']);
	$instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
	$instance['author'] = strip_tags($new_instance['author']);
	$instance['search'] = strip_tags($new_instance['search']);
	$instance['not_found'] = strip_tags($new_instance['not_found']);
	
	return $instance;

} // update
 
function widget($args, $instance) {
	
	global $cfw_language_file;
	
	// get the type of page, we're actually on
	
	if (is_front_page()) $cfw_pagetype='frontpage';
	if (is_home()) $cfw_pagetype='homepage';
	if (is_page()) $cfw_pagetype='page';
	if (is_category()) $cfw_pagetype='category';
	if (is_single()) $cfw_pagetype='single';
	if (is_date()) $cfw_pagetype='date';
	if (is_tag()) $cfw_pagetype='tag';
	if (is_attachment()) $cfw_pagetype='attachment';
	if (is_tax()) $cfw_pagetype='taxonomy';
	if (is_author()) $cfw_pagetype='author';
	if (is_search()) $cfw_pagetype='search';
	if (is_404()) $cfw_pagetype='not_found';
	
	// display only, if said so in the settings of the widget

if ($instance[$cfw_pagetype]) :
	
	extract( $args );
	
	$title = apply_filters('widget_title', $instance['title']);
	
	if (empty($instance['style'])) :
		
		$cfw_before_widget=$before_widget;
		$cfw_after_widget=$after_widget;
		
	else :
		
		$cfw_style=str_replace(array("\r\n", "\n", "\r"), '', $instance['style']);
		
		$cfw_before_widget="<div id=\"".$widget_id."\" style=\"".$cfw_style."\">";
		$cfw_after_widget="</div>";
		
	endif;
	
	// hooking into ads easy for the google tags
	
	if (AE_AD_TAGS == 1 && $instance['adsense']) :
		
		do_action('google_end_tag');
		
		if ($ae_options['ae_sidebar']==1) do_action('google_ignore_tag');
	
		else do_action('google_start_tag');
		
	endif;	
	
	echo $cfw_before_widget;
	
	if ( $title ) echo $before_title . $title . $after_title;
 
/* This is the actual function of the plugin, it fills the widget area with the customized excerpts */

$i=1;

$cfw_setup="numberposts=".$instance['postcount'];

if (is_home() || empty($instance['home'])) :
	
	global $wp_query;
	
	$cfw_page = $wp_query->get( 'paged' );
	$cfw_numberposts = $wp_query->get( 'posts_per_page' );
	
	if ($cfw_page) :
	
		$cfw_offset=(($cfw_page-1)*$cfw_numberposts)+$instance['offset'];
		
	else :
	
		$cfw_offset=$instance['offset'];
		
	endif;
	
	$cfw_setup.='&offset='.$cfw_offset;

endif;

$cfw_setup.='&cat='.$instance['category_id'];

if ($instance['random']) $cfw_setup.='&orderby=rand';

if (is_single()) :
	
	global $wp_query;
	
	$cfw_setup.='&exclude='.$wp_query->get_queried_object_id();
	
endif;

global $post;
 
$cfw_posts = get_posts($cfw_setup);
 
foreach($cfw_posts as $post) :

 	// image and title tags
	
	$imagetags = new A5_ImageTags;
	
	$cfw_tags = $imagetags->get_tags($post, $cfw_language_file);
	
	$cfw_image_alt = $cfw_tags['image_alt'];
	$cfw_image_title = $cfw_tags['image_title'];
	$cfw_title_tag = $cfw_tags['title_tag'];
	
	// build post title
	
	$eol = "\r\n";
	$cfw_headline = '<p>'.$eol.'<a href="'.get_permalink().'" title="'.$cfw_title_tag.'">'.get_the_title().'</a>'.$eol.'</p>'.$eol;
		
	$cfw_title_tag = __('Permalink to', $cfw_language_file).' '.$post->post_title;
	
	// get thumbnail
	
	if (function_exists('has_post_thumbnail') && has_post_thumbnail()) :
	
		$cfw_img = get_the_post_thumbnail();
		
	else :
	
		$args = array (
		'content' => $post->post_content,
		'width' => get_option('thumbnail_size_w'),
		'height' => get_option('thumbnail_size_h')
		);	
	   
		$cfw_image = new A5_Thumbnail;
	
	   	$cfw_image_info = $cfw_image->get_thumbnail($args);
		
		$cfw_thumb = $cfw_image_info['thumb'];
		
		$cfw_width = $cfw_image_info['thumb_width'];

		$cfw_height = $cfw_image_info['thumb_height'];
		
		if ($cfw_thumb) :
		
			if ($cfw_width) $cfw_img = '<img title="'.$cfw_image_title.'" src="'.$cfw_thumb.'" alt="'.$cfw_image_alt.'" width="'.$cfw_width.'" height="'.$cfw_height.'" />';
				
			else $cfw_img = '<img title="'.$cfw_image_title.'" src="'.$cfw_thumb.'" alt="'.$cfw_image_alt.'" style="maxwidth: '.get_option('thumbnail_size_w').'; maxheight: '.get_option('thumbnail_size_h').';" />';
			
		endif;
		
	endif;
	
	// get excerpt
		
	$type = (!$instance['words']) ? 'sentenses' : 'words';
	
	$excerpt = ($instance['wordcount']) ? false : $post->post_excerpt;
	
	$rmtext = ($instance['rmtext']) ? $instance['rmtext'] : '[&#8230;]';
				
	$args = array(
	'excerpt' => $excerpt,
	'content' => $post->post_content,
	'type' => $type,
	'count' => $instance['wordcount'],
	'linespace' => $instance['linespace'],
	'readmore' => $instance['readmore'],
	'rmtext' => $rmtext,
	'link' => get_permalink(),
	'title' => $cfw_title_tag
	);
	
	$cfw_text = A5_Excerpt::get_excerpt($args);
	
	// output
	
	if ($cfw_img) echo $eol.'<a href="'.get_permalink().'" title="'.$cfw_title_tag.'">'.$cfw_img.'</a>'.$eol.'<div style="clear:both;"></div>'.$eol;
	
	echo $cfw_headline.$cfw_text;
	
	// line, if wanted
	   
	if (!empty($instance['line']) && $i <  $instance['postcount']) :
		
		echo '<hr style="color: '.$instance['line_color'].'; background-color: '.$instance['line_color'].'; height: '.$instance['line'].'px;" />';
		
		$i++;
		
	endif;
	
	endforeach;

echo $cfw_after_widget;

// hooking into ads easy for the google tags

if (AE_AD_TAGS == 1 && $instance['adsense']) :
	
	do_action('google_end_tag');
	
	if ($ae_options['ae_sidebar']==1) do_action('google_start_tag');

	else do_action('google_ignore_tag');
	
endif;

endif;
 
 }
 
}

add_action('widgets_init', create_function('', 'return register_widget("Featured_Category_Widget");'));


?>