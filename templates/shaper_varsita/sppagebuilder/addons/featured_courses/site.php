<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('restricted aceess');

class SppagebuilderAddonFeatured_courses extends SppagebuilderAddons {

    public function render() {
        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

        $output = '';

        $helper = JPATH_BASE . '/components/com_splms/helpers/helper.php';
        // echo '<pre>';
        // var_dump(JPATH_BASE);
        // echo '</pre>';

        if (!file_exists($helper)) {
            return;
        } else {
            require_once $helper;
        }

        $db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from($db->quoteName('#__splms_courses'))
			->where($db->quoteName('published') . ' = 1')
			->where($db->quoteName('featured_course') . ' = 1')
			->order($db->quoteName('ordering') . ' ASC')
			->setLimit(4);
		$db->setQuery($query);
		$items = $db->loadObjectList();

        $output = '';

        if (count($items)) {

            $output .= '<div class="sppb-addon sppb-addon-featured-courses ' . $class . '">';
            $output .= '<div class="sppb-addon-content">';
            if ($title) {
                $output .= '<' . $heading_selector . ' class="sppb-addon-title" >' . $title . '</' . $heading_selector . '>';
            }
            $output .= '<div class="sppb-row">';

            foreach ($items as $item) {
                $url = JRoute::_('index.php?option=com_splms&view=course&id=' . $item->id . ':' . $item->alias . SplmsHelper::getItemid('courses'));

                $output .= '<div class="sppb-col-sm-3 featured-course">';
                $output .= '<div class="featured-course-inner">';
                $output .= '<h3 class="splms-courses-title">';
                $output .= '<a href="' . $url . '" title="' . $item->title . '">' . $item->title . '</a>';
                $output .= '</h3>';
                $output .= '<p>' . $item->short_description . '</p>';

                $output .= '<a href="' . $url . '" title="' . $item->title . '">';
                $output .= JText::_('SPLMS_VIEW_COURSES');
                $output .= '<i class="fa fa-long-arrow-right"></i>';
                $output .= '</a>';

                $output .= '</div>';
                $output .= '</div>';
            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

        return $output;
    }

}
