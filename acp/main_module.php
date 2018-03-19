<?php
/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $template, $request;
		global $config, $phpbb_root_path;
		global $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang('acp', 'marttiphpbb/topicsuffixtags');
		add_form_key('marttiphpbb/topicsuffixtags');

		switch($mode)
		{
			case 'links':

				$links = $phpbb_container->get('marttiphpbb.topicsuffixtags.render.links');

				$this->tpl_name = 'links';
				$this->page_title = $language->lang('ACP_TOPICSUFFIXTAGS_LINKS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/topicsuffixtags'))
					{
						trigger_error('FORM_INVALID');
					}

					$links->set($request->variable('links', [0 => 0]), $request->variable('topicsuffixtags_repo_link', 0));

					trigger_error($language->lang('ACP_TOPICSUFFIXTAGS_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$links->assign_acp_select_template_vars();

				break;

			case 'page_rendering':

				$render_settings = $phpbb_container->get('marttiphpbb.topicsuffixtags.render.render_settings');

				$this->tpl_name = 'page_rendering';
				$this->page_title = $language->lang('ACP_TOPICSUFFIXTAGS_PAGE_RENDERING');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/topicsuffixtags'))
					{
						trigger_error('FORM_INVALID');
					}

					$render_settings->set($request->variable('render_settings', [0 => 0]));
					$config->set('topicsuffixtags_first_weekday', $request->variable('topicsuffixtags_first_weekday', 0));
					$config->set('topicsuffixtags_min_rows', $request->variable('topicsuffixtags_min_rows', 5));

					trigger_error($language->lang('ACP_TOPICSUFFIXTAGS_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

				foreach ($weekdays as $value => $name)
				{
					$template->assign_block_vars('weekdays', [
						'VALUE'			=> $value,
						'S_SELECTED'	=> $config['topicsuffixtags_first_weekday'] == $value ? true : false,
						'LANG'			=> $language->lang(['datetime', $name]),
					]);
				}

				$render_settings->assign_acp_template_vars();

				$template->assign_var('TOPICSUFFIXTAGS_MIN_ROWS', $config['topicsuffixtags_min_rows']);

				break;

			case 'input':

				$this->tpl_name = 'input';
				$this->page_title = $language->lang('ACP_TOPICSUFFIXTAGS_INPUT');

				$input_settings = $phpbb_container->get('marttiphpbb.topicsuffixtags.render.input_settings');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/topicsuffixtags'))
					{
						trigger_error('FORM_INVALID');
					}

					$input_names = array_keys($input_settings->get_days());

					$set_ary = [];

					foreach ($input_names as $name)
					{
						$set_ary[$name] = $request->variable($name, 0);
					}

					$input_settings->set_days($set_ary);

					trigger_error($language->lang('ACP_TOPICSUFFIXTAGS_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$input_settings->assign_acp_template_vars();

				break;

			case 'input_forums':

				$this->tpl_name = 'input_forums';
				$this->page_title = $language->lang('ACP_TOPICSUFFIXTAGS_INPUT_FORUMS');

				$input_settings = $phpbb_container->get('marttiphpbb.topicsuffixtags.render.input_settings');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/topicsuffixtags'))
					{
						trigger_error('FORM_INVALID');
					}

					$enabled_ary = $request->variable('enabled', [0 => 0]);
					$required_ary = $request->variable('required', [0 => 0]);

					$forum_ary = [];

					foreach ($enabled_ary as $fid)
					{
						$forum_ary[$fid]['enabled'] = true;
					}

					foreach ($required_ary as $fid)
					{
						$forum_ary[$fid]['required'] = true;
					}

					$input_settings->set_forums($forum_ary);

					trigger_error($language->lang('ACP_TOPICSUFFIXTAGS_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$input_ary = $input_settings->get_forums();

				$cforums = make_forum_select(false, false, false, false, true, false, true);

				if (sizeof($cforums))
				{
					foreach ($cforums as $forum)
					{
						$forum_id = $forum['forum_id'];

						$template->assign_block_vars('cforums', [
							'NAME'		=> $forum['padding'] . $forum['forum_name'],
							'ID'		=> $forum_id,
							'ENABLED'	=> isset($input_ary[$forum_id]['enabled']) ? true : false,
							'REQUIRED'	=> isset($input_ary[$forum_id]['required']) ? true : false,
						]);
					}
				}

				$input_settings->assign_acp_template_vars();

				break;

			case 'include_assets':

				$include_assets = $phpbb_container->get('marttiphpbb.topicsuffixtags.render.include_assets');
	
				$this->tpl_name = 'include_assets';
				$this->page_title = $language->lang('ACP_TOPICSUFFIXTAGS_INCLUDE_ASSETS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/topicsuffixtags'))
					{
						trigger_error('FORM_INVALID');
					}

					$include_assets->set($request->variable('include_assets', [0 => 0]));
					$config->set('topicsuffixtags_datepicker_theme', $request->variable('topicsuffixtags_datepicker_theme', ''));

					trigger_error($language->lang('ACP_TOPICSUFFIXTAGS_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$include_assets->assign_acp_select_template_vars();
		
				break;
		}

		$template->assign_var('U_ACTION', $this->u_action);
	}
}
