<?php

namespace CmptrWz\UserDateTime\XF;

use XF\Db\AbstractAdapter;
use function array_key_exists;

class Language extends XFCP_Language
{
	// We can't store the formats in the custom field keys, so we store them here instead.
	// Most of these come from the XF2 Language date and time options, with the exception of the Y-m-d format.
	// No custom format included, though that wouldn't be much more difficult to implement.
	protected $cw_date_formats = [
		'mon_day_year' => 'M j, Y',
		'month_day_year' => 'F j, Y',
		'day_mon_year' => 'j M Y',
		'day_month_year' => 'j F Y',
		'dmy' => 'j/n/y',
		'mdy' => 'n/j/y',
		'dmyf' => 'j/n/Y',
		'mdyf' => 'n/j/Y',
		'ymd' => 'Y-m-d'
	];
	protected $cw_time_formats = [
		'12h' => 'g:i A',
		'24h' => 'H:i'
	];

	protected static $cwSeenUserProfile = [];

	// To actually change the date and time formats, we just need to override initialization.
	public function __construct($id, array $options, AbstractAdapter $db, $groupPath, array $phrases = null)
	{
		// Fetch the visitor
		$visitor = \XF::visitor();
		$userId = (int)$visitor->user_id;
		$profile = $visitor->Profile;
		// Check if they're logged in
		if ($userId !== 0 && $profile !== null && array_key_exists($userId, static::$cwSeenUserProfile))
		{
			static::$cwSeenUserProfile[$userId] = true;
			// Look for our settings in their custom fields
			$customFields = $profile->custom_fields;
			// We only override each of these if the value is set to something we have a format string for
			// Otherwise we leave the relevant setting untouched so things can fall through
			$userDate = $this->cw_date_formats[$customFields->getFieldValue('cw_user_date')] ?? null;
			if ($userDate !== null)
			{
				$options['date_format'] = $userDate;
			}

			$userTime = $this->cw_time_formats[$customFields->getFieldValue('cw_user_time')] ?? null;
			if ($userTime !== null)
			{
				$options['time_format'] = $userTime;
			}
		}

		// Now that we're done potentially tweaking $options, resume normal service.
		parent::__construct($id, $options, $db, $groupPath, $phrases);
	}
}
