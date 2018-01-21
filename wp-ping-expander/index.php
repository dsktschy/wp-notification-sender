<?php
/*
Plugin Name: WP Notification Sender
Plugin URI: https://github.com/dsktschy/wp-notification-sender
Description: WP Notification Sender sends a post request when post status transitions.
Version: 1.0.0
Author: dsktschy
Author URI: https://github.com/dsktschy
License: GPL2
*/

// Send a post request when post status transitions
add_filter('transition_post_status', ['WpNotificationSender', 'exec']);

// Hook for sending a post request
add_action('wpns_exec', ['WpNotificationSender', 'exec']);

// Add a section and a field to the setting page
add_filter('admin_init', function() {
  add_settings_section(
    WpNotificationSender::$sectionId,
    '',
    ['WpNotificationSender', 'echoDescription'],
    WpNotificationSender::$fieldPage
  );
  add_settings_field(
    WpNotificationSender::$fieldId,
    '',
    ['WpNotificationSender', 'echoField'],
    WpNotificationSender::$fieldPage,
    WpNotificationSender::$sectionId,
    ['id' => WpNotificationSender::$fieldId]
  );
  register_setting(WpNotificationSender::$fieldPage, WpNotificationSender::$fieldId);
});

// Class as a namespace
class WpNotificationSender {
  static public $sectionId = 'wp_notification_sender';
  static public $fieldId = 'wp_notification_sender';
  static public $fieldPage = 'writing';
  // Outputs an paragraph element for the description
  static public function echoDescription()
  {
    $description = preg_match('/^ja/', get_option('WPLANG')) ?
      'サイトの表示設定に関わらず、全ての投稿ステータス変更時に通知を行う場合は、以下のフィールドにのみ対象URLを記入してください。' :
      'Regardless of Search Engine Visibility, to always notify when transitioning post status, enter the target URL only in the following field.';
    echo '' .
      '<p class="wpns-description">' .
        '<label for="' . self::$fieldId . '">' . $description . '</label>' .
      '</p>';
  }
  // Outputs a textarea element with initial value
  static public function echoField(array $args)
  {
    $id = $args['id'];
    $value = esc_html(get_option($id));
    echo "<textarea name=\"$id\" id=\"$id\" class=\"large-text code\" rows=\"3\">$value</textarea>";
  }
  // Send a post request
  static public function exec()
  {
    $option = get_option(self::$fieldId);
    if ($option === '') return;
    foreach (array_map(
      ['WpNotificationSender', 'encodeSpace'],
      array_map('trim', explode("\n", $option))
    ) as $url) {
      if ($url === '') continue;
      wp_remote_post($url);
    }
  }
  // Encode spaces
  static public function encodeSpace($url)
  {
    return str_replace(' ', '%20', $url);
  }
}
