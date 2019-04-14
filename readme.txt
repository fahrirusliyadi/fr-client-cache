=== Fr Client Cache ===
Contributors: fahrirusliyadi
Donate link: https://paypal.me/FahriRusliyadi
Tags: cache, client, browser
Requires at least: 4.5
Tested up to: 5.0.4
Stable tag: 0.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enable client side browser page cache.

== Description ==

Enable client side browser page cache by adding `Last-Modified` and `Cache-Control` headers.

== Installation ==

1. Upload `fr-client-cache` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. The default max cache age is 3600 seconds. Define `FRBROWSERCACHE_MAX_AGE` constant in `wp-config.php` file to override this value. Example:

    ~~~php
    // wp-config.php
    define('FRBROWSERCACHE_MAX_AGE', 86400); // 1 day
    ~~~

== Frequently Asked Questions ==

= Uninstallation Instructions =

1. Deactivate and delete the plugin through the *Plugins* menu in WordPress
