<?php
/*
Plugin Name: Featured Category Widget
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/featured-category-widget
Description: The Featured Category Widget does, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of the category you chose. Display one or more random posts or the first five of the category in order.
Version: 2.3
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

defined('ABSPATH') OR exit;

if (!defined('FCW_PATH')) define( 'FCW_PATH', plugin_dir_path(__FILE__) );
if (!defined('FCW_BASE')) define( 'FCW_BASE', plugin_basename(__FILE__) );

# loading the framework
if (!class_exists('A5_Image')) require_once FCW_PATH.'class-lib/A5_ImageClass.php';
if (!class_exists('A5_Excerpt')) require_once FCW_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('A5_FormField')) require_once FCW_PATH.'class-lib/A5_FormFieldClass.php';
if (!class_exists('A5_OptionPage')) require_once FCW_PATH.'class-lib/A5_OptionPageClass.php';
if (!class_exists('A5_DynamicFiles')) require_once FCW_PATH.'class-lib/A5_DynamicFileClass.php';

#loading plugin specific classes
if (!class_exists('CF_Admin')) require_once FCW_PATH.'class-lib/CF_AdminClass.php';
if (!class_exists('CF_DynamicCSS')) require_once FCW_PATH.'class-lib/CF_DynamicCSSClass.php';
if (!class_exists('Featured_Category_Widget')) require_once FCW_PATH.'class-lib/CF_WidgetClass.php';

class CategoryFeature {
	
	const language_file = 'category-feature';
	
	static $options;
	
	function __construct() {
		
		load_plugin_textdomain(self::language_file, false , basename(dirname(__FILE__)).'/languages');
		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		
		add_filter('plugin_row_meta', array($this, 'register_links'), 10, 2);	
		add_filter( 'plugin_action_links', array($this, 'plugin_action_links'), 10, 2 );
				
		register_activation_hook(  __FILE__, array($this, '_install') );
		register_deactivation_hook(  __FILE__, array($this, '_uninstall') );
		
		self::$options = get_option('cf_options');
		
		if (isset(self::$options['tags'])) $this->_update_options();
		
		$CF_DynamicCSS = new CF_DynamicCSS;
		$CF_Admin = new CF_Admin;
		
	}
	
	/* attach JavaScript file for textarea resizing */
	function enqueue_scripts($hook) {
		
		if ($hook != 'settings_page_featured-category-settings' && $hook != 'widgets.php' && $hook != 'post.php') return;
		
		$min = (WP_DEBUG == false) ? '.min.' : '.';
		
		wp_register_script('ta-expander-script', plugins_url('ta-expander'.$min.'js', __FILE__), array('jquery'), '3.0', true);
		wp_enqueue_script('ta-expander-script');
		
	}
	
	//Additional links on the plugin page
	
	function register_links($links, $file) {
		
		if ($file == FCW_BASE) {
			$links[] = '<a href="http://wordpress.org/extend/plugins/category-coloumn/faq/" target="_blank">'.__('FAQ', self::language_file).'</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RMF326NZYFL6L" target="_blank">'.__('Donate', self::language_file).'</a>';
		}
		
		return $links;
		
	}
		
	function plugin_action_links( $links, $file ) {
		
		if ($file == FCW_BASE) array_unshift($links, '<a href="'.admin_url( 'options-general.php?page=featured-category-settings' ).'">'.__('Settings', self::language_file).'</a>');
	
		return $links;
	
	}
	
	// Creating default options on activation
	
	function _install() {
		
		$default = array(
			'cache' => array(),
			'inline' => false
		);
		
		add_option('cf_options', $default);
		
	}
	
	// Cleaning on deactivation
	
	function _uninstall() {
		
		delete_option('cf_options');
		
	}
	
	// updating options in case they are outdated
	
	function _update_options() {	
		
			self::$options['cache'] = array();
			
			self::$options['inline'] = false;
			
			unset(self::$options['tags'], self::$options['sizes']);
			
			update_option('cf_options', self::$options);
	
	}
	
}

$CategoryFeature = new CategoryFeature;

?>