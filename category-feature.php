<?php
/*
Plugin Name: Featured Category Widget
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/featured-category-widget
Description: The Featured Category Widget does, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of the category you chose. Display one or more random posts or the first five of the category in order.
Version: 1.7
Author: Waldemar Stoffel
Author URI: http://www.atelier-fuenf.de
License: GPL3
Text Domain: category-feature
*/

/*  Copyright 2012 -2014 Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

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

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die('Sorry, you don&#39;t have direct access to this page.');

define( 'FCW_PATH', plugin_dir_path(__FILE__) );
	
if (!class_exists('A5_Image')) require_once FCW_PATH.'class-lib/A5_ImageClass.php';
if (!class_exists('A5_Excerpt')) require_once FCW_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('Featured_Category_Widget')) require_once FCW_PATH.'class-lib/CF_WidgetClass.php';
if (!class_exists('A5_FormField')) require_once FCW_PATH.'class-lib/A5_FormFieldClass.php';
if (!class_exists('A5_DynamicCSS')) :

	require_once FCW_PATH.'class-lib/A5_DynamicCSSClass.php';
	
	$dynamic_css = new A5_DynamicCSS;
	
endif;

class CategoryFeature {
	
	const language_file = 'category-feature';
	
	function __construct() {
		
		register_activation_hook(  __FILE__, array($this, 'install') );
		register_deactivation_hook(  __FILE__, array($this, 'uninstall') );
		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_filter('plugin_row_meta', array($this, 'register_links'), 10, 2);
		
		// import laguage files
		load_plugin_textdomain(self::language_file, false , basename(dirname(__FILE__)).'/languages');
		
		// attach CSS and write your name in the comments
		
		$eol = "\r\n";
		$tab = "\t";
		
		A5_DynamicCSS::$styles .= $eol.'/* CSS portion of the Featured Category Widget */'.$eol.$eol;
		
		A5_DynamicCSS::$styles.='div[id^="featured_category_widget"].widget_featured_category_widget img {'.$eol.$tab.'height: auto;'.$eol.$tab.'max-width: 100%;'.$eol.'}'.$eol;
		
		A5_DynamicCSS::$styles.='div[id^="featured_category_widget"].widget_featured_category_widget {'.$eol.$tab.'-moz-hyphens: auto;'.$eol.$tab.'-o-hyphens: auto;'.$eol.$tab.'-webkit-hyphens: auto;'.$eol.$tab.'-ms-hyphens: auto;'.$eol.$tab.'hyphens: auto; '.$eol.'}'.$eol;
		
	}
	
	/* attach JavaScript file for textarea resizing */
	function enqueue_scripts($hook) {
		
		if ($hook != 'widgets.php') return;
		
		wp_register_script('ta-expander-script', plugins_url('ta-expander.js', __FILE__), array('jquery'), '3.0', true);
		wp_enqueue_script('ta-expander-script');
		
	}
	
	//Additional links on the plugin page
	
	function register_links($links, $file) {
		
		$base = plugin_basename(__FILE__);
		
		if ($file == $base) :
		
			$links[] = '<a href="http://wordpress.org/extend/plugins/category-feature/faq/" target="_blank">'.__('FAQ', self::language_file).'</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RMF326NZYFL6L" target="_blank">'.__('Donate', self::language_file).'</a>';
		
		endif;
		
		return $links;
	
	}
	
	// Creating default options on activation
	
	function install() {
		
		$default = array(
			'tags' => array(),
			'sizes' => array()
		);
		
		add_option('cf_options', $default);
		
	}
	
	// Cleaning on deactivation
	
	function uninstall() {
		
		delete_option('cf_options');
		
	}
	
}

$CategoryFeature = new CategoryFeature;

?>