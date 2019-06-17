<?php
/**
*
* @package Reset User Registration Date
* @copyright (c) 2018 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CLICK_SELECT'						=> 'Click in textbox to select date/time',

	'NEW_VERSION'						=> 'New Version',
	'NEW_VERSION_EXPLAIN'		   		=> 'There is a newer version of this extension available.',
	'NO_DATE'							=> 'A reset registration or last visit date has not been entered.',
	'NO_USER'							=> 'The selected user does not exist in the database',
	'NO_USER_SPECIFIED'					=> 'No user selected',

	'REG_DATE_GREATER'					=> 'Registration date must be earlier than last visit date.',
	'RESET_LV_DATE_TO'					=> 'Reset last visit date to',
	'RESET_LV_DATE_TO_EXPLAIN'			=> 'Select the date/time for the new last visit date/time for this user.',
	'RESET_REG_DATE_TO'					=> 'Reset registration date to',
	'RESET_REG_DATE_TO_EXPLAIN'			=> 'Select the date/time for the new registration date/time for this user.',
	'RESET_REGISTRATION_DATE'			=> 'Reset registration date',
	'RESET_REGISTRATION_DATE_EXPLAIN'	=> 'Here you can reset a user’s original date of registration and/or last visit.',

	'USER_EXPLAIN'						=> 'Select the required user',
	'USER_REG_DATE_RESET'				=> 'Successfully reset the registration/last visit date for <strong>%1$s</strong>.',

	'VERSION'							=> 'Version',
));

// Donate
$lang = array_merge($lang, array(
	'DONATE'					=> 'Donate',
	'DONATE_EXTENSIONS'			=> 'Donate to my extensions',
	'DONATE_EXTENSIONS_EXPLAIN'	=> 'This extension, as with all of my extensions, is totally free of charge. If you have benefited from using it then please consider making a donation by clicking the PayPal donation button opposite - I would appreciate it. I promise that there will be no spam nor requests for further donations, although they would always be welcome.',

	'PAYPAL_BUTTON'				=> 'Donate with PayPal button',
	'PAYPAL_TITLE'				=> 'PayPal - The safer, easier way to pay online!',
));
