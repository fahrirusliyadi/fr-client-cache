# Fr Client Cache #

[![Build Status](https://travis-ci.org/fahrirusliyadi/fr-client-cache.svg?branch=master)](https://travis-ci.org/fahrirusliyadi/fr-client-cache)
[![Code Coverage](https://scrutinizer-ci.com/g/fahrirusliyadi/fr-client-cache/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fahrirusliyadi/fr-client-cache/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fahrirusliyadi/fr-client-cache/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fahrirusliyadi/fr-client-cache/?branch=master)



Enable client side browser page cache by adding `Last-Modified` and `Cache-Control` headers.

## Installation ##

1. Upload `fr-client-cache` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. The default max cache age is 3600 seconds. Define `FRCLIENTCACHE_MAX_AGE` constant in `wp-config.php` file to override this value. Example:

    ~~~php
    // wp-config.php
    
    define('FRCLIENTCACHE_MAX_AGE', 86400); // 1 day
    ~~~

## Frequently Asked Questions ##

### Uninstallation Instructions ###

1. Deactivate and delete the plugin through the *Plugins* menu in WordPress
