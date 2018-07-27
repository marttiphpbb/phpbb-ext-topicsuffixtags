<?php

/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\service;

use phpbb\event\dispatcher;

class tags
{
	protected $dispatcher;
	protected $tags = [];

	public function __construct(dispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	public function trigger_event(string $origin_event_name, array $topic_data)
	{
		$topic_id = $topic_data['topic_id'];
		$tags = [];

		/**
		 * Event to set topic suffix tags
		 *
		 * @event
		 * @var	int 	topic_id			changing won't be fed back to calling event
		 * @var	array	topic_data			changing won't be fed back to calling event
		 * @var string  origin_event_name	name of the original event
		 * @var array	tags				push here your tags
		 *
		 */
		$vars = ['topic_id', 'topic_data', 'origin_event_name', 'tags'];
		$result = $this->dispatcher->trigger_event('marttiphpbb.topicsuffixtags', compact($vars));

		if (count($result['tags']))
		{
			$this->tags[$topic_id] = $result['tags'];
		}
	}

	public function get_all():array
	{
		return $this->tags;
	}
}
