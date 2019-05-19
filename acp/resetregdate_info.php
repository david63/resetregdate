<?php
/**
*
* @package Reset User Registration Date
* @copyright (c) 2018 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\resetregdate\acp;

class resetregdate_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\resetregdate\acp\resetregdate_module',
			'title'		=> 'RESET_REG_DATE',
			'modes'		=> array(
				'main'		=> array('title' => 'RESET_REG_DATE', 'auth' => 'ext_david63/resetregdate && acl_a_user', 'cat' => array('ACP_CAT_USERS')),
			),
		);
	}
}
