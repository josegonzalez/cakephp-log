<?php
class LoggingComponent extends Object {
/**
 * Initialize component
 *
 * @param object $controller Instantiating controller
 * @access public
 */
	function initialize(&$controller, $settings = array()) {
		if (!count($controller->uses) || get_parent_class($controller->{$controller->modelClass}) == 'Object') return;
		if (!$controller->{$controller->modelClass}->Behaviors->attached('Logable')) return;

		// Auto-import user data if AuthsomeComponent is in use
		if (class_exists('Authsome')) {
			if (!Authsome::get('guest')) {
				$controller->{$controller->modelClass}->setUserData(Authsome::get());
			}
		}

		// Auto-import user data if AuthComponent is in use
		if (!empty($controller->Auth)) {
			$user = $controller->Auth->user();
			if ($user !== null) {
				$controller->{$controller->modelClass}->setUserData(array('User' => $user));
			}
		}

		$controller->{$controller->modelClass}->setRequestParameters($controller->params);
		$controller->{$controller->modelClass}->setUserBrowser($_SERVER['HTTP_USER_AGENT']);
		$controller->{$controller->modelClass}->setUserIp($_SERVER['REMOTE_ADDR']);
	}
}
?>