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

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php');

class plgCommunityEvents extends CApplications
{
    var $name       = "Events";
    var $_name      = 'events';

    function plgCommunityEvents(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }

    function onProfileDisplay()
    {
        JPlugin::loadLanguage( 'plg_community_events', JPATH_ADMINISTRATOR );

        $config = CFactory::getConfig();

        if( !$config->get('enableevents') )
        {
            return JText::_('PLG_EVENTS_EVENT_DISABLED');
        }

        $document   = JFactory::getDocument();

        $mainframe  = JFactory::getApplication();
        $user       = CFactory::getRequestUser();
        $caching    = $this->params->get('cache', 1);
        $model      = CFactory::getModel( 'Events' );
        $my         = CFactory::getUser();
        $this->loadUserParams();

        //CFactory::load( 'helpers' , 'event' );
        $event      = JTable::getInstance( 'Event' , 'CTable' );
        $handler    = CEventHelper::getHandler( $event );

        $events     = $model->getEvents( null , $user->id , $this->params->get( 'sorting' , 'latest' ) , null , true , false , null , null ,$handler->getContentTypes() , $handler->getContentId() , $this->userparams->get('count', 5 ) );

        if($this->params->get('hide_empty', 0) && !count($events)) return '';

        if($caching)
        {
            $caching = $mainframe->getCfg('caching');
        }

        $creatable  = false;

        if( $my-> id == $user->id )
        {
            $creatable  = true;
        }
        $cache      = JFactory::getCache('plgCommunityEvents');
        $cache->setCaching($caching);
        $callback   = array( $this , '_getEventsHTML');
        $content    = $cache->call($callback, true , $events , $user , $config , $model->getEventsCount( $user->id ) , $creatable );
        return $content;
    }

    function _getEventsHTML( $createEvents , $rows , $user , $config , $totalEvents , $creatable )
    {
        ob_start();
        ?>

        <?php

        if( $rows ) { ?>
        <ul class="joms-list--event">
        <?php
        foreach( $rows as $row ) {
            $event          = JTable::getInstance( 'Event', 'CTable' );
            $event->load( $row->id );

            $creator        =   CFactory::getUser($event->creator);

            // Get the formated date & time
            $format         =   ($config->get('eventshowampm')) ?  JText::_('COM_COMMUNITY_DATE_FORMAT_LC2_12H') : JText::_('COM_COMMUNITY_DATE_FORMAT_LC2_24H');
            $startdatehtml   =  CTimeHelper::getFormattedTime($event->startdate, $format);
            $enddatehtml        =   CTimeHelper::getFormattedTime($event->enddate, $format);
        ?>

            <li class="joms-media--event" title="<?php echo CStringHelper::escape( $event->summary );?>">
                <div class="joms-media__calendar">
                    <span class="month"><?php echo CEventHelper::formatStartDate($event, JText::_('M') ); ?></span>
                    <span class="date"><?php echo CEventHelper::formatStartDate($event, JText::_('d') ); ?></span>
                </div>
                <div class="joms-media__body">
                    <a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewevent&eventid=' . $event->id );?>"><?php echo $event->title;?></a>
                    <span class="joms-block"><?php echo $event->location;?></span>
                    <a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewguest&eventid=' . $event->id . '&type='.COMMUNITY_EVENT_STATUS_ATTEND);?>"><?php echo JText::sprintf((!CStringHelper::isSingular($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT_MANY':'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT', $event->confirmedcount);?></a>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php
        }
        else
        {
        ?>
            <div><?php echo JText::_('PLG_EVENTS_NO_EVENTS_CREATED_BY_THE_USER_YET');?></div>
        <?php
        }
        ?>
        <small>
        <a class="joms-button--link" href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=create' );?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_CREATE');?></a>
        <a class="joms-button--link" href="<?php echo CRoute::_('index.php?option=com_community&view=events');?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_ALL_EVENTS').' ('.$totalEvents.')';?></a>
        </small>

        <?php
        $content    = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
