<?php
/**
* @package com_splms
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2023 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class SplmsViewLesson extends HtmlView {

	protected $form;
	protected $item;
	protected $canDo;
	protected $id;

	public function display($tpl = null) {
		// Get the Data
		$model = $this->getModel('Lesson');
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->id = $this->item->id;

		$this->canDo = SplmsHelper::getActions($this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new RuntimeException(implode("\n", $errors), 500);
			return false;
		}

		$this->addToolBar();
		parent::display($tpl);
	}

	protected function addToolBar() {
		$input = Factory::getApplication()->input;
		$userId       = Factory::getUser()->id;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);

		ToolbarHelper::title(Text::_('COM_SPLMS_LESSONS') . ': '.  ($isNew ? Text::_('COM_SPSPLMS_NEW') : Text::_('COM_SPSPLMS_EDIT')), 'pencil');
		if ($isNew) {
			// For new records, check the create permission.
			if ($this->canDo->get('core.create')) {
				ToolbarHelper::apply('lesson.apply', 'JTOOLBAR_APPLY');
				ToolbarHelper::save('lesson.save', 'JTOOLBAR_SAVE');
			}
			ToolbarHelper::cancel('lesson.cancel', 'JTOOLBAR_CANCEL');
		} else {
			if ($this->canDo->get('core.edit') || $this->canDo->get('core.edit.own') && $this->item->created_by == $userId ) {
				// We can save the new record
				ToolbarHelper::apply('lesson.apply', 'JTOOLBAR_APPLY');
				ToolbarHelper::save('lesson.save', 'JTOOLBAR_SAVE');
			}
			ToolbarHelper::cancel('lesson.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
