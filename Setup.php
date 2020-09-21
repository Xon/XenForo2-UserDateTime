<?php

namespace CmptrWz\UserDateTime;

use XF\AddOn\AbstractSetup;

class Setup extends AbstractSetup
{
	public function install(array $stepParams = [])
	{
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
			$dateTitle = $userDate->getMasterPhrase(true);
			$dateTitle->phrase_text = 'Preferred Date Format';
			$userDate->addCascadedSave($dateTitle);

			$dateDesc = $userDate->getMasterPhrase(false);
			$dateDesc->phrase_text = '';
			$userDate->addCascadedSave($dateDesc);

			$userDate->field_choices = [
				'mon_day_year' => 'Aug 29, 2020',
				'month_day_year' => 'August 29, 2020',
				'day_mon_year' => '29 Aug 2020',
				'day_month_year' => '29 August 2020',
				'dmy' => '29/8/20',
				'mdy' => '8/29/20',
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
			$timeTitle = $userTime->getMasterPhrase(true);
			$timeTitle->phrase_text = 'Preferred Time Format';
			$userTime->addCascadedSave($timeTitle);

			$timeDesc = $userTime->getMasterPhrase(false);
			$timeDesc->phrase_text = '';
			$userTime->addCascadedSave($timeDesc);

			$userTime->field_choices = [
				'12h' => '7:30 PM',
				'24h' => '19:30'
			];

			$userTime->save();
		}

	}

	public function upgrade(array $stepParams = [])
	{
		// TODO: Implement upgrade() method.
	}

	public function uninstall(array $stepParams = [])
	{
		// TODO: Implement uninstall() method.
	}
}
