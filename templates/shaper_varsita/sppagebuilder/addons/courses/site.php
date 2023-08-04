<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonCourses extends SppagebuilderAddons {

	public function render() {
		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		//Options
		$subtitle = (isset($this->addon->settings->subtitle) && $this->addon->settings->subtitle) ? $this->addon->settings->subtitle : '';
		$columns = (isset($this->addon->settings->columns) && $this->addon->settings->columns) ? $this->addon->settings->columns : '';
		$layout = (isset($this->addon->settings->layout) && $this->addon->settings->layout) ? $this->addon->settings->layout : '';
		$course_type = (isset($this->addon->settings->course_type) && $this->addon->settings->course_type) ? $this->addon->settings->course_type : '';	
		$show_all = (isset($this->addon->settings->show_all) && $this->addon->settings->show_all) ? $this->addon->settings->show_all : '';	
		$limit = (isset($this->addon->settings->limit) && $this->addon->settings->limit) ? $this->addon->settings->limit : '';	
		$lessons = (isset($this->addon->settings->lessons) && $this->addon->settings->lessons) ? $this->addon->settings->lessons : '';	


		$output  = '';
		$course_model = JPATH_BASE . '/components/com_splms/models/courses.php';
		$lesson_model = JPATH_BASE . '/components/com_splms/models/lessons.php';
		$helper = JPATH_BASE . '/components/com_splms/helpers/helper.php';

		if(!file_exists($course_model) || !file_exists($lesson_model) || !file_exists($helper)) {
			return;
		} else {
			require_once $course_model;
			require_once $lesson_model;
			require_once $helper;
		}

		// Get Thumb
		$params = JComponentHelper::getParams('com_splms');
		$thumb_size = strtolower($params->get('course_thumbnail', '480X300'));
		$thumb_size_small = strtolower($params->get('course_thumbnail_small', '100X60'));

		//Get Currency
		$currency = explode(':', $params->get('currency', 'USD:$'));
		$currency =  $currency[1];

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select(array('id', 'title', 'alias', 'short_description', 'price', 'image'));
		$query->from($db->quoteName('#__splms_courses'));
		$query->where($db->quoteName('published') . ' = 1');

		if ($course_type == 'featured') {
			$query->where($db->quoteName('featured_course') . ' = 1');
		}elseif ($course_type == 'paid') {
			$query->where($db->quoteName('price') . ' > 1');
		}elseif ($course_type == 'free') {
			$query->where($db->quoteName('price') . ' = 0');
		} else {
			$query->order($db->quoteName('ordering') . ' ASC');
		}

		$query->setLimit($limit);
		$db->setQuery($query);
		$items = $db->loadObjectList();

		if ($course_type == 'popular') {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( array('a.id', 'a.title', 'a.alias', 'a.price', 'a.image', 'count(b.course_id) AS count_course'  ));
			$query->from($db->quoteName('#__splms_courses', 'a'));
			$query->join('LEFT', $db->quoteName('#__splms_orders', 'b') . ' ON (' . $db->quoteName('a.course_id') . ' = ' . $db->quoteName('b.course_id') . ')');
			$query->where($db->quoteName('b.published') . ' = 1');
			$query->group($db->quoteName('b.course_id'));
			$query->order($db->quoteName('count_course') . ' DESC');
			$query->setLimit($limit);
			$db->setQuery($query);
			$items = $db->loadObjectList();
		}

		foreach ($items as &$item) {
			$item->url = JRoute::_('index.php?option=com_splms&view=course&id='.$item->id.':'.$item->alias . SplmsHelper::getItemid('courses'));
		}

		if(count($items)) {
			if($layout=='default') {
				$i=1;
				$j=1;
				ob_start();

				$output .= '<div class="sppb-addon sp-overlay addon-splms-courses' . $class . '">';

				if($title) {
					$output .= '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>';
				}  
				if($subtitle) {
					$output .= '<h4 class="sppb-addon-subtitle">' . $subtitle . '</h4>';
				}  

				foreach ($items as $key=>$default_course) { 
					// Get course teacher
					$teachers = SplmsModelCourses::getCourseTeachers( $default_course->id );
					$lessons  = SplmsModelLessons::getLessons( $default_course->id );

					// Get Prices
					if ($default_course->price == 0) {
						$price = JText::_('SPLMS_COURSE_FREE');
					}else{
						$price = SplmsHelper::generateCurrency($default_course->price);
					}

					$total_attachments = array();
					foreach ($lessons as $lesson){
						if ($lesson->attachment) {
							$total_attachments[] = $lesson->attachment;
						}
					}

					// Count Column
					if( (($key+1)%($columns)==0) || $j==count($items)) {
						$lastContainer= true;
					} else {
						$lastContainer= false;
					}
					

					if($i==1) { 
						$output .= '<div class="row">';
					} 

					$output .= '<div class="col-sm-' . round(12/$columns) .  ' col-xs-12 splms-course-category">';

					$output .= '<div class="splms-course splms-match-height">';
					$output .= '<div class="splms-common-overlay-wrapper">';
					$filename = basename($default_course->image);
					$path = JPATH_BASE .'/'. dirname($default_course->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size . '.' . JFile::getExt($filename);
					$src = JURI::base(true) . '/' . dirname($default_course->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size . '.' . JFile::getExt($filename);

					if(JFile::exists($path)) {
						$thumb = $src;
					} else {
						$thumb = $default_course->image;	
					}

					$output .= '<img src="' . $thumb . '" class="splms-course-img splms-img-responsive" alt="' . $item->title . '">';

					if ($default_course->price == 0) {
						$output .= '<span class="splms-badge-free">' . JText::_('SPLMS_COURSE_FREE') . '</span>';
					}

					$output .= '<div class="splms-common-overlay">';
					$output .= '<div class="splms-vertical-middle">';
					$output .= '<div>';
					$output .= '<a href="' . $default_course->url . '" class="splms-readmore btn btn-default">' . JText::_('SPLMS_COURSE_DETALTS');
					$output .= '</a>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="splms-course-info">';
					$output .= '<h3 class="splms-courses-title">';
					$output .= '<a href="' . $default_course->url . '">' . $default_course->title;
					$output .= '</a>';
					$output .= '</h3>';
					// END:: Has teacher

					if (!empty($teachers)) { 
						$output .= '<div class="splms-course-teachers">';
						$output .= '<span>' . JText::_('SPLMS_COURSE_BY') . '</span>';
							foreach ($teachers as $key => $teacher) {
								// Get Last Item
								$last_item = end($teachers);
								if ($teacher == $last_item) {
									$divider = '';
								} else{
									$divider = ' , ';
								}

								$output .= ' <a href="' . $teacher->url . '" class="splms-teacher-name">';
								$output .= '<strong>' . $teacher->title . $divider . '</strong>'; 
								$output .= '</a>';
							} // END:: foreach 
						$output .= '</div>';
						}// END:: has teahcer 

						$output .= '<p class="splms-course-short-info">' . $default_course->short_description . '</p>';
						$output .= '<div class="splms-course-meta">' . $price . ' . ' . count($lessons) .  JText::_('SPLMS_COURSE_SESSONS') . ' . ' . count($total_attachments) . JText::_('SPLMS_COURSE_ATTACHMENTS'); 
						$output .= '</div>';
						$output .= '</div>';
						$output .= '</div>';

					$output .= '</div>';
					//END ::.splms-course

					if(($i == $columns) || $lastContainer) { 
					$output .= '</div> <!-- /.row --> ';
					$i=0; } $i++; $j++; }

					//Show All button
					if ($show_all== 1) {
						$output .= '<div class="browse-all-courses text-center">';
						$output .= '<a href="'. JRoute::_('index.php?option=com_splms&amp;view=courses' . SplmsHelper::getItemid('courses')) . '" class="btn btn-primary btn-lg">' . JText::_('COURSES_SHOW_ALL_COURSES');
						$output .= '</a>';
						$output .= '</div>';
					}
				$output .= '</div>';

				return $output;

			} else {
				ob_start();

				$output .= '<div class="carousel-controller splms-course-carousel">';
				$output .= '<div class="row">';
				$output .= '<div class="col-xs-6">';
				$output .= '<h3 class="course-carousel-title">' . $title . '</h3>';
				$output .= '</div>';

				$output .= '<div class="col-xs-6">';
				$output .= '<div class="customNavigation">';
				$output .= '<a class="courseCarouselPrev"><i class="fa fa-angle-left"></i></a>';
				$output .= '<a class="courseCarouselNext"><i class="fa fa-angle-right"></i></a>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="sppb-addon sp-overlay addon-splms-courses' . $class . '">';
					$output .= '<div id="carousel-courses-layout" class="owl-carousel">';
						foreach ($items as $key=>$carousel_courses) { 
							// Get course teacher
							$teachers = SplmsModelCourses::getCourseTeachers( $carousel_courses->id );
							$lessons  = SplmsModelLessons::getLessons( $carousel_courses->id );

							// Get Prices
							if ($carousel_courses->price == 0) {
								$price = JText::_('SPLMS_COURSE_FREE');
							}else{
								$price = SplmsHelper::generateCurrency($carousel_courses->price);
							}

							$total_attachments = array();
							foreach ($lessons as $lesson){
								if ($lesson->attachment) {
									$total_attachments[] = $lesson->attachment;
								}
							}

							$output .= '<div class="item splms-course-category">';
							$output .= '<div class="splms-course splms-match-height">';
							$output .= '<div class="splms-common-overlay-wrapper">';

							$filename = basename($carousel_courses->image);
							$path = JPATH_BASE .'/'. dirname($carousel_courses->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size . '.' . JFile::getExt($filename);
							$src = JURI::base(true) . '/' . dirname($carousel_courses->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $thumb_size . '.' . JFile::getExt($filename);
							
							if(JFile::exists($path)) {
								$thumb = $src;
							} else {
								$thumb = $carousel_courses->image;	
							}
							$output .= '<img src="' . $thumb . '" class="splms-course-img splms-img-responsive" alt="' . $carousel_courses->title . '">';

							if ($carousel_courses->price == 0) {
								$output .= '<span class="splms-badge-free">' . JText::_('SPLMS_COURSE_FREE') . '</span>';
							}

							$output .= '<div class="splms-common-overlay">';
							$output .= '<div class="splms-vertical-middle">';
							$output .= '<div>';
							$output .= '<a href="' . $carousel_courses->url . '" class="splms-readmore btn btn-default">' . JText::_('SPLMS_COURSE_DETALTS');
							$output .= '</a>';
							$output .= '</div>';
							$output .= '</div>';
							$output .= '</div>';
							$output .= '</div>';
							$output .= '<div class="splms-course-info">';
							$output .= '<h3 class="splms-courses-title">';
							$output .= '<a href="' . $carousel_courses->url . '">' . $carousel_courses->title; 
							$output .= '</a>';
							$output .= '</h3>';
									//END::  Has teacher

							if (!empty($teachers)) { 
								$output .= '<div class="splms-course-teachers">';
								$output .= '<span>' . JText::_('SPLMS_COURSE_BY') . '</span>';
								foreach ($teachers as $key => $teacher) {
												// Get Last Item
									$last_item = end($teachers);
									if ($teacher == $last_item) {
										$divider = '';
									} else{
										$divider = ' , ';
									}

									$output .= ' <a href="' . $teacher->url . '" class="splms-teacher-name">';
									$output .= '<strong>' . $teacher->title . $divider . '</strong>'; 
									$output .= '</a>';
											} // END:: foreach 
									$output .= '</div>';
									}// END:: has teahcer  

									$output .= '<p class="splms-course-short-info">' . $carousel_courses->short_description . '</p>';
									$output .= '<div class="splms-course-meta">' . $price . ' . ' . count($lessons) .  JText::_('SPLMS_COURSE_SESSONS') . ' . ' . count($total_attachments) . JText::_('SPLMS_COURSE_ATTACHMENTS'); 
									$output .= '</div>';
									$output .= '</div>';
									$output .= '</div>';
						$output .= '</div>';
						//<!-- /.splms-course -->
						
					}
					$output .= '</div>';
					//<!-- /#carousel-courses-layout -->
				$output .= '</div>';
				return $output;
			}
			return $output;
		}

		return $output;
	}


	public function scripts() {
		JHtml::_('jquery.framework');
		$app = JFactory::getApplication();
		$component_jspath = JURI::base(true) . '/components/com_splms/assets/js/';
		$template_jspath = JURI::base(true) . '/templates/' . $app->getTemplate() . '/js/';
		return array($component_jspath . 'matchheight.js', $template_jspath . 'owl.carousel.min.js', $template_jspath . 'addon.slider.js', $template_jspath . 'addon-course-carousel.js');
	}

	public function stylesheets() {
		$app = JFactory::getApplication();
		$template_csspath = JURI::base(true) . '/templates/' . $app->getTemplate() . '/css/';
		return array($template_csspath . 'owl.carousel.css', $template_csspath . 'owl.transitions.css');
	}
}


