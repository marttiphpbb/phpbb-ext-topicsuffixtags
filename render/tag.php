<?php

/**
* phpBB Extension - marttiphpbb topicsuffixtags
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\topicsuffixtags\render;

use phpbb\controller\helper;
use marttiphpbb\topicsuffixtags\util\dateformat;

class tag
{
	/* @var helper */
	private $helper;

	/* @var dateformat */
	private $dateformat;

	/**
	* @param helper		$helper
	* @param dateformat	$dateformat
	*/
	public function __construct(helper $helper, dateformat $dateformat)
	{
		$this->helper = $helper;
		$this->dateformat = $dateformat;
	}

	/*
	 * @param array 
	 * @return array
	 */
	public function get(array $input):array
	{
		$start = $input['topic_topicsuffixtags_start'];

		if (!$start)
		{
			return [];
		}

		$end = $input['topic_topicsuffixtags_end'];
		
		$year = gmdate('Y', $start);
		$month = gmdate('n', $start);

		return [
			'TOPICSUFFIXTAGS_TAG_URL' => $this->helper->route('marttiphpbb_topicsuffixtags_monthview_controller', ['year' => $year, 'month' => $month]),
			'TOPICSUFFIXTAGS_TAG' => $this->dateformat->get_period($start, $end),
		];
	}
}
