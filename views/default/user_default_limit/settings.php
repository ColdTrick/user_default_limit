<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

if (empty($user)) {
	return;
}

$options = [10, 15, 20, 25, 50, 75, 100];
$value = elgg_get_config('default_limit');
if (!in_array($value, $options)) {
	$options[] = $value;
	sort($options);
}

$title = elgg_echo('user_default_settings:settings:title');
$content = elgg_echo('user_default_settings:settings:label') . ': ';
$content .= elgg_view("input/select", array(
	'name' => 'user_default_limit',
	'value' => $value,
	'options' => $options
));
echo elgg_view_module('info', $title, $content);
