<?php

namespace CmptrWz\UserDateTime;

use XF\AddOn\AbstractSetup;

class Setup extends AbstractSetup
{
	public function install(array $stepParams = [])
	{
		// Add our custom user fields, but only if they don't already exist.
		// Check each individually in case uninstall and reinstall is done to reset a list
		if (!\XF::em()->find('XF:UserField', 'cw_user_date'))
		{
			$userDate = \XF::em()->create('XF:UserField');
			$userDate->field_id = 'cw_user_date';
			$userDate->display_group = 'preferences';
			$userDate->field_type = 'select';
			$userDate->moderator_editable = false;
			$userDate->required = false;
			$userDate->show_registration = true;
			$userDate->user_editable = 'yes';
			$userDate->viewable_message = false;
			$userDate->viewable_profile = false;

			// Need a new phrase for the title
			$dateTitle = $userDate->getMasterPhrase(true);
			$dateTitle->phrase_text = 'Preferred Date Format';
			$userDate->addCascadedSave($dateTitle);

			// And another for the description
			$dateDesc = $userDate->getMasterPhrase(false);
			$dateDesc->phrase_text = '';
			$userDate->addCascadedSave($dateDesc);

			// The keys in this list need to match those in the Language.php extension
			$userDate->field_choices = [
				'mon_day_year' => 'Aug 29, 2020',
				'month_day_year' => 'August 29, 2020',
				'day_mon_year' => '29 Aug 2020',
				'day_month_year' => '29 August 2020',
				'dmy' => '29/8/20',
				'mdy' => '8/29/20',
				'dmyf' => '29/8/2020',
				'mdyf' => '8/29/2020',
				'ymd' => '2020-08-29'
			];

			$userDate->save();
		}
		if (!\XF::em()->find('XF:UserField', 'cw_user_time'))
		{
			$userTime = \XF::em()->create('XF:UserField');
			$userTime->field_id = 'cw_user_time';
			$userTime->display_group = 'preferences';
			$userTime->field_type = 'select';
			$userTime->moderator_editable = false;
			$userTime->required = false;
			$userTime->show_registration = true;
			$userTime->user_editable = 'yes';
			$userTime->viewable_message = false;
			$userTime->viewable_profile = false;

			// Need a new phrase for the title
			$timeTitle = $userTime->getMasterPhrase(true);
			$timeTitle->phrase_text = 'Preferred Time Format';
			$userTime->addCascadedSave($timeTitle);

			// And another for the description
			$timeDesc = $userTime->getMasterPhrase(false);
			$timeDesc->phrase_text = '';
			$userTime->addCascadedSave($timeDesc);

			// The keys in this list need to match those in the Language.php extension
			$userTime->field_choices = [
				'12h' => '7:30 PM',
				'24h' => '19:30'
			];

			$userTime->save();
		}
	}

	public function upgrade(array $stepParams = [])
	{
		// No upgrade changes needed at this time.
	}

	public function uninstall(array $stepParams = [])
	{
		// Leaving the custom user fields in place intentionally, so no uninstall changes needed at this time
	}
}
