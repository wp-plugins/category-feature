<?php
/*
Plugin Name: Featured Category Widget
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/category-column-plugin
Description: The Category Column does simply, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of other categories than showed in the center-column. The plugin is tested with WP up to version 3.4. It might work with versions down to 2.7, but that will never be explicitly supported. The plugin has fully adjustable widgets.  You can choose the number of posts displayed, the offset (only on your homepage or always) and whether or not a line is displayed between the posts.
Version: 1.0
Author: Waldemar Stoffel
Author URI: http://www.atelier-fuenf.de
License: GPL3
Text Domain: featured-category
*/

/*  Copyright 2012  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


/* Stop direct call */

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die("Sorry, you don't have direct access to this page."); }

/* attach JavaScript file for textarea reszing */

function cfw_js_sheet() {
	
	wp_enqueue_script('ta-expander-script', plugins_url('ta-expander.js', __FILE__), array('jquery'), '2.0', true);
}

add_action('admin_print_scripts-widgets.php', 'cfw_js_sheet');

//Additional links on the plugin page

add_filter('plugin_row_meta', 'cfw_register_links',10,2);

function cfw_register_links($links, $file) {
	
	$base = plugin_basename(__FILE__);
	if ($file == $base) {
		$links[] = '<a href="http://wordpress.org/extend/plugins/category-feature/faq/" target="_blank">'.__('FAQ', 'featured-category').'</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RMF326NZYFL6L" target="_blank">'.__('Donate', 'featured-category').'</a>';
	}
	
	return $links;

}


// extending the widget class
 
class Featured_Category_Widget extends WP_Widget {
 
