<?php
/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\topicsuffixtags\acp\main_module',
			'title'		=> 'ACP_TOPICSUFFIXTAGS',
			'modes'		=> [
				'links'	=> [
					'title' => 'ACP_TOPICSUFFIXTAGS_LINKS',
					'auth' => 'ext_marttiphpbb/topicsuffixtags && acl_a_board',
					'cat' => ['ACP_TOPICSUFFIXTAGS'],
				],
				'page_rendering'	=> [
					'title' => 'ACP_TOPICSUFFIXTAGS_PAGE_RENDERING',
					'auth' => 'ext_marttiphpbb/topicsuffixtags && acl_a_board',
					'cat' => ['ACP_TOPICSUFFIXTAGS'],
				],				
				'input'		=> [
					'title'	=> 'ACP_TOPICSUFFIXTAGS_INPUT',
					'auth'	=> 'ext_marttiphpbb/topicsuffixtags && acl_a_board',
					'cat'	=> ['ACP_TOPICSUFFIXTAGS'],
				],
				'input_forums'		=> [
					'title'	=> 'ACP_TOPICSUFFIXTAGS_INPUT_FORUMS',
					'auth'	=> 'ext_marttiphpbb/topicsuffixtags && acl_a_board',
					'cat'	=> ['ACP_TOPICSUFFIXTAGS'],
				],
				'include_assets'		=> [
					'title'	=> 'ACP_TOPICSUFFIXTAGS_INCLUDE_ASSETS',
					'auth'	=> 'ext_marttiphpbb/topicsuffixtags && acl_a_board',
					'cat'	=> ['ACP_TOPICSUFFIXTAGS'],
				],
			],
		];
	}
}
