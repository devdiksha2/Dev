<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (C) 2010 - 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');
 
class Helix3FeatureAccount {

	private $helix3;
	public $position;

	public function __construct( $helix3 ){
		$this->helix3 = $helix3;
		$this->position = 'menu';
	}

	public function renderFeature() {

		$user = JFactory::getUser();

		$output = '';

		if($user->guest) {
			$output .= '<ul class="sp-my-account">';
			$output .= '<li><a class="sp-main-login btn btn-primary" href="' . JRoute::_( 'index.php?option=com_users&view=login' . self::getItemid() ) . '">' . JText::_('JLOGIN') . '</a></li>';
			$output .= '</ul>';
		} else {
			$output .= '<ul class="sp-my-account">';
			$output .= '<li><a class="btn btn-primary btn-account" href="#">' . JText::_('HELIX_ACCOUNT') . '</a>';
			$output .= '<div>';
			$output .= JFactory::getDocument()->getBuffer('modules', 'myaccount', array('style' => 'none'));
			$output .= '</div>';
			$output .= '</li>';
			$output .= '</ul>';
		}

		return $output;
	}

	public static function getItemid($view = 'login') {
		$db = JFactory::getDbo();
 
		$query = $db->getQuery(true); 
		$query->select($db->quoteName(array('id')));
		$query->from($db->quoteName('#__menu'));
		$query->where($db->quoteName('link') . ' LIKE '. $db->quote('%option=com_users&view='. $view .'%'));
		$query->where($db->quoteName('published') . ' = '. $db->quote('1'));
		$db->setQuery($query);
		$result = $db->loadResult();

		if(!empty($result)) {
			return '&Itemid=' . $result;
		}

		return;
	}

}