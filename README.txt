=== SEO Generator ===
Contributors: Riley MacDonald
Developer Link: http://rileymacdonald.ca
Tags: seo, meta tags, twitter cards
Requires at least: 3.5.1
Tested up to: 3.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is my first plugin. It generates meta tags for regular wordpress post types.
As a side project it also generates tags for display Twitter Cards in Tweets.
I am currently developing features which allow the user to choose which Twitter card they want to use.

== Description ==

The Seo Generator automatically creates the following meta tags for regular WordPress posts:

	<!--SEO Tags-->
	<meta name="author" content="Post Author First and Last Name" />
	<meta name="keywords" content="The Tags for the Post" />
	<meta name="description" content="The Post Excerpt" />

Set your twitter username using WordPress's user profile screen. The title, description and
image are automatically retrieved from your WordPress post.

	<!--Twitter-->
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="User Profile Twitter Username" />
	<meta name="twitter:creator" content="User Profile Twitter Username" />
	<meta name="twitter:title" content="The Post Title" />
	<meta name="twitter:description" content="The Post Excerpt"/>
	<meta name="twitter:image" content="The current post's featured image, or image set in the plugin settings" />

== Installation ==

1. Extract/Upload the directory `seo-generator` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Instructions for Use ==

Update your user profile by providing a twitter username in the WordPress User Profile Menu.
The Twitter card generated will automatically be updated with the Twitter account associated with the WordPress user.

Once the plugin is installed, each Post will have the ability to have a featured image.
If you choose a featured image for your post, it will be used as a thumbnail for tweets including the pages link.
If no featured image is set, the plugin allows the user to choose a static image through the plugin settings.

== Changelog ==

= 1.0 =
* Seo Generator created.

= 1.0.1 =
* Added twitter username option to WordPress User Profile screen

==  TODO's ==
	* Twitter card type selection in settings. The plugin currently generates tags for a summary card only.
