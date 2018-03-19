<?php
/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\migrations;

class v_0_1_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		$settings = [

		];

		return [

			['config_text.add', ['marttiphpbb_topicsuffixtags', serialize($settings)]],

			['config.add', ['topicsuffixtags_render_settings', 7]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_TOPICSUFFIXTAGS'
			]],
			['module.add', [
				'acp',
				'ACP_TOPICSUFFIXTAGS',
				[
					'module_basename'	=> '\marttiphpbb\topicsuffixtags\acp\main_module',
					'modes'				=> [
						'links',
					],
				],
			]],
		];
	}

	public function update_schema()
	{
		return [
			'add_columns'        => [
				$this->table_prefix . 'topics'        => [
					'topic_topicsuffixtags_start_day'  		=> ['UINT', NULL],
					'topic_topicsuffixtags_end_day' 			=> ['UINT', NULL],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'        => [
				$this->table_prefix . 'topics'        => [
					'topic_topicsuffixtags_start_day',
					'topic_topicsuffixtags_end_day',
				],
			],
		];
	}
}
