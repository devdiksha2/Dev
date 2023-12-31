<?php
    /**
     * @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
     * @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
     * @author iJoomla.com <webmaster@ijoomla.com>
     * @url https://www.jomsocial.com/license-agreement
     * The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
     * More info at https://www.jomsocial.com/license-agreement
     */
    // no direct access
    defined('_JEXEC') or die('Restricted access');

    require_once(dirname(__FILE__) . '/helper.php');

    // include_once(JPATH_BASE . '/components/com_community/defines.community.php');
    // require_once(JPATH_BASE . '/components/com_community/libraries/core.php');

    JFactory::getLanguage()->isRTL() ? CTemplate::addStylesheet('style.rtl') : CTemplate::addStylesheet('style');

    $modActiveGroupsHelper = new modActiveGroupsHelper();
    $groups = $modActiveGroupsHelper->getGroupsData($params);
    require(JModuleHelper::getLayoutPath('mod_activegroups', $params->get('layout', 'default')));
