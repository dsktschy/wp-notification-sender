<?php
/*
Plugin Name: WP Ping Expander
Plugin URI: https://github.com/dsktschy/wp-ping-expander
Description: WP Ping Expander extends the ping function built in WordPress and sends pings also when post status transitions.
Version: 1.0.0
Author: dsktschy
Author URI: https://github.com/dsktschy
License: GPL2
*/

// Send pings also when post status transitions
add_filter('transition_post_status', ['WpPingExpander', 'doPings']);

// Class as a namespace
class WpPingExpander {
  // Send pings
  static public function doPings()
  {
    if (wp_next_scheduled('do_pings')) return;
    wp_schedule_single_event(time(), 'do_pings');
  }
}
