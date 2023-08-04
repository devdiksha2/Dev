<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('restricted aceess');

class SppagebuilderAddonUpcoming_events extends SppagebuilderAddons {

    public function render() {

        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

        //Options
        $subtitle = (isset($this->addon->settings->subtitle) && $this->addon->settings->subtitle) ? $this->addon->settings->subtitle : '';
        $layout = (isset($this->addon->settings->layout) && $this->addon->settings->layout) ? $this->addon->settings->layout : '';
        $limit = (isset($this->addon->settings->limit) && $this->addon->settings->limit) ? $this->addon->settings->limit : '12';

        $output = '';

        $helper = JPATH_BASE . '/components/com_splms/helpers/helper.php';
        if (!file_exists($helper)) {
            return;
        } else {
            require_once $helper;
        }

        // import component helper
        jimport('joomla.application.component.helper');
        jimport('joomla.filesystem.file');

        // Get Thumb
        $params = JComponentHelper::getParams('com_splms');
        $thumb_size = strtolower($params->get('event_thumbnail', '480X300'));
        $thumb_size_small = strtolower($params->get('event_thumbnail_small', '100X60'));

        //Load Helix3
        $helix3_path = JPATH_PLUGINS . '/system/helix3/core/helix3.php';

        $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    $query->select('*')
	    ->from($db->quoteName('#__splms_events'))
	    ->where($db->quoteName('published') . ' = 1')
	    ->order($db->quoteName('ordering') . ' ASC')
	    ->setLimit($limit);
	    $db->setQuery($query);
	    $items = $db->loadObjectList();


        if (count($items)) {
            if ($layout == 'honeycomb') {
                ob_start();
                $output .= '<div class="sppb-addon addon-splms-events-honeycomb">';
                $output .= '<div class="splms-events-list clearfix">';
                $index = 0;
                foreach ($items as $key => $item) {
                    $div_style = ($index % 2) ? 'splms-even' : 'splms-odd';
                    if ($key % 2 != 0) {
                        $index++;
                    }
                    $output .= '<div class="splms-event ' . $div_style . '">';
                    $output .= '<div class="splms-event-img">';
                    $filename = basename($item->image);
                    $path = JPATH_BASE . '/' . dirname($item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size . '.' . JFile::getExt($filename);
                    $src = JURI::base(true) . '/' . dirname($item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size . '.' . JFile::getExt($filename);

                    if (JFile::exists($path)) {
                        $thumb = $src;
                    } else {
                        $thumb = $item->image;
                    }
                    $item->url = JRoute::_('index.php?option=com_splms&view=event&id=' . $item->id . ':' . $item->alias . SplmsHelper::getItemid('events'));
                    $output .= '<a href="' . $item->url . '">';
                    $output .= '<img src="' . $thumb . '" class="img-responsive" alt="' . $item->title . '">';
                    $output .= '</a>';
                    $output .= '</div>';
                    $output .= '<div class="splms-event-content">  ';
                    $output .= '<small>' . JHtml::date($item->event_start_date, 'DATE_FORMAT_LC') . '</small>';
                    $output .= '<h4>';
                    $output .= '<a href="' . $item->url . '">' . $item->title;
                    $output .= '</a>';
                    $output .= '</h4>';
                    $output .= '<p>' . JHtml::_('string.truncate', strip_tags($item->description), 100) . '</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                }
                $output .= '</div>';
                $output .= '</div>';

                return $output;
            } else {
                ob_start();

                $output .= '<div class="sppb-addon addon-splms-events-carousel">';
                $output .= '<div class="sppb-row">';
                if ($title) {
                    $output .= '<div class="sppb-col-sm-4 col-md-3">';
                    $output .= '<div class="splms-upcoming-event-title-box">';
                    $output .= '<div class="sppb-row">';
                    $output .= '<div class="sppb-col-sm-9">';
                    $output .= '<span class="splms-upcoming-event-title">' . $title . '</span>';
                    $output .= '<span class="splms-upcoming-event-subtitle">' . $subtitle . '</span>';
                    $output .= '</div>';

                    $output .= '<div class="sppb-col-sm-3">';
                    $output .= '<div class="carousel-controll">';
                    $output .= '<div class="owl-controls">';
                    $output .= '<a class="owl-control eventPrev"><span><i class="left fa fa-angle-left"></i></span></a>';
                    $output .= '<a class="owl-control eventNext"><span><i class="right fa fa-angle-right"></i></span></a>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }

                $output .= '<div class="sppb-col-sm-8 col-md-9">';
                $output .= '<div class="splms-events-list">';
                $output .= '<div class="carousel-event owl-carousel">';
                foreach ($items as $key => $item) {
                    $output .= '<div class="splms-event">';
                    $output .= '<div class="media">';
                    $output .= '<div class="pull-left">';

                    $filename = basename($item->image);
                    $path = JPATH_BASE . '/' . dirname($item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size_small . '.' . JFile::getExt($filename);
                    $src = JURI::base(true) . '/' . dirname($item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size_small . '.' . JFile::getExt($filename);

                    if (JFile::exists($path)) {
                        $thumb = $src;
                    } else {
                        $thumb = $this->item->image;
                    }

                    $item->url = JRoute::_('index.php?option=com_splms&view=event&id=' . $item->id . ':' . $item->alias . SplmsHelper::getItemid('events'));
                    $output .= '<a href="' . $item->url . '">';
                    $output .= '<img src="' . $thumb . '" class="splms-event-img img-responsive" alt="' . $item->title . '">';
                    $output .= '</a>';
                    $output .= '</div>';
                    $output .= '<div class="media-body splms-event-short-info">';
                    $output .= '<p>' . JHtml::_('date', $item->event_start_date, 'DATE_FORMAT_LC3') . '</p>';
                    $output .= '<h4><a href="' . $item->url . '">' . $item->title . '</a></h4>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>    ';
                $output .= '</div>      ';
                $output .= '</div>';

                return $output;
            } //else
        } //if(count($items))
    }

    public function scripts() {
        JHtml::_('jquery.framework');
        $app = JFactory::getApplication();
        $template_jspath = JURI::base(true) . '/templates/' . $app->getTemplate() . '/js/';
        return array($template_jspath . 'owl.carousel.min.js', $template_jspath . 'addon.slider.js', $template_jspath . 'splms.js');
    }

    public function stylesheets() {
        $app = JFactory::getApplication();
        $template_csspath = JURI::base(true) . '/templates/' . $app->getTemplate() . '/css/';
        return array($template_csspath . 'owl.carousel.css', $template_csspath . 'owl.transitions.css');
    }

}
