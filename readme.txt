=== Featured Category Widget ===
Contributors: tepelstreel
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RMF326NZYFL6L
Tags: column, sidebar, widget, category, newspaper, image, multi widget, teaser, featured, post, featured post, random post
Requires at least: 2.7
Tested up to: 3.4
Stable tag: 1.1

The Featured Category Widget is basically a Featured Post Widget for a category.

== Description ==

The Featured Category Widget is mainly designed because there were peole for whom the Featured Post Widget was not enough. They wanted to put a category of their blog in the highlight.
If there is a post thumbnail, it will be displayed above the headline of the post. If there is no thumbnail, the first picture of the post is taken in the size of your settings for the thumbnail. Decide yourself, whether you want to show the excerpt, saved with your post or just the first three sentenses or the first twenty words of the post. Style the widget individually, ready.

The Featured Category was tested up to WP 3.4. It should work with versions down to 2.7 but was never tested on those.

== Installation ==

1. Upload the `category-feature` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place and customize your widgets
4. Ready

== Frequently Asked Questions ==

= I styled the widget container myself and it looks bad. What do I do? =

The styling of the widget requires some knowledge of css. If you are not familiar with that, try adding

`padding: 10px;
margin-bottom: 10px;`
 
to the style section.

= My widget should have rounded corners, how do I do that? =

Add something like

`-webkit-border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px;
-moz-border-radius-topleft: 5px;
-moz-border-radius-topright: 5px;
border-top-left-radius: 5px;
border-top-right-radius: 5px;`
 
to the widget style. This is not supported by all browsers yet, but should work in almost all of them.

= My widget should have a shadow, how do I do that? =

Add something like

`-moz-box-shadow: 10px 10px 5px #888888;
-webkit-box-shadow: 10px 10px 5px #888888;
box-shadow: 10px 10px 5px #888888;`
 
to the widget style to get a nice shadow down right of the container. This is not supported by all browsers yet, but should work in almost all of them.

== Screenshots ==

1. The plugin's work on our testing page
2. The widget's settings section

== Changelog ==

= 1.0 =
* initial release

= 1.1 =
* possibility to choose random posts

== Upgrade Notice ==

= 1.0 =
just new

= 1.1 =
possibility to choose random posts