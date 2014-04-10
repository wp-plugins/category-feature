<?php

/**
 *
 * Class CF Dynamic CSS
 *
 * Extending A5 Dynamic Files
 *
 * Presses the dynamical CSS of the Featured Category Widget into a virtual style sheet
 *
 */

class CF_DynamicCSS extends A5_DynamicFiles {
	
	private static $options;
	
	function __construct() {
		
		self::$options =  get_option('cf_options');
		
		if (!isset(self::$options['inline'])) self::$options['inline'] = false;
		
		parent::A5_DynamicFiles('wp', 'css', false, self::$options['inline']);
		
		$eol = "\r\n";
		$tab = "\t";
		
		$css_selector = '.widget_featured_category_widget[id^="featured_category_widget"]';
		
		parent::$styles .= $eol.'/* CSS portion of the Featured Category Widget */'.$eol.$eol;
		
		$style = '-moz-hyphens: auto;'.$eol.$tab.'-o-hyphens: auto;'.$eol.$tab.'-webkit-hyphens: auto;'.$eol.$tab.'-ms-hyphens: auto;'.$eol.$tab.'hyphens: auto;';
		
		if (!empty(self::$options['css'])) $style.=$eol.$tab.str_replace('; ', ';'.$eol.$tab, str_replace(array("\r\n", "\n", "\r"), ' ', self::$options['css']));
		
		parent::$styles.='div'.$css_selector.','.$eol.'li'.$css_selector.','.$eol.'aside'.$css_selector.' {'.$eol.$tab.$style.$eol.'}'.$eol;
		
		parent::$styles.='div'.$css_selector.' img,'.$eol.'li'.$css_selector.' img,'.$eol.'aside'.$css_selector.' img {'.$eol.$tab.'height: auto;'.$eol.$tab.'max-width: 100%;'.$eol.'}'.$eol;

	}
	
} // CF_Dynamic CSS

?>