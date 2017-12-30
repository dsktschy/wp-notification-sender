<?php
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
