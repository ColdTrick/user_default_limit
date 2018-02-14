<?php

// register default Elgg events
elgg_register_event_handler('init', 'system', 'user_default_limit_init');

/**
 * Called during system init
 *
 * @return void
 */
function user_default_limit_init() {
	if (!elgg_is_logged_in()) {
		return;
	}
	
	elgg_extend_view('forms/usersettings/save', 'user_default_limit/settings');
	elgg_register_plugin_hook_handler('usersettings:save', 'user', 'user_default_limit_settings_save');
	
	$setting = sanitize_int(elgg_get_logged_in_user_entity()->getPrivateSetting('user_default_limit'), false);
	if (empty($setting)) {
		return;
	}
	
	elgg_set_config('default_limit', $setting);
}

function user_default_limit_settings_save() {
	$user_default_limit = sanitize_int(get_input('user_default_limit'), false);
	$user_guid = (int) get_input('guid');
	
	if (empty($user_default_limit)) {
		return;
	}
	
	if ($user_default_limit < 10 || $user_default_limit > 100) {
		return;
	}
	
	if ($user_guid) {
		$user = get_user($user_guid);
	} else {
		$user = elgg_get_logged_in_user_entity();
	}
	
	if (empty($user) || !$user->canEdit()) {
		return;
	}
	
	$user->setPrivateSetting('user_default_limit', $user_default_limit);
}
