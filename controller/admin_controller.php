<?php
/**
*
* @package Reset User Registration Date
* @copyright (c) 2018 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\resetregdate\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\log\log;
use phpbb\language\language;
use david63\resetregdate\ext;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log */
	protected $log;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $php_ext;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\db\driver\driver_interface	$db			The db connection
	* @param \phpbb\request\request				$request	Request object
	* @param \phpbb\template\template			$template	Template object
	* @param \phpbb\user						$user		User object
	* @param \phpbb\log\log						$log		Log object
	* @param phpbb\language\language			$language	Language object
	* @param string 							$root_path	phpBB root path
	* @param string 							$php_ext	phpBB extension
	*
	* @return \david63\resetregdate\controller\admin_controller
	* @access public
	*/
	public function __construct(driver_interface $db, request $request, template $template, user $user, log $log, language $language, $root_path, $php_ext)
	{
		$this->db  			= $db;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->log			= $log;
		$this->language		= $language;
		$this->root_path	= $root_path;
		$this->phpEx		= $php_ext;
	}

	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_output()
	{
		// Add the language files
		$this->language->add_lang('acp_resetregdate', 'david63/resetregdate');
		$this->language->add_lang('date_time_picker', 'david63/resetregdate');

		$form_key = 'reset_reg_date';
		add_form_key($form_key);

		$reset_username	= $this->request->variable('reset_username', '', true);
		$reset_lv_date	= $this->request->variable('reset_lv_date', '');
		$reset_reg_date	= $this->request->variable('reset_reg_date', '');

		$errors = array();
		$back 	= false;

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID'));
			}

			if (!empty($reset_username))
			{
				$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . "
					WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($reset_username)) . "'";

				$result		= $this->db->sql_query($sql);
				$user_id	= (int) $this->db->sql_fetchfield('user_id');

				$this->db->sql_freeresult($result);

				if (!$user_id)
				{
					$errors[] = $this->language->lang('NO_USER');
				}

				if (!$reset_reg_date && !$reset_lv_date)
				{
					$errors[] = $this->language->lang('NO_DATE');
				}

				if (($reset_reg_date && $reset_lv_date) && (strtotime($reset_reg_date) > strtotime($reset_lv_date)))
				{
					$errors[] = $this->language->lang('REG_DATE_GREATER');
				}
			}
			else
			{
				$errors[] = $this->language->lang('NO_USER_SPECIFIED');
			}

			if (empty($errors))
			{
				$sql_set = '';
				if ($reset_reg_date)
				{
					$sql_set = 'user_regdate = ' . (int) strtotime($reset_reg_date) . ', ';
				}

				if ($reset_lv_date)
				{
					$sql_set .= 'user_lastvisit = ' . (int) strtotime($reset_lv_date);
				}

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET ' . $sql_set . '
					WHERE user_id = ' . (int) $user_id;

				$this->db->sql_query($sql);

				// Add reset change action to the admin & user logs
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_REGDATE_RESET',  time(), array($reset_username));
				$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_REGDATE_RESET', time(), array('reportee_id' => $this->user->data['username'], $reset_username));

				// Reset settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->language->lang('USER_REG_DATE_RESET', $reset_username) . adm_back_link($this->u_action));
			}
		}

		$timezone = new \DateTimeZone($this->user->data['user_timezone']);

		// Template vars for header panel
		$this->template->assign_vars(array(
			'ERROR_DESCRIPTION'	=> implode('<br />', $errors),
			'ERROR_TITLE'		=> $this->language->lang('WARNING'),

			'HEAD_TITLE'		=> $this->language->lang('RESET_REGISTRATION_DATE'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('RESET_REGISTRATION_DATE_EXPLAIN'),

			'S_ERROR'			=> (count($errors)) ? true : false,
			'S_BACK'			=> $back,

			'VERSION_NUMBER'	=> ext::RESET_REGISTRATION_DATE_VERSION,
		));

		$this->template->assign_vars(array(
			'RESET_USERNAME'	=> (!empty($user_id)) ? $reset_username : '',
			'RESET_LV_DATE'		=> $reset_lv_date,
			'RESET_REG_DATE'	=> $reset_reg_date,
			'RTL_LANGUAGE'		=> ($this->language->lang('DIRECTION') == 'rtl') ? true : false,

			'TIMEZONE'			=> $timezone->getOffset(new \DateTime) / 60, // In minutes

			'U_ACTION'			=> $this->u_action,
			'U_RESET_USERNAME'	=> append_sid("{$this->root_path}memberlist.$this->phpEx", 'mode=searchuser&amp;form=resetregdate&amp;field=reset_username&amp;select_single=true'),
		));
	}
}
