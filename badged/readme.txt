=== Badged ===
Contributors: kremalicious
Donate link: http://krlc.us/givecoffee
Tags: notification, adminmenu, toolbar, adminbar, ios, badge, badged, badges
Requires at least: 2.7
Tested up to: 4.0
Stable tag: 1.0.1

iOS Style Notification Badges for WordPress

== Description ==

Badged transforms the standard WordPress update & comment notification badges into iOS-styled ones. Upon activation it automatically replaces the badge styles in the admin menu and the toolbar. An optional settings page allows to control whether the badges show up as the new default iOS style or styled as pre-iOS 7 badges.

The badges are created without any images by using only CSS (box shadows, gradients, pseudo elements, you name it) and were tested in current versions of Safari, Chrome, Firefox, Opera & Internet Explorer. It should degrade gracefully in older browsers with some details missing like drop shadows or the highlight shine.

The plugin is localized in english, german & spanish.

* * *

[Badged Blog Post](http://kremalicious.com/badged/) | [Badged on github](https://github.com/kremalicious/badged) | [Donate](http://krlc.us/givecoffee)


== Installation ==

Just install using the automatic backend installer under Plugins > Add New, activate and enjoy the red badges.

For manual installation:

1. Upload the badged plugin folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enjoy

(optional) Adjust options under Settings > Badges


== Screenshots ==

1. Restyled notifications in Admin Menu
2. Restyled notifications in Admin Bar
3. Settings page
4. Restyled pre-iOS 7 notifications in Admin Menu
5. Restyled pre-iOS 7 notifications in Admin Bar


== Changelog ==

= v1.0.1 =

* tested for WP 4.0
* Spanish translation, muchas gracias to Andrew Kurtis from [webhostinghub.com](http://www.webhostinghub.com)
* don't style comments badge with 0 comments
* improved styles
* admin settings page fixes
* plugin icon and updated banner & screenshots

= v1.0.0 =
* new default style based on iOS 7
* new setting to switch back to pre-iOS 7 style
* rewritten from the ground up based on Tom McFarlin's excellent [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate)
* settings through WordPress Settings API
* Retina banner for WordPress plugin repository listing
* drop IE 8 support (still present in pre-iOS 7 style)
* using Grunt for optimized images and minified css
* confusing and ridiculous version number jump

= v0.3.6 =
* tested for WP 3.4
* settings page: Retina ready icon for high dpi devices, css only submit button
* updated german translation

= v0.3.5 =
* IE 8 improvements: box shadow, light gradient through DXImageTransform filters (but no rounded corners, sorry)
* current versions of IE & Opera are now among the tested browsers
* updated settings page links

= v0.3.4 =
* more descriptive readme and settings footer with links to blog post & github page
* updated translation

= v0.3.2 =
* Make the plugin work if symlinked

= v0.3 =
* initial beta release

= v0.2 =
* added options to control whether the badges show up in admin menu or toolbar (default is both)

= v0.1 =
* initial alpha release