 function Featured_Category_Widget() {
	 
	 $widget_opts = array( 'description' => __('Configure the output and looks of the widget. Then display thumbnails and excerpts of posts in your widget areas.', 'featured-category') );
	 $control_opts = array( 'width' => 400 );
	 
	 parent::WP_Widget(false, $name = 'Featured Category Widget', $widget_opts, $control_opts);
 }
 
function form($instance) {
	
	// setup some default settings
    
	$defaults = array( 'postcount' => 5, 'line' => 1, 'line_color' => '#dddddd');
    
	$instance = wp_parse_args( (array) $instance, $defaults );
	
	$title = esc_attr($instance['title']);
	$postcount = esc_attr($instance['postcount']);
	$offset = esc_attr($instance['offset']);
	$home = esc_attr($instance['home']);
	$category_id = esc_attr($instance['category_id']);
	$wordcount = esc_attr($instance['wordcount']);
	$words = esc_attr($instance['words']);
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
 <?php _e('Title:', 'featured-category'); ?>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
 </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e('Category:', 'featured-category'); ?></label>
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
 <?php _e('How many posts will be displayed in the widget:', 'featured-category'); ?>
 <input size="4" id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" type="text" value="<?php echo $postcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('offset'); ?>">
 <?php _e('Offset (how many posts are spared out in the beginning):', 'featured-category'); ?>
 <input size="4" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('home'); ?>">
 <input id="<?php echo $this->get_field_id('home'); ?>" name="<?php echo $this->get_field_name('home'); ?>" <?php if(!empty($home)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Check to have the offset only on your frontpage:', 'featured-category'); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('wordcount'); ?>">
 <?php _e('To overwrite the excerpt of WP, give here the number of sentenses from the post that you want to display:', 'featured-category'); ?>
 <input size="4" id="<?php echo $this->get_field_id('wordcount'); ?>" name="<?php echo $this->get_field_name('wordcount'); ?>" type="text" value="<?php echo $wordcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('words'); ?>">
 <input id="<?php echo $this->get_field_id('words'); ?>" name="<?php echo $this->get_field_name('words'); ?>" <?php if(!empty($words)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Check to display words instead of sentenses:', 'featured-category'); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line'); ?>">
 <?php _e('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', 'featured-category'); ?>
 <input size="4" id="<?php echo $this->get_field_id('line'); ?>" name="<?php echo $this->get_field_name('line'); ?>" type="text" value="<?php echo $line; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line_color'); ?>">
 <?php _e('The color of the line (e.g. #cccccc):', 'featured-category'); ?>
 <input size="13" id="<?php echo $this->get_field_id('line_color'); ?>" name="<?php echo $this->get_field_name('line_color'); ?>" type="text" value="<?php echo $line_color; ?>" />
 </label>
</p>
<p>
  <?php _e('Check, where you want to show the widget. By default, it is showing on the homepage and the category pages:', 'featured-category'); ?>
</p>
<fieldset>
<p>
  <label for="<?php echo $this->get_field_id('homepage'); ?>">
    <input id="<?php echo $this->get_field_id('homepage'); ?>" name="<?php echo $this->get_field_name('homepage'); ?>" <?php if(!empty($homepage)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Homepage', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('frontpage'); ?>">
    <input id="<?php echo $this->get_field_id('frontpage'); ?>" name="<?php echo $this->get_field_name('frontpage'); ?>" <?php if(!empty($frontpage)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Frontpage (e.g. a static page as homepage)', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('page'); ?>">
    <input id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" <?php if(!empty($page)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('&#34;Page&#34; pages', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('category'); ?>">
    <input id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" <?php if(!empty($category)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Category pages', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('single'); ?>">
    <input id="<?php echo $this->get_field_id('single'); ?>" name="<?php echo $this->get_field_name('single'); ?>" <?php if(!empty($single)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Single post pages', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('date'); ?>">
    <input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" <?php if(!empty($date)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Archive pages', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('tag'); ?>">
    <input id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" <?php if(!empty($tag)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Tag pages', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('attachment'); ?>">
    <input id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" <?php if(!empty($attachment)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Attachments', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('taxonomy'); ?>">
    <input id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" <?php if(!empty($taxonomy)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Custom Taxonomy pages (only available, if having a plugin)', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('author'); ?>">
    <input id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" <?php if(!empty($author)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Author pages', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('search'); ?>">
    <input id="<?php echo $this->get_field_id('search'); ?>" name="<?php echo $this->get_field_name('search'); ?>" <?php if(!empty($search)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Search Results', 'featured-category'); ?>
  </label><br />
  <label for="<?php echo $this->get_field_id('not_found'); ?>">
    <input id="<?php echo $this->get_field_id('not_found'); ?>" name="<?php echo $this->get_field_name('not_found'); ?>" <?php if(!empty($not_found)) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('&#34;Not Found&#34;', 'featured-category'); ?>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('checkall'); ?>">
    <input id="<?php echo $this->get_field_id('checkall'); ?>" name="checkall" type="checkbox" />&nbsp;<?php _e('Check all', 'featured-category'); ?>
  </label>
</p>    
</fieldset>
<p>
 <label for="<?php echo $this->get_field_id('style'); ?>">
 <?php _e('Here you can finally style the widget. Simply type something like<br /><strong>border-left: 1px dashed;<br />border-color: #000000;</strong><br />to get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', 'featured-category'); ?>
 <textarea class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>"><?php echo $style; ?></textarea>
 </label>
</p>
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery("#<?php echo $this->get_field_id('style'); ?>").autoResize();
});
--></script>
<?php
 }
 

function update($new_instance, $old_instance) {
	 
	 $instance = $old_instance;
	 
	 $instance['title'] = strip_tags($new_instance['title']);
	 $instance['postcount'] = strip_tags($new_instance['postcount']);
	 $instance['offset'] = strip_tags($new_instance['offset']);
	 $instance['home'] = strip_tags($new_instance['home']);
	 $instance['category_id'] = strip_tags($new_instance['category_id']); 
	 $instance['wordcount'] = strip_tags($new_instance['wordcount']);
	 $instance['words'] = strip_tags($new_instance['words']);
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
	 
}
 
function widget($args, $instance) {
	
	// get the type of page, we're actually on

	if (is_front_page()) $afpw_pagetype='frontpage';
	if (is_home()) $afpw_pagetype='homepage';
	if (is_page()) $afpw_pagetype='page';
	if (is_category()) $afpw_pagetype='category';
	if (is_single()) $afpw_pagetype='single';
	if (is_date()) $afpw_pagetype='date';
	if (is_tag()) $afpw_pagetype='tag';
	if (is_attachment()) $afpw_pagetype='attachment';
	if (is_tax()) $afpw_pagetype='taxonomy';
	if (is_author()) $afpw_pagetype='author';
	if (is_search()) $afpw_pagetype='search';
	if (is_404()) $afpw_pagetype='not_found';
	
	// display only, if said so in the settings of the widget

if ($instance[$afpw_pagetype]) :
	
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
	
	echo $cfw_before_widget;
	
	if ( $title ) {
		
		echo $before_title . $title . $after_title;
		
	}
 
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

if (is_single()) :
	
	global $wp_query;
	
	$cfw_setup.='&exclude='.$wp_query->get_queried_object_id();
	
endif;

global $post;
 
$fcw_posts = get_posts($cfw_setup);
 
foreach($fcw_posts as $post) :

	setup_postdata($post);
		
	$cfw_title_tag = __('Permalink to', 'featured-category').' '.$post->post_title;   
	
	if (function_exists('has_post_thumbnail') && has_post_thumbnail()) :
	   
		/* If there is a thumbnail, show it */
		   
		?>
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		<div style="clear:both;"></div>
		<?php
	
	else :
	
		$cfw_args = array(
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_status' => null,
		'post_parent' => $post->ID
		);
		
		$cfw_attachments = get_posts( $cfw_args );
		
		if ( $cfw_attachments ) :
		
			foreach ( $cfw_attachments as $attachment ) :
			
				$cfw_image_alt[] = trim(strip_tags( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true) ));
				$cfw_image_title[] = trim(strip_tags( $attachment->post_title ));
				
			endforeach;
				
		endif;
		
		$cfw_thumb = '';
		
		$cfw_image = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', do_shortcode($post->post_content), $matches);
		
		$cfw_thumb = $matches [1] [0];
		
	   if (!empty($cfw_thumb)) :
	   
	   $cfw_x = get_option('thumbnail_size_w');
	   $cfw_y = get_option('thumbnail_size_h');
	   
			?>
			<a href="<?php the_permalink(); ?>" title="<?php echo $cfw_title_tag ?>"><?php echo '<img title="'.esc_attr($cfw_image_title[0]).'" src="'.$cfw_thumb.'" alt="'.esc_attr($cfw_image_alt[0]).'" style="max-width: '.$cfw_x.'px; max-height: '.$cfw_y.'px;" />'; ?></a>
			<div style="clear:both;"></div>
			<?php
			   
		endif;
	
	endif;
		   
	?>
    <p><a href="<?php the_permalink(); ?>" title="<?php echo $cfw_title_tag ?>">
    <?php the_title(); ?>
    </a></p>
    <?php
	
/* in case the excerpt is not wanted, the first x sentenses or words of the content are given */
	
	if ($instance['wordcount']) :
	
	$cfw_readmore = ' <a href="'.get_permalink().'" title="'.$cfw_title_tag.'">[&#8230;]</a>';
	
	$cfw_text=trim(preg_replace('/\s\s+/', ' ', str_replace(array("\r\n", "\n", "\r", "&nbsp;"), ' ', strip_tags(preg_replace('/\[caption(.*?)\[\/caption\]/', '', strip_shortcodes(get_the_content()))))));
	
		if ($instance['words']) :
			
			$cfw_short=array_slice(explode(' ', $cfw_text), 0, $instance['wordcount']);
			
			$cfw_excerpt=implode(' ', $cfw_short).$cfw_readmore;
			
		else :
			
			$cfw_short=array_slice(preg_split('/([\t.!?]+)/', $cfw_text, -1, PREG_SPLIT_DELIM_CAPTURE), 0, $instance['wordcount']*2);
			
			$cfw_excerpt=implode($cfw_short).$cfw_readmore;
			
		endif;
		
	else:
	
		$cfw_excerpt=$post->post_excerpt;
	
	endif;
	
	echo '<p>'.$cfw_excerpt.'</p>';
	   
	if (!empty($instance['line']) && $i <  $instance['postcount']) :
		
		echo '<hr style="color: '.$instance['line_color'].'; background-color: '.$instance['line_color'].'; height: '.$instance['line'].'px;" />';
		
		$i++;
		
	endif;
	
	endforeach;

echo $cfw_after_widget;

endif;
 
 }
 
}

add_action('widgets_init', create_function('', 'return register_widget("Featured_Category_Widget");'));


// import laguage files

load_plugin_textdomain('featured-category', false , basename(dirname(__FILE__)).'/languages');

?>