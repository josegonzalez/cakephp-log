<?php
class LogsController extends AppController {
	var $name = 'Logs';
	var $helpers = array('Log.Log', 'Time');

	public function index() {
		$this->set('logs', $this->Log->find('dashboard'));
	}
}
?>