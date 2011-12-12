<?php
class Log extends LogAppModel {
	var $name = 'Log';
	var $order = 'Log.created DESC';
	var $findMethods = array('dashboard' => true);
	
	// we need to explicitly set this in order for the find methods to work
	var $belongsTo = array('User');

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
