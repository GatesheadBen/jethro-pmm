<?php
class View__Groups extends View
{
	private $group = NULL;
	
	function getTitle()
	{
		if ($this->group) return $this->group->getValue('name');
	}

	function processView()
	{
		$this->group = $GLOBALS['system']->getDBObject('person_group', (int)$_REQUEST['groupid']);
	}
	
	function printView()
	{
		if (empty($_REQUEST['groupid'])) {
			trigger_error("Group ID missing");
			return;
		}
		
		$personIDs = $this->group->getMemberIDs(FALSE);
		$order = 'last_name, first_name';
		$persons = $GLOBALS['system']->getDBObjectData('member', Array('id' => $personIDs), 'OR', $order);
		$emails = Array();
		foreach ($persons as $member) {
			if ($e = $member['email']) $emails[] = $e;
		}
		
		include 'templates/member_list.template.php';
		
		if (count($persons) < EMAIL_CHUNK_SIZE) {
			echo '<a href="mailto:'.implode(',', $emails).'">Email all members</a>';
		}

	}

}
