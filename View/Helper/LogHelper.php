<?php
class LogHelper extends AppHelper {
	var $helpers = array('Html', 'Time');
	var $lastSeen = null;

/**
 * Check if a value has changed from the last iteration of a loop.
 *
 * @param string $compareTo String you want to check against.
 * @return bool True if changed, otherwise false.
 * @author Bjorn Post
 */
	function checkIfChanged($compareTo) {
		$return = ($this->lastSeen === $compareTo) ? false : true;
		$this->lastSeen = $compareTo;
		return $return;
	}

/**
 * undocumented function
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function logDate($created) {
		if ($this->Time->isToday($created)) {
 			$date = "<mark>" . __('Today', true) . "</mark>";
		} elseif ($this->Time->wasYesterday($created)) {
			$date = __('Yesterday', true);
		} else {
 			$date = $this->Time->format('d M', $created);
		}
		return "<strong>{$date}</strong>";
	}

/**
 * undocumented function
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function logTitle($log, $extraParams = array()) {
		
		$defaultRouteParams = array(
			'plugin' => false,
			'controller' => Inflector::tableize($log['model']),
			'action' => 'view',
			'id' => $log['model_id']
		);
		
		$finalRouteParams = array_merge($defaultRouteParams, $extraParams);
		
		return $this->Html->link($log['title'], $finalRouteParams);
	}

/**
 * undocumented function
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function logType($log) {
		$class = strtolower($log['model']);
		$styles = $this->stylize($log['model']);
		return "<span class=\"{$class}\" style=\"{$styles}\">{$log['model']}</span>";
	}

/**
 * undocumented function
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function logOwner($action, $user) {
		$message = __('Created by %s ', true);
		switch ($action) {
			case 'add' :
				$message = __('Created by %s ', true);
				break;
			case 'delete' :
				$message = __('Deleted by %s ', true);
				break;
			default :
				$message = __('Updated by %s ', true);
				break;
		}

		$user_name = __('System', true);
		$nameFields = array('name', 'username', 'full_name', 'first_name', 'last_name', 'title');
		foreach ($nameFields as $field) {
			if (isset($user[$field])) {
				$user_name = $user[$field];
				break;
			}
		}
		return sprintf($message, "<span class=\"username\">{$user_name}</span>");
	}

/**
 * Returns the css for a particular word
 *
 * @param string $word any word that should be colorized
 * @param boolean $websafe whether the background color that is output should be websafe
 * @return string CSS for the current word
 * @author Jose Diaz-Gonzalez
 */
	function stylize($word, $websafe = true) {
		return "background:#{$this->colorize($word, $websafe)};color:#fff;padding:2px";
	}

/**
 * Turns any phrase into a 6 character hexadecimal color
 *
 * @param string $word
 * @return string
 * @author Jose Diaz-Gonzalez
 */
	function colorize($word, $websafe = true) {
		preg_match('/[\dA-Fa-f]{6}/', sha1($word), $color);
		if ($websafe) {
			$websafe_color = $this->color_mkwebsafe($color[0]);
			return (in_array($websafe_color, array('ffffcc', 'ffffff'))) ? 'ff9933' : $websafe_color;
		} else {
			return (in_array($color[0], array('ffffcc', 'ffffff'))) ? 'ff9933' : $color[0];
		}
	}

/**
 * Turns any hex color into a color safe version of itself
 *
 * @param string $in Hex color
 * @return string
 * @author Jose Diaz-Gonzalez
 */
	function color_mkwebsafe($in) {
		$vals['r'] = hexdec(substr($in, 0, 2));
		$vals['g'] = hexdec(substr($in, 2, 2));
		$vals['b'] = hexdec(substr($in, 4, 2));

		$out = '';
		foreach ($vals as $val) {
			$val = (round($val/51) * 51);
			$out .= str_pad(dechex($val), 2, '0', STR_PAD_LEFT);
		}

		return $out;
	}

	function colorizeText($word) {
		return (hexdec($this->colorize($word)) > 0xffffff/2) ? '000' : 'fff';
	}

	function correctShade($row1, $c) {
		$rgb = array(substr($row1,0,2), substr($row1,2,2), substr($row1,4,2));
		for($i=0; $i < 3; $i++) {
			if ((hexdec($rgb[$i])-$c) >= 0) {
				$rgb[$i] = hexdec($rgb[$i])-$c;
				$rgb[$i] = dechex($rgb[$i]);
				if (hexdec($rgb[0]) <= 9) $rgb[$i] = "0".$rgb[$i];
			} else {
				$rgb[$i] = "00";
			}
		}
 		return $rgb[0].$rgb[1].$rgb[2];
	}
	
	/**
	*
	* extra Helper methods to display specific messages
	**/
	function logAt($log) {
		
		$user_name = (isset($log['User']['name'])) ? $log['User']['name'] : __('System');
		return 'at ' . $this->Time->format('h:i a', $log['Log']['created']) . ' ' . __('by') . ' ' . $user_name;
	}
	
	function logAtWhatTime($log) {
		return $this->Time->format('h:i a', $log['Log']['created']);
	}
	
	function logByWhom($log, $userDisplayField='') {
		if (empty($userDisplayField)) {
			$user = ClassRegistry::init('User');
			$userDisplayField = $user->displayField;
		}
		
		// the assumption is that the user model is User. which i think is a pretty good assumption
		// given that we use cakephp
		return $log['User'][$userDisplayField];
		
	}
	
	/**
	*
	* extra Helper methods to display specific messages for specific actions
	*
	**/
	function logAction($log) {
		switch ($log['action']) {
			case 'add' :
				$message = __('created');
				break;
			case 'delete' :
				$message = __('deleted');
				break;
			default :
				$message = __('updated');
				break;
		}
		return $message;
	}
}
?>