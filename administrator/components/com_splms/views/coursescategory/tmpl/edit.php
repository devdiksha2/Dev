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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

$doc = Factory::getDocument();
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
if(SplmsHelper::getJoomlaVersion() < 4)
{
  HTMLHelper::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0 ));
}

$doc->addStylesheet(Uri::base(true) . '/components/com_speasyimagegallery/assets/css/font-awesome.min.css');
$doc->addStylesheet(Uri::base(true) . '/components/com_speasyimagegallery/assets/css/style.css');
$doc->addScript(Uri::base(true) . '/components/com_speasyimagegallery/assets/js/validation.js');
$doc->addScript(Uri::base(true) . '/components/com_speasyimagegallery/assets/js/script.js');

$rowClass = JVERSION < 4 ? 'row-fluid' : 'row';
$colClass = JVERSION < 4 ? 'span' : 'col-lg-';
?>
<form action="<?php echo Route::_('index.php?option=com_splms&layout=edit&id=' . (int) $this->item->id); ?>"
  method="post" name="adminForm" id="adminForm" class="form-validate">
  <div class="form-horizontal">
    <div class="<?php echo $rowClass;?>">
      <div class="<?php echo $colClass;?>9">
        <?php
          if( (int) $this->params->get('subcategory_enabled') === 1 ) {
            echo $this->form->renderFieldset('subcategory'); 
          }
        ?>
        <?php echo $this->form->renderFieldset('basic'); ?>
      </div>

      <div class="<?php echo $colClass;?>3">
        <fieldset class="form-vertical">
          <?php echo $this->form->renderFieldset('sidebar'); ?>
        </fieldset>
      </div>
    </div>

  </div>

  <input type="hidden" name="task" value="course.edit" />
  <?php echo HTMLHelper::_('form.token'); ?>
</form>

