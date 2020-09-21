<?php

namespace CmptrWz\UserDateTime\XF;

use XF\Db\AbstractAdapter;

class Language extends XFCP_Language
{
	private $cw_date_formats = [
		'mon_day_year' => 'M j, Y',
		'month_day_year' => 'F j, Y',
		'day_mon_year' => 'j M Y',
		'day_month_year' => 'j F Y',
		'dmy' => 'j/n/y',
		'mdy' => 'n/j/y',
		'ymd' => 'Y-m-d'
	];
	private $cw_time_formats = [
		'12h' => 'g:i A',
		'24h' => 'H:i'
	];
	public function __construct($id, array $options, AbstractAdapter $db, $groupPath, array $phrases = null)
	{
		$visitor = \XF::visitor();
		if ($visitor->user_id)
		{
			$customFields = $visitor->Profile->custom_fields;
			if (isset($customFields->cw_user_date) && isset($this->cw_date_formats[$customFields->cw_user_date]))
			{
				$options['date_format'] = $this->cw_date_formats[$customFields->cw_user_date];
			}
			if (isset($customFields->cw_user_time) && isset($this->cw_time_formats[$customFields->cw_user_time]))
			{
				$options['time_format'] = $this->cw_time_formats[$customFields->cw_user_time];
			}
		}
		parent::__construct($id, $options, $db, $groupPath, $phrases);
	}
}
