<?php
use Elgg\DefaultPluginBootstrap;

class IPTracker extends DefaultPluginBootstrap {

  public function init() {
  	// IP logging at create/login events
  	elgg_register_event_handler('login:after', 'user', 'tracker_log_ip');
  	elgg_register_event_handler('create', 'user', 'tracker_log_ip');

  	// Show IP address on profile
  	if (elgg_is_admin_logged_in()) {
  		if (elgg_get_plugin_setting('tracker_display', 'tracker') == 'profile') {
  			elgg_extend_view('profile/owner_block', 'tracker/profile_ip');
  		} else {
  			// Extend avatar hover menu
  			elgg_register_event_handler('register', 'menu:user_hover', 'tracker_admin_hover_menu');
  		}
  	}
  }
}