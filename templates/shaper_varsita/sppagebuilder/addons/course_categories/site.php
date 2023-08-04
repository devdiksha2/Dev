<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonCourse_categories extends SppagebuilderAddons {

	public function render() {

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		//Options
		$category_type = (isset($this->addon->settings->category_type) && $this->addon->settings->category_type) ? $this->addon->settings->category_type : '';
		$columns = (isset($this->addon->settings->columns) && $this->addon->settings->columns) ? $this->addon->settings->columns : '';
		$show_icon = (isset($this->addon->settings->show_icon) && $this->addon->settings->show_icon) ? $this->addon->settings->show_icon : '';
		$limit = (isset($this->addon->settings->limit) && $this->addon->settings->limit) ? $this->addon->settings->limit : '';	

		$helper = JPATH_BASE . '/components/com_splms/helpers/helper.php';
        if (!file_exists($helper)) {
            return;
        } else {
            require_once $helper;
        }

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__splms_coursescategories'));
		$query->where($db->quoteName('published') . ' = 1');
		if ($category_type== 'featured') {
			$query->where($db->quoteName('featured') . ' = 1');
		}
		$query->order($db->quoteName('ordering') . ' ASC');
		if($limit) {
			$query->setLimit($limit);
		}
		$db->setQuery($query);
		$items = $db->loadObjectList();

		//Retrive number of courses
		foreach ($items as $key => $item) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('COUNT(id)');
			$query->from($db->quoteName('#__splms_courses'));
			$query->where($db->quoteName('published')." = 1");
			$query->where($db->quoteName('coursecategory_id')." = ".$db->quote($item->id));
			$db->setQuery($query);
			$item->courses = $db->loadResult();

			$item->url = JRoute::_('index.php?option=com_splms&view=coursescategory&id='.$item->id.':'.$item->alias . SplmsHelper::getItemid('coursescategories'));
		}

		$output = ($title) ? '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>' : '';

		
		if(count($items)) {

			$i=1;
			$j=1;

			$output  = '<div class="sppb-addon addon-splms-course-categories'. $class .'">';
				
				foreach ($items as $key=>$courseItem) {
					if( (($key+1)%($columns)==0) || $j==count($items)) {
						$lastContainer= true;
					} else {
						$lastContainer= false;
					}

					if($i==1) {
						$output  .= '<div class="row">';
					} 

						$output  .= '<div class="col-sm-'.round(12/$columns) .' col-xs-6 splms-course-category">';
							$output  .= '<div class="splms-course-category-wrapper text-center">';
								$output  .= '<div class="splms-course-category-icon">';
									$output  .= '<a href="'. $courseItem->url .'">';
										if (($show_icon) && ($courseItem->icon || $courseItem->image) ) {
											if($courseItem->show == 1 && $courseItem->image){
												$output  .= '<img src="' . $courseItem->image .'" alt="'. $courseItem->title .'">';
											} else {
												$output  .= '<i class="fa fa-'.$courseItem->icon.'"></i>';
											} 
										} 
									$output  .='</a>';
								$output  .='</div>';
								$output  .='<a class="splms-course-category-title" href="'. $courseItem->url .'">' .$courseItem->title;
									$output  .='<span class="splms-course-category-courses">('. $courseItem->courses .')</span>';
								$output  .='</a>';
							$output  .='</div>';
						$output  .='</div><!-- /.splms-course-category -->';

						if(($i == $columns) || $lastContainer) {
					$output  .='</div>';
					$i=0; } $i++; $j++; 
				}

			$output  .='</div>';

			return $output;
		}

		return false;
	}
}
