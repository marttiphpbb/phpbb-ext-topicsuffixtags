<?php

/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\core;

use marttiphpbb\topicsuffixtags\core\timespan;
use marttiphpbb\topicsuffixtags\core\topicsuffixtags_event;

class topicsuffixtags_event_row
{
	/* @var timespan  */
	protected $timespan;

	/* @var array */
	protected $free_timespans = [];

	/* @var array */
	protected $topicsuffixtags_events = [];

	/**
	 * @param timespan $timespan
	 */

	public function __construct(
		timespan $timespan
	)
	{
		$this->timespan = $timespan;
		$this->free_timespans = [$timespan];
	}

	/*
	*/
	public function insert_topicsuffixtags_event(topicsuffixtags_event $topicsuffixtags_event)
	{
		$timespan = $topicsuffixtags_event->get_timespan();

		foreach ($this->topicsuffixtags_events as $ev)
		{
			if ($ev->overlaps($timespan))
			{
				return false;
			}
		}

		$this->topicsuffixtags_events[] = $topicsuffixtags_event;

		return true;
	}
}
