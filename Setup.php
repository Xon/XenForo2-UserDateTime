<?php

namespace CmptrWz\UserDateTime;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1(): void
	{
		// Add our custom user fields, but only if they don't already exist.
		// Check each individually in case uninstall and reinstall is done to reset a list
		$this->addSelectCustomField('cw_user_date', 'Preferred Date Format', '', [
			'mon_day_year'   => 'Aug 29, 2020',
			'month_day_year' => 'August 29, 2020',
			'day_mon_year'   => '29 Aug 2020',
			'day_month_year' => '29 August 2020',
			'dmy'            => '29/8/20',
			'mdy'            => '8/29/20',
			'dmyf'           => '29/8/2020',
			'mdyf'           => '8/29/2020',
			'ymd'            => '2020-08-29',
		]);
	}

	public function installStep2(): void
	{
		$this->addSelectCustomField('cw_user_time', 'Preferred Time Format', '', [
			'12h' => '7:30 PM',
			'24h' => '19:30',
		]);
	}

	public function uninstallStep1(): void
	{
		// Leaving the custom user fields in place intentionally, so no uninstall changes needed at this time
	}

	protected function addSelectCustomField(string $name, string $title, string $description, array $choices): \XF\Entity\UserField
	{
		$field = \XF::em()->find('XF:UserField', $name);
		if ($field === null)
		{
			/** @var \XF\Entity\UserField $field */
			$field = \XF::em()->create('XF:UserField');
			$field->field_id = $name;
			$field->display_group = 'preferences';
			$field->field_type = 'select';
			$field->moderator_editable = false;
			$field->required = false;
			$field->show_registration = true;
			$field->user_editable = 'yes';
			$field->viewable_message = false;
			$field->viewable_profile = false;
			$field->display_order = 10 + (int)\XF::db()->fetchOne('select max(display_order) from xf_user_field');

			// Need a new phrase for the title
			$timeTitle = $field->getMasterPhrase(true);
			$timeTitle->phrase_text = $title;
			$field->addCascadedSave($timeTitle);

			// And another for the description
			$timeDesc = $field->getMasterPhrase(false);
			$timeDesc->phrase_text = $description;
			$field->addCascadedSave($timeDesc);

			// The keys in this list need to match those in the Language.php extension
			$field->field_choices = $choices;

			$field->save();
		}

		return $field;
	}
}
