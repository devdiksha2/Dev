<?php
    /**
     * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
     * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
     * @author iJoomla.com <webmaster@ijoomla.com>
     * @url https://www.jomsocial.com/license-agreement
     * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
     * More info at https://www.jomsocial.com/license-agreement
     */
    defined('_JEXEC') or die('Restricted access');

    include_once(JPATH_BASE . '/components/com_community/defines.community.php');
    require_once(JPATH_BASE . '/components/com_community/libraries/core.php');

    //add style css
    JFactory::getLanguage()->isRTL() ? CTemplate::addStylesheet('style.rtl') : CTemplate::addStylesheet('style');

    $model = CFactory::getModel('groups');
    $default = $params->get('default');

    $tmpGroups = $model->getAllGroups(null, null, null, $default, true);
    $groups = array();

    $data = array();

    foreach ($tmpGroups as $row) {
        $group = JTable::getInstance('Group', 'CTable');
        $group->bind($row);
        $group->description = JHTML::_('string.truncate', $group->description, 30);
        $groups[] = $group;
    }

    require(JModuleHelper::getLayoutPath('mod_community_groups', $params->get('layout', 'default')));
