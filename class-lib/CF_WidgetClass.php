<?php

/**
 *
 * Class CF Widget
 *
 * @ Featured Category Widget
 *
 * building the actual widget
 *
 */
class Featured_Category_Widget extends WP_Widget {
	
const language_file = 'category-feature';
 
function Featured_Category_Widget() {
	
	$widget_opts = array( 'description' => __('Configure the output and looks of the widget. Then display thumbnails and excerpts of posts in your widget areas.', self::language_file) );
	$control_opts = array( 'width' => 400 );
	
	parent::WP_Widget(false, $name = 'Featured Category Widget', $widget_opts, $control_opts);

}
 
function form($instance) {
	
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
	$width = esc_attr($instance['width']);
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
	
	$features = get_categories('hide_empty=0');
	foreach ( $features as $feature ) :
	
		$categories[] = array($feature->cat_ID, $feature->cat_name );
	
	endforeach;
	
	$options = array (array('homepage', $homepage, __('Homepage', self::language_file)), array('frontpage', $frontpage, __('Frontpage (e.g. a static page as homepage)', self::language_file)), array('page', $page, __('&#34;Page&#34; pages', self::language_file)), array('category', $category, __('Category pages', self::language_file)), array('single', $single, __('Single post pages', self::language_file)), array('date', $date, __('Archive pages', self::language_file)), array('tag', $tag, __('Tag pages', self::language_file)), array('attachment', $attachment, __('Attachments', self::language_file)), array('taxonomy', $taxonomy, __('Custom Taxonomy pages (only available, if having a plugin)', self::language_file)), array('author', $author, __('Author pages', self::language_file)), array('search', $search, __('Search Results', self::language_file)), array('not_found', $not_found, __('&#34;Not Found&#34;', self::language_file)));
	
	$base_id = 'widget-'.$this->id_base.'-'.$this->number.'-';
	$base_name = 'widget-'.$this->id_base.'['.$this->number.']';
	
	$field[] = array ('type' => 'text', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'title', 'label' => __('Title:', self::language_file), 'value' => $title, 'class' => 'widefat', 'space' => 1);
	$field[] = array ('type' => 'select', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'category_id', 'label' => __('Category:', self::language_file), 'value' => $category_id, 'options' => $categories, 'default' => __('Choose a category', self::language_file), 'class' => 'widefat', 'style' => 'width:100%', 'space' => 1);
	$field[] = array ('type' => 'number', 'size' => 4, 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'postcount', 'label' => __('How many posts will be displayed in the widget:', self::language_file), 'value' => $postcount, 'step' => 1, 'space' => 1);
	$field[] = array ('type' => 'number', 'size' => 4, 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'offset', 'label' => __('Offset (how many posts are spared out in the beginning):', self::language_file), 'value' => $offset, 'step' => 1, 'space' => 1);
	$field[] = array ('type' => 'checkbox', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'random', 'label' => __('Check to display random post(s) instead of a standard loop:', self::language_file), 'value' => $random, 'space' => 1);
	$field[] = array ('type' => 'checkbox', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'home', 'label' => __('Check to have the offset only on your Frontpage.', self::language_file), 'value' => $home, 'space' => 1);
	$field[] = array ('type' => 'number', 'size' => 4, 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'width', 'label' => __('Width of the thumbnail (in px):', self::language_file), 'value' => $width, 'step' => 1, 'space' => 1);
	$field[] = array ('type' => 'number', 'size' => 4, 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'wordcount', 'label' => __('To overwrite the excerpt of WP, give here the number of sentences from the post that you want to display:', self::language_file), 'value' => $wordcount, 'min' => 1, 'step' => 1, 'space' => 1);
	$field[] = array ('type' => 'checkbox', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'words', 'label' => __('Check to display words instead of sentences.', self::language_file), 'value' => $words, 'space' => 1);
	$field[] = array ('type' => 'checkbox', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'linespace', 'label' => __('Check to have each sentence in a new line.', self::language_file), 'value' => $linespace, 'space' => 1);
	$field[] = array ('type' => 'number', 'size' => 4, 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'line', 'label' => __('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', self::language_file), 'value' => $line, 'space' => 1);
	$field[] = array ('type' => 'color', 'size' => 13, 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'line_color', 'label' => __('The color of the line (e.g. #cccccc):', self::language_file), 'value' => $line_color, 'space' => 1);
	$field[] = array ('type' => 'checkbox', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'readmore', 'label' => __('Check to have an additional &#39;read more&#39; link at the end of the excerpt.', self::language_file), 'value' => $readmore, 'space' => 1);
	$field[] = array ('type' => 'text', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'rmtext', 'label' => __('Write here some text for the &#39;read more&#39; link. By default, it is', self::language_file).' [&#8230;]:', 'value' => $rmtext, 'class' => 'widefat', 'space' => 1);
	
	if (defined('AE_AD_TAGS') && AE_AD_TAGS==1) :
	
	$field[] = array ('type' => 'checkbox', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'adsense', 'label' => __('Check if you want to invert the Google AdSense Tags that are defined with the Ads Easy Plugin. E.g. when they are turned off for the sidebar, they will appear in the widget.', self::language_file), 'value' => $adsense, 'space' => 1);
	
	endif;
	
	$field[] = array ('type' => 'checkgroup', 'id_base' => $base_id, 'name_base' => $base_name, 'label' => __('Check, where you want to show the widget. By default, it is showing on the homepage and the category pages:', self::language_file), 'options' => $options, 'checkall' => __('Check all', self::language_file));
	$field[] = array ('type' => 'textarea', 'id_base' => $base_id, 'name_base' => $base_name, 'field_name' => 'style', 'class' => 'widefat', 'label' => sprintf(__('Here you can finally style the widget. Simply type something like%1$s%2$sborder-left: 1px dashed;%2$sborder-color: #000000;%3$s%2$sto get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', self::language_file), '<strong>', '<br />', '</strong>'), 'value' => $style, 'space' => 1);
	$field[] = array ('type' => 'resize', 'id_base' => $base_id, 'field_name' => array('style'));
	
	foreach ($field as $args) :
	
		$menu_item = new A5_WidgetControls($args);
 
 	endforeach;
	
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
	$instance['width'] = strip_tags($new_instance['width']);
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
		
		$cfw_before_widget='<div id="'.$widget_id.'" style="'.$cfw_style.'">';
		$cfw_after_widget='</div>';
		
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

global $wp_query, $post;

$i=1;

$cfw_setup="numberposts=".$instance['postcount'];

if (is_home() || empty($instance['home'])) :
	
	$cfw_page = $wp_query->get( 'paged' );
	$cfw_numberposts = $wp_query->get( 'posts_per_page' );
	
	$cfw_offset = ($cfw_page) ? (($cfw_page-1)*$cfw_numberposts)+$instance['offset'] : $cfw_offset=$instance['offset'];
	
	$cfw_setup.='&offset='.$cfw_offset;

endif;

$cfw_setup.='&cat='.$instance['category_id'];

if ($instance['random']) $cfw_setup.='&orderby=rand';

if (is_single()) :
	
	$cfw_setup.='&exclude='.$wp_query->get_queried_object_id();
	
endif;

$cfw_posts = get_posts($cfw_setup);
 
foreach($cfw_posts as $post) :

 	// image and title tags
	
	$imagetags = new A5_ImageTags;
	
	$cfw_tags = $imagetags->get_tags($post, 'cf_options', self::language_file);
	
	$cfw_image_alt = $cfw_tags['image_alt'];
	$cfw_image_title = $cfw_tags['image_title'];
	$cfw_title_tag = $cfw_tags['title_tag'];
	
	// build post title
	
	$eol = "\r\n";
	$cfw_headline = '<p>'.$eol.'<a href="'.get_permalink().'" title="'.$cfw_title_tag.'">'.get_the_title().'</a>'.$eol.'</p>'.$eol;
		
	$cfw_title_tag = __('Permalink to', self::language_file).' '.$post->post_title;
	
	// get thumbnail
	
	if (!$instance['width']) :
	
		$width = get_option('thumbnail_size_w');
		
		$height = get_option('thumbnail_size_h');
		
	else : 
	
		$width = $instance['width'];
		
		$height = false;
		
		if (has_post_thumbnail()) :
		
			$img_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
				
			$source = $img_url[0];
			
		endif;
	
	endif;
	
	if (has_post_thumbnail() && !$instance['width']) :
	
		$cfw_img = get_the_post_thumbnail();
		
	else :
	
		$args = array (
		'thumb' => $source,
		'content' => $post->post_content,
		'width' => $width,
		'height' => $height, 
		'option' => 'cf_options'
		);	
	   
		$cfw_image = new A5_Thumbnail;
	
	   	$cfw_image_info = $cfw_image->get_thumbnail($args);
		
		$cfw_thumb = $cfw_image_info['thumb'];
		
		$cfw_width = $cfw_image_info['thumb_width'];

		$cfw_height = $cfw_image_info['thumb_height'];
		
		if ($cfw_thumb) :
		
			if ($cfw_width) $cfw_img = '<img title="'.$cfw_image_title.'" src="'.$cfw_thumb.'" alt="'.$cfw_image_alt.'" class="wp-post-image" width="'.$cfw_width.'" height="'.$cfw_height.'" />';
				
			else $cfw_img = '<img title="'.$cfw_image_title.'" src="'.$cfw_thumb.'" alt="'.$cfw_image_alt.'" class="wp-post-image" style="maxwidth: '.$width.'; maxheight: '.$height.';" />';
			
		endif;
		
	endif;
	
	// get excerpt
		
	$type = (!$instance['words']) ? 'sentences' : 'words';
	
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
	
	unset ($cfw_img, $source);
	
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