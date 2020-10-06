<?php

namespace CmptrWz\UserDateTime\XF;

// We don't really use this, but need it for the $db parameter passthrough.
use XF\Db\AbstractAdapter;

class Language extends XFCP_Language
{
	// We can't store the formats in the custom field keys, so we store them here instead.
	// Most of these come from the XF2 Language date and time options, with the exception of the Y-m-d format.
	// No custom format included, though that wouldn't be much more difficult to implement.
	private $cw_date_formats = [
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
	private $cw_time_formats = [
		'12h' => 'g:i A',
		'24h' => 'H:i'
	];
	// To actually change the date and time formats, we just need to override initialization.
	public function __construct($id, array $options, AbstractAdapter $db, $groupPath, array $phrases = null)
	{
		// Fetch the visitor
		$visitor = \XF::visitor();
		$profile = $visitor->Profile;
		// Check if they're logged in
		if ($visitor->user_id && $profile)
		{
			// Look for our settings in their custom fields
			$customFields = $profile->custom_fields;
			// We only override each of these if the value is set to something we have a format string for
			// Otherwise we leave the relevant setting untouched so things can fall through
			if (isset($customFields->cw_user_date) && isset($this->cw_date_formats[$customFields->cw_user_date]))
			{
				$options['date_format'] = $this->cw_date_formats[$customFields->cw_user_date];
			}
			if (isset($customFields->cw_user_time) && isset($this->cw_time_formats[$customFields->cw_user_time]))
			{
				$options['time_format'] = $this->cw_time_formats[$customFields->cw_user_time];
			}
		}
		// Now that we're done potentially tweaking $options, resume normal service.
		parent::__construct($id, $options, $db, $groupPath, $phrases);
	}
}
