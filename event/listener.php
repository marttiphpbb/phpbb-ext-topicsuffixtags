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
	private $template;

	/** @var tags */
	private $tags;

	/** @var bool */
	private $mcp_topic_triggered;

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
			'core.mcp_topic_review_modify_row'
				=> 'core_mcp_topic_review_modify_row',
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

		if (isset($event['post_data']['topic_id']))
		{
			$page_data = $event['page_data'];
			$page_data['TOPIC_ID'] = $event['post_data']['topic_id'];
			$event['page_data'] = $page_data;			
		}
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

	public function core_mcp_topic_review_modify_row(event $event)
	{
		if (!isset($this->mcp_topic_triggered))
		{
			/**
			 * Because the event core.mcp_topic_modify_post_data does not contain topic_info (?),
			 * we have to use the post row event core.mcp_topic_review_modify_row but we only need it once.
			 */
			$this->tags->trigger_event($event['topic_info']);
			$this->mcp_topic_triggered = true;
			$this->template->assign_var('TOPIC_ID', $event['topic_id']);	
		}
	}

	public function core_viewtopic_assign_template_vars_before(event $event)
	{
		$this->tags->trigger_event($event['topic_data']);
	}

	public function core_twig_environment_render_template_before(event $event)
	{
		$context = $event['context'];
		$context['marttiphpbb_topicsuffixtags_tags'] = $this->tags->get_all();
		$event['context'] = $context;
	}
}
