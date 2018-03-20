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
	/** @var dispatcher */
	private $dispatcher;

	/** @var array */
	private $tags = [];

	/**
	 * @param dispatcher $dispatcher
	*/
	public function __construct(dispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @param array 
	 */
	public function trigger_event(array $topic_row)
	{
		$topic_id = $topic_row['topic_id'];	
		$tags = [];
	
		/**
		 * Run to set topic suffix tags 
		 *
		 * @event 
		 * @var	int 	topic_id		changing won't have effect on core
		 * @var	array	topic_row		changing won't have effect on core
		 * @var array	tags			push here your tags 
		 *
		 */
		$vars = ['topic_id', 'topic_row', 'tags'];
		$result = $this->dispatcher->trigger_event('marttiphpbb.topicsuffixtags.set_tags', compact($vars));

		if (count($result['tags']))
		{
			$this->tags[$topic_id] = $result['tags'];
		}
	}

	/**
	 * @return array
	 */
	public function get_all():array
	{
		return $this->tags;
	}
}
