<?php
/*
Plugin Name: Featured Category Widget
Plugin URI: http://blog.atelier-fuenf.de/wordpress-plugins/featured-category-widget
Description: The Featured Category Widget does, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of the category you chose. Display one or more random posts or the first five of the category in order.
Version: 1.3
Author: Waldemar Stoffel
Author URI: http://www.atelier-fuenf.de
License: GPL3
Text Domain: category-feature
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

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die(__('Sorry, you don&#39;t have direct access to this page.'));

/* attach JavaScript file for textarea reszing */

function cfw_js_sheet() {
	
	wp_enqueue_script('ta-expander-script', plugins_url('ta-expander.js', __FILE__), array('jquery'), '2.0', true);
}

add_action('admin_print_scripts-widgets.php', 'cfw_js_sheet');

//Additional links on the plugin page

add_filter('plugin_row_meta', 'cfw_register_links',10,2);

function cfw_register_links($links, $file) {
	
	$base = plugin_basename(__FILE__);
	if ($file == $base) :
	
		$links[] = '<a href="http://wordpress.org/extend/plugins/category-feature/faq/" target="_blank">'.__('FAQ', 'category-feature').'</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RMF326NZYFL6L" target="_blank">'.__('Donate', 'category-feature').'</a>';
	
	endif;
	
	return $links;

}

define( 'FCW_PATH', plugin_dir_path(__FILE__) );

if (!class_exists('A5_Thumbnail')) require_once FCW_PATH.'class-lib/A5_ImageClasses.php';
if (!class_exists('A5_Excerpt')) require_once FCW_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('Featured_Category_Widget')) require_once FCW_PATH.'class-lib/CF_WidgetClass.php';

// import laguage files

$cfw_language_file = 'category-feature';

load_plugin_textdomain($cfw_language_file, false , basename(dirname(__FILE__)).'/languages');

?>