<?php
/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\event;

use phpbb\template\template;
use marttiphpbb\topicsuffixtags\service\tags;
use phpbb\event\data as event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var template */
	protected $template;

	/** @var tags */
	protected $tags;

	/**
	* @param template	$template
	* @param tags 		$tags
	*/
	public function __construct(template $template, tags $tags)
	{
		$this->template = $template;
		$this->tags = $tags;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.viewtopic_assign_template_vars_before'
				=> 'core_viewtopic_assign_template_vars_before',
			'core.viewforum_modify_topicrow'
				=> 'core_viewforum_modify_topicrow',
			'core.mcp_view_forum_modify_topicrow'
				=> 'core_mcp_view_forum_modify_topicrow',
			'core.search_modify_tpl_ary'
				=> 'core_search_modify_tpl_ary',
			'core.posting_modify_template_vars'
				=> 'core_posting_modify_template_vars',
			'core.twig_environment_render_template_before'
				=> 'core_twig_environment_render_template_before',
		];
	}

	public function core_posting_modify_template_vars(event $event)
	{
		$this->tags->trigger_event($event['post_data']);
	}

	public function core_search_modify_tpl_ary(event $event)
	{
		if ($event['show_results'] === 'topics')
		{
			$this->tags->trigger_event($event['row']);
		}
	}

	public function core_viewforum_modify_topicrow(event $event)
	{
		$this->tags->trigger_event($event['row']);		
	}

	public function core_mcp_view_forum_modify_topicrow(event $event)
	{
		$this->tags->trigger_event($event['row']);		
	}

	public function core_viewtopic_assign_template_vars_before(event $event)
	{
		$this->tags->trigger_event($event['topic_data']);
	}

	public function core_twig_environment_render_template_before(event $event)
	{
		$event['context']['marttiphpbb_topicsuffixtags_tags'] = $this->tags->get_all();
	}
}
