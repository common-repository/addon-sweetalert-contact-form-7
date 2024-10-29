=== Add-on SweetAlert Contact Form 7 ===

Contributors: camilo517
Tags: contact form, cf7, contact form 7, sweet alert, sweetalert2
Stable tag: 1.1.1
Requires PHP: 5.6
Tested up to: 5.5
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html

Add SweetAlert2 script into Contact Form 7 submission process.

== Description ==

This plugin adds the [SweetAlert2 script](https://sweetalert2.github.io) into [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) wordpress plugin submission process.

> This plugin requires the Contact Form 7 plugin to work.

Just activate it to replace CF7 default submission output by a SweetAlert2 pop up.
The add-on will display the Contact Form 7 messages in the pop up.

If you want, you can set a custom duration and a custom title for the alerts.

This plugin is an enhancement to the plugin created by akandor, Antoine Derrien which was closed by WordPress security team

Its base has been used and all this has been improved:
-Load admin styles only on the settings page
-Removed style sheets with little css content (It has been directly embedded, as it does not make sense load a sheet for a few lines)
-Sanitize data input and output (Since it was vulnerable to XSS attacks)
-Update css and js files from sweetalert (Since it was very outdated)
-Show sweetalert icons again
-Remove unnecessary code and files
-Css fix, since there was conflict with some themes
-Load the js and css only when the contact form shortcode is detected (Except a script)
-Titles are now converted to uppercase by default

== How does it work? ==

It enqueues scripts and styles to override CF7 submission process and surcharge it with SweetAlert2 scripts.

== Installation ==

You can install automatically from WordPress.

Or, if you want to install manually, follow these steps:

1. Upload the entire 'addon-sweetalert-contact-form-7' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress admin.

* You can add a custom title and the time you want the pop-up to appear, within the contact form 7 options

== Changelog ==
= 1.1.0 (02/08/2020) =
-Fix bugs
-Update the sweetalert library
= 1.0.9 (22/05/2020) =
-Improve WPO, remove external cdn

= 1.0.8 (21/05/2020) =
-Fixed security issues reported by the WordPress security team

= 1.0.7 (10/05/2020) =
-Fix bug IE compatibility
-Improve WPO

= 1.0.6 (10/05/2020) =
-Fix bug IE compatibility

= 1.0.5 (10/05/2020) =
-Fix bug IE compatibility

= 1.0.4 (10/05/2020) =
-IE compatibility

= 1.0.3 (16/04/2020) =
-Fix bugs
-Improved script loading
-Improved checks
-Added defer to improve WPO
-Updated sweetalert2 libraries
-Added unistall.php

= 1.0.2 (14/04/2020) =
-Fix bugs
-.pot added

= 1.0.1 (9/04/2020) =
-Fix bugs
-images added

= 1.0.0 (7/04/2020) =
-Initial version