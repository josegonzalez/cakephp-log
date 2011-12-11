<?php
class Log extends LogAppModel {
	var $name = 'Log';
	var $order = 'Log.created DESC';
	var $_findMethods = array('dashboard' => true);

	function _findDashboard($state, $query, $results = array()) {
		if ($state == 'before') {
			$query['contain'] = array('User');
			$query['limit'] = 20;
			return $query;
		} elseif ($state == 'after') {
			return $results;
		}
	}

}
