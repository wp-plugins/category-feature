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
	
		$defaults = array(
			'title' => NULL,
			'postcount' => 5,
			'offset' => NULL,
			'random' => false,
			'link_title' => false,
			'no_title' => 1,
			'home' => false,
			'category_id' => NULL,
			'wordcount' => NULL,
			'width' => NULL,
			'words' => NULL,
			'readmore' => false,
			'rmtext' => NULL,
			'linespace' => false,
			'line' => 1,
			'line_color' => '#dddddd',
			'style' => NULL,
			'homepage' => 1,
			'frontpage' => false,
			'page' => false,
			'category' => 1,
			'single' => false,
			'date' => false,
			'tag' => false,
			'attachment' => false,
			'taxonomy' => false,
			'author' => false,
			'search' => false,
			'not_found' => false,
			'h' => 3,
			'headline' => NULL,
			'headshort' => NULL,
			'class' => NULL,
			'filter' => false,
			'noshorts' => false,
			'format' => false,
			'show_date' => NULL,
			'alignment' => NULL,
			'imgborder' => NULL
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title = esc_attr($instance['title']);
		$postcount = esc_attr($instance['postcount']);
		$offset = esc_attr($instance['offset']);
		$random = esc_attr($instance['random']);
		$link_title = esc_attr($instance['link_title']);
		$no_title = esc_attr($instance['no_title']);
		$home = esc_attr($instance['home']);
		$category_id = esc_attr($instance['category_id']);
		$wordcount = esc_attr($instance['wordcount']);
		$width = esc_attr($instance['width']);
		$words = esc_attr($instance['words']);
		$readmore = esc_attr($instance['readmore']);
		$rmtext = esc_attr($instance['rmtext']);
		$noshorts = esc_attr($instance['noshorts']);
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
		$h=esc_attr($instance['h']);
		$headline=esc_attr($instance['headline']);
		$headshort=esc_attr($instance['headshort']);
		$class=esc_attr($instance['class']);
		$filter=esc_attr($instance['filter']);
		$format=esc_attr($instance['format']);
		$show_date=esc_attr($instance['show_date']);
		$alignment=esc_attr($instance['alignment']);
		$imgborder=esc_attr($instance['imgborder']);
		
		$features = get_categories('hide_empty=0');
		foreach ( $features as $feature ) :
		
			$categories[] = array($feature->cat_ID, $feature->cat_name );
		
		endforeach;
		
		$base_id = 'widget-'.$this->id_base.'-'.$this->number.'-';
		$base_name = 'widget-'.$this->id_base.'['.$this->number.']';
		
		$pages = array (
			array($base_id.'homepage', $base_name.'[homepage]', $homepage, __('Homepage', self::language_file)),
			array($base_id.'frontpage', $base_name.'[frontpage]', $frontpage, __('Frontpage (e.g. a static page as homepage)', self::language_file)),
			array($base_id.'page', $base_name.'[page]', $page, __('&#34;Page&#34; pages', self::language_file)),
			array($base_id.'category', $base_name.'[category]', $category, __('Category pages', self::language_file)),
			array($base_id.'single', $base_name.'[single]', $single, __('Single post pages', self::language_file)),
			array($base_id.'date', $base_name.'[date]', $date, __('Archive pages', self::language_file)),
			array($base_id.'tag', $base_name.'[tag]', $tag, __('Tag pages', self::language_file)),
			array($base_id.'attachment', $base_name.'[attachment]', $attachment, __('Attachments', self::language_file)),
			array($base_id.'taxonomy', $base_name.'[taxonomy]', $taxonomy, __('Custom Taxonomy pages (only available, if having a plugin)', self::language_file)),
			array($base_id.'author', $base_name.'[author]', $author, __('Author pages', self::language_file)),
			array($base_id.'search', $base_name.'[search]', $search, __('Search Results', self::language_file)),
			array($base_id.'not_found', $base_name.'[not_found]', $not_found, __('&#34;Not Found&#34;', self::language_file))
		);
			
		$checkall = array($base_id.'checkall', $base_name.'[checkall]', __('Check all', self::language_file));
		
		$headings = array(array('1', 'h1'), array('2', 'h2'), array('3', 'h3'), array('4', 'h4'), array('5', 'h5'), array('6', 'h6'));
		
		$options = array (array('top', __('Above thumbnail', self::language_file)) , array('bottom', __('Under thumbnail', self::language_file)));
		
		$items = array (array('none', __('Under image', self::language_file)), array('right', __('Left of image', self::language_file)), array('left', __('Right of image', self::language_file)), array('notext', __('Don&#39;t show excerpt', self::language_file)));
		
		$date_options = array (array('top', __('Above post', self::language_file)), array('middel', __('Under thumbnail', self::language_file)), array('bottom', __('Under post', self::language_file)), array('none', __('Don&#39;t show date', self::language_file)));
		
		a5_text_field($base_id.'title', $base_name.'[title]', $title, __('Title:', self::language_file), array('class' => 'widefat', 'space' => true));
		a5_select($base_id.'category_id', $base_name.'[category_id]', $categories, $category_id, __('Category:', self::language_file), __('Choose a category', self::language_file), array('class' => 'widefat', 'space' => true));
		a5_checkbox($base_id.'link_title', $base_name.'[link_title]', $link_title, __('Link the widget title to the chosen category.', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_checkbox($base_id.'no_title', $base_name.'[no_title]', $no_title, __('Show the post title.', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_number_field($base_id.'postcount', $base_name.'[postcount]', $postcount, __('How many posts will be displayed in the widget:', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_number_field($base_id.'offset', $base_name.'[offset]', $offset, __('Offset (how many posts are spared out in the beginning):', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_checkbox($base_id.'random', $base_name.'[random]', $random, __('Check to display random post(s) instead of a standard loop:', self::language_file), array('space' => true));
		a5_checkbox($base_id.'home', $base_name.'[home]', $home, __('Check to have the offset only on your Frontpage.', self::language_file), array('space' => true));
		a5_number_field($base_id.'width', $base_name.'[width]', $width, __('Width of the thumbnail (in px):', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_text_field($base_id.'imgborder', $base_name.'[imgborder]', $imgborder, sprintf(__('If wanting a border around the image, write the style here. %s would make it a black border, 1px wide.', self::language_file), '<strong>1px solid #000000</strong>'), array('space' => true, 'class' => 'widefat'));
		a5_number_field($base_id.'wordcount', $base_name.'[wordcount]', $wordcount, __('To overwrite the excerpt of WP, give here the number of sentences from the post that you want to display:', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_checkbox($base_id.'words', $base_name.'[words]', $words, __('Check to display words instead of sentences.', self::language_file), array('space' => true));
		a5_checkbox($base_id.'linespace', $base_name.'[linespace]', $linespace, __('Check to have each sentence in a new line.', self::language_file), array('space' => true));
		a5_checkbox($base_id.'noshorts', $base_name.'[noshorts]', $noshorts, __('Check to suppress shortcodes in the widget (in case the content is showing).', self::language_file), array('space' => true));
		a5_checkbox($base_id.'filter', $base_name.'[filter]', $filter, __('Check to return the excerpt unfiltered (might avoid interferences with other plugins).', self::language_file), array('space' => true));
		a5_checkbox($base_id.'format', $base_name.'[format]', $format, __('Check to keep the layout of the post (all tags and spaces).', self::language_file), array('space' => true));
		a5_select($base_id.'headline', $base_name.'[headline]', $options, $headline, __('Choose, whether to display the title above or under the thumbnail.', self::language_file), false, array('space' => true));
		a5_select($base_id.'h', $base_name.'[h]', $headings, $h, __('Weight of the Post Title:', self::language_file), false, array('space' => true));
		a5_select($base_id.'show_date', $base_name.'[show_date]', $date_options, $show_date, __('Choose, whether or not to display the publishing date and whether it comes above or under the post.', self::language_file), false, array('space' => true));
		a5_select($base_id.'alignment', $base_name.'[alignment]', $items, $alignment, __('Choose, whether or not to display the excerpt and whether it comes under the thumbnail or next to it.', self::language_file), false, array('space' => true));
		$shorten_title = a5_number_field($base_id.'headshort', $base_name.'[headshort]', $headshort,false, array('size' => 4, 'step' => 1), false);
		echo sprintf(__('%1$sLimit the title to %2$s words.%3$s', self::language_file), '<p>', $shorten_title, '</p>');
		a5_number_field($base_id.'line', $base_name.'[line]', $line, __('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', self::language_file), array('size' => 4, 'step' => 1, 'space' => true));
		a5_color_field($base_id.'line_color', $base_name.'[line_color]', $line_color, __('The color of the line (e.g. #cccccc):', self::language_file), array('size' => 13, 'space' => true));	
		a5_checkbox($base_id.'readmore', $base_name.'[readmore]', $readmore, __('Check to have an additional &#39;read more&#39; link at the end of the excerpt.', self::language_file), array('space' => true));
		a5_text_field($base_id.'rmtext', $base_name.'[rmtext]', $rmtext, sprintf(__('Write here some text for the &#39;read more&#39; link. By default, it is %s:', self::language_file), '[&#8230;]'), array('class' => 'widefat', 'space' => true));
		a5_text_field($base_id.'class', $base_name.'[class]', $class, __('If you want to style the &#39;read more&#39; link, you can enter a class here.', self::language_file), array('space' => true, 'class' => 'widefat'));
		a5_checkgroup(false, false, $pages, __('Check, where you want to show the widget. By default, it is showing on the homepage and the category pages:', self::language_file), $checkall);
		a5_textarea($base_id.'style', $base_name.'[style]', $style, sprintf(__('Here you can finally style the widget. Simply type something like%1$s%2$sborder-left: 1px dashed;%2$sborder-color: #000000;%3$s%2$sto get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', self::language_file), '<strong>', '<br />', '</strong>'), array('style' => 'height: 60px;', 'class' => 'widefat', 'space' => true));
		a5_resize_textarea(array($base_id.'style'));
		
	} // form
	 
	function update($new_instance, $old_instance) {
	
	$instance = $old_instance;
	
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['postcount'] = strip_tags($new_instance['postcount']);
		$instance['offset'] = strip_tags($new_instance['offset']);
		$instance['random'] = strip_tags($new_instance['random']);
		$instance['home'] = strip_tags($new_instance['home']);
		$instance['link_title'] = strip_tags($new_instance['link_title']);
		$instance['no_title'] = strip_tags($new_instance['no_title']);
		$instance['category_id'] = strip_tags($new_instance['category_id']); 
		$instance['wordcount'] = strip_tags($new_instance['wordcount']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['words'] = strip_tags($new_instance['words']);
		$instance['readmore'] = strip_tags($new_instance['readmore']);
		$instance['rmtext'] = strip_tags($new_instance['rmtext']);
		$instance['noshorts'] = strip_tags($new_instance['noshorts']);
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
		$instance['h'] = strip_tags($new_instance['h']);
		$instance['headline'] = strip_tags($new_instance['headline']);
		$instance['headshort'] = strip_tags($new_instance['headshort']);
		$instance['class'] = strip_tags($new_instance['class']);
		$instance['filter'] = strip_tags($new_instance['filter']);
		$instance['format'] = strip_tags($new_instance['format']);
		$instance['show_date'] = strip_tags($new_instance['show_date']);
		$instance['alignment'] = strip_tags($new_instance['alignment']);
		$instance['imgborder'] = strip_tags($new_instance['imgborder']);
		
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
				
				$cfw_before_widget='<div id="'.$widget_id.'" class="widget_featured_category_widget" style="'.$cfw_style.'">';
				$cfw_after_widget='</div>';
				
			endif;	
			
			echo $cfw_before_widget;
			
			if ( $title && $instance['link_title'] ) $title = '<a href="'.get_category_link($instance['category_id']).'" title="'.__('Permalink to', self::language_file).' '.get_cat_name($instance['category_id']).'">'.$title.'</a>';
			
			if ( $title ) echo $before_title . $title . $after_title;
		 
			/* This is the actual function of the plugin, it fills the widget area with the customized excerpts */
			
			global $wp_query, $post;
			
			$i=1;
			
			$cfw_setup['posts_per_page'] = $instance['postcount'];
			
			$cfw_setup['offset'] = $instance['offset'];
			
			if (is_category() || is_home() || empty($instance['home'])) :
				
				$cfw_page = $wp_query->get( 'paged' );
				$cfw_numberposts = $wp_query->get( 'posts_per_page' );
				
				$cfw_setup['offset'] = ($cfw_page) ? (($cfw_page-1)*$cfw_numberposts)+$instance['offset'] : $instance['offset'];
				
				$cfw_cat_count = get_category($instance['category_id'])->category_count;
				
				if ($cfw_cat_count - $cfw_setup['offset'] < $cfw_setup['offset']) $cfw_setup['offset'] = $cfw_cat_count - $instance['postcount'];
			
			endif;
			
			$cfw_setup['cat'] = $instance['category_id'];
			
			if ($instance['random']) $cfw_setup['orderby'] = 'rand';
			
			if (is_single()) :
				
				$cfw_setup['post__not_in'] = array($wp_query->get_queried_object_id());
				
			endif;
			
			$cfw_posts = new WP_Query($cfw_setup);
			
			while($cfw_posts->have_posts()) :
				
				$cfw_posts->the_post();
				
				// build post title
				
				$the_title = get_the_title();
				
				if ($instance['headshort']) :
				
					$args = array(
						'content' => $the_title,
						'count' => $instance['headshort'],
						'type' => 'words',
						'filter' => false
					);
						
					$the_title = A5_Excerpt::text($args).'&#8230;';
					
				endif;
				
				$eol = "\r\n";
				
				$cfw_tags = A5_Image::tags($post, 'cf_options', self::language_file);
		
				$cfw_image_alt = $cfw_tags['image_alt'];
				$cfw_image_title = $cfw_tags['image_title'];
				$cfw_title_tag = $cfw_tags['title_tag'];
			
				$cfw_headline = (!empty($instance['no_title'])) ? '<h'.$instance['h'].'>'.$eol.'<a href="'.get_permalink().'" title="'.$cfw_title_tag.'">'.$the_title.'</a>'.$eol.'</h'.$instance['h'].'>'.$eol : '';
				
				$cfw_title_tag = __('Permalink to', self::language_file).' '.$post->post_title;
				
				$cfw_style = ($instance['alignment'] != 'notext' && $instance['alignment'] != 'none') ? ' style="text-align: '.$instance['alignment'].';"' : '';
				
				if ($instance['show_date'] != 'none') $post_date = $eol.'<p'.$cfw_style.'>'.get_the_date().'</p>';
	
				// get thumbnail
				
				$default = A5_Image::get_default($instance['width']);
				
				$cfw_float = ($instance['alignment'] != 'notext') ? $instance['alignment'] : 'none';
					
				$cfw_margin = '';
				if ($instance['alignment'] == 'left') $cfw_margin = ' margin-right: 1em;';
				if ($instance['alignment'] == 'right') $cfw_margin = ' margin-left: 1em;';
				
				$cfw_imgborder = (isset($instance['imgborder'])) ? ' border: '.$instance['imgborder'].';' : '';
			
				if (!has_post_thumbnail()) :
					
					$args = array (
						'content' => $post->post_content,
						'width' => $default[0],
						'height' => $default[1], 
						'option' => 'cf_options'
					);	
				   
					$cfw_image_info = A5_Image::thumbnail($args);
					
					$cfw_thumb = $cfw_image_info['thumb'];
					
					$cfw_width = $cfw_image_info['thumb_width'];
			
					$cfw_height = $cfw_image_info['thumb_height'];
					
					if ($cfw_thumb) :
					
						if ($cfw_width) $cfw_img = '<img title="'.$cfw_image_title.'" src="'.$cfw_thumb.'" alt="'.$cfw_image_alt.'" class="wp-post-image" width="'.$cfw_width.'" height="'.$cfw_height.'" style="float: '.$cfw_float.';'.$cfw_margin.$cfw_imgborder.'" />';
							
						else $cfw_img = '<img title="'.$cfw_image_title.'" src="'.$cfw_thumb.'" alt="'.$cfw_image_alt.'" class="wp-post-image" style="max-width: '.$width.'; height: auto; float: '.$cfw_float.';'.$cfw_margin.$cfw_imgborder.'" />';
						
					endif;
						
				else :
				
					$img_info = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
						
					if (!$img_info):
					
						$src = get_the_post_thumbnail();
						
						$img = preg_match_all('/<\s*img[^>]+src\s*=\s*["\']?([^\s"\']+)["\']?[\s\/>]+/', $src, $matches);
						
						if ($img): 
						
							$img_info[0] = $matches[1][0];
							
							$img_size = A5_Image::get_size($img_info[0]);
							
							$img_info[1] = $img_size['width'];
							
							$img_info[2] = $img_size['height'];
							
						endif;
						
					endif;
					
					if ($img_info) :
					
						$args = array (
							'ratio' => $img_info[1]/$img_info[2],
							'thumb_width' => $img_info[1],
							'thumb_height' => $img_info[2],
							'width' => $default[0],
							'height' => $default[1]
						);
						
						$img_size = A5_Image::count_size($args);
						
						$atts = array('title' => $cfw_image_title, 'alt' => $cfw_image_alt, 'style' => 'float: '.$cfw_float.';'.$cfw_margin.$cfw_imgborder);
						
						$size = array($img_size['width'], $img_size['height']);
					
						$cfw_img = get_the_post_thumbnail($post->ID, $size, $atts);
						
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
					'shortcode' => $instance['noshorts'],
					'readmore' => $instance['readmore'],
					'rmtext' => $rmtext,
					'link' => get_permalink(),
					'title' => $cfw_title_tag,
					'class' => $instance['class'],
					'filter' => $instance['filter'],
					'format' => $instance['format']
				);
				
				$cfw_text = A5_Excerpt::text($args);
				
				// output
				
				if ('top' == $instance['headline']) echo $cfw_headline;
				
				if ('top' == $instance['show_date']) echo $post_date.$eol;
				
				if (isset($cfw_img)) echo $eol.'<a href="'.get_permalink().'" title="'.$cfw_title_tag.'">'.$cfw_img.'</a>'.$eol;
				
				if ('middel' == $instance['show_date']) echo $post_date.$eol;
				
				if ('bottom' == $instance['headline']) echo $cfw_headline;
				
				if ($instance['alignment'] == 'left' || $instance['alignment'] == 'right') echo $eol.do_shortcode($cfw_text).$eol;
			
				echo '<div style="clear: both;"></div>'.$eol;
				
				if ($instance['alignment'] == 'none') echo do_shortcode($cfw_text).$eol;
				
				if ('bottom' == $instance['show_date']) echo $post_date.$eol;
				
				// line, if wanted
				   
				if (!empty($instance['line']) && $i <  $instance['postcount']) :
					
					echo '<hr style="color: '.$instance['line_color'].'; background-color: '.$instance['line_color'].'; height: '.$instance['line'].'px;" />';
					
					$i++;
					
				endif;
				
				unset ($cfw_img, $source);
				
				endwhile;
			
				// Restore original Query & Post Data
				wp_reset_query();
				wp_reset_postdata();
			
			echo $cfw_after_widget;
		
		else:
		
			echo '<!-- Featured Category Widget is not setup for this view. -->';
		
		endif;
	 
	}
 
}

add_action('widgets_init', create_function('', 'return register_widget("Featured_Category_Widget");'));


?>
