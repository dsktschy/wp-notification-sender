<?php
/*
Plugin Name: WP Ping Expander
Plugin URI: https://github.com/dsktschy/wp-ping-expander
Description: WP Ping Expander extends the ping function built in WordPress and sends pings also when saving the pages and trashing posts and pages.
Version: 1.0.0
Author: dsktschy
Author URI: https://github.com/dsktschy
License: GPL2
*/

// Send pings also when saving pages
add_filter('publish_page', ['WpPingExpander', 'doPings']);

// Send pings also when trashing posts and pages
add_action('wp_trash_post', ['WpPingExpander', 'doPings']);

// Class as a namespace
class WpPingExpander {
  // Send pings
  static public function doPings()
  {
    if (wp_next_scheduled('do_pings')) return;
    wp_schedule_single_event(time(), 'do_pings');
  }
}
