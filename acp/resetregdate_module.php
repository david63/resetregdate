<?php
/**
*
* @package Reset User Registration Date
* @copyright (c) 2018 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\resetregdate\acp;

class resetregdate_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'reset_reg_date';
		$this->page_title	= $phpbb_container->get('language')->lang('RESET_REG_DATE');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.resetregdate.admin.controller');

		$admin_controller->display_output();
	}
}
