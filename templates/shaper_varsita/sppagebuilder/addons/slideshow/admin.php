<?php

/**
 * @package Varsita
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('resticted aceess');

SpAddonsConfig::addonConfig(
        array(
            'type' => 'repeatable',
            'addon_name' => 'sp_slideshow',
            'category' => 'varsita',
            'title' => JText::_('COM_SPPAGEBUILDER_ADDON_SLIDESHOW'),
            'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_SLIDESHOW_DESC'),
            'inline'     => [
                'contenteditable' => true,
                'buttons'         => [
                ],
            ],
            'attr' => array(
                'general' => array(
                    'admin_label' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
                        'std' => ''
                    ),
                    'autoplay' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_AUTOPLAY'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_AUTOPLAY_DESC'),
                        'values' => array(
                            1 => JText::_('JYES'),
                            0 => JText::_('JNO'),
                        ),
                        'std' => 1,
                    ),
                    'controllers' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_CONTROLLERS'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_CONTROLLERS_DESC'),
                        'values' => array(
                            1 => JText::_('JYES'),
                            0 => JText::_('JNO'),
                        ),
                        'std' => 1,
                    ),
                    'arrows' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_ARROWS'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_SHOW_ARROWS_DESC'),
                        'values' => array(
                            1 => JText::_('JYES'),
                            0 => JText::_('JNO'),
                        ),
                        'std' => 1,
                    ),
                    'background' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_BACKGROUND_COLOR'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_BACKGROUND_COLOR_DESC'),
                    ),
                    'color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_FONT_COLOR'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_FONT_COLOR_DESC'),
                    ),
                    'height' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_HEIGHT'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_HEIGHT_DESC'),
                        'std' => '500'
                    ),
                    'class' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
                        'std' => ''
                    ),
                    //repeatable
                    'sp_slideshow_item' => array(
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEMS'),
                        'attr' => array(
                            'title' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_DESC'),
                                'std' => 'Carousel Item Title',
                            ),
                            'sub_title' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_SUB_TITLE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_SUB_TITLE_DESC'),
                                'std' => 'Carousel Item Sub Title',
                            ),
                            'content' => array(
                                'type' => 'editor',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_DESC'),
                                'std' => 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.'
                            ),
                            'bg' => array(
                                'type' => 'media',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_BACKGROUND_IMAGE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_BACKGROUND_IMAGE_DESC'),
                            ),
                            'image' => array(
                                'type' => 'media',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_IMAGE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_IMAGE_DESC'),
                            ),
                            'video' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_VIDEO'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_VIDEO_DESC'),
                            ),
                            'button_text' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT_DESC'),
                            ),
                            'button_url' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_URL'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_URL_DESC'),
                            ),
                            'button_size' => array(
                                'type' => 'select',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DESC'),
                                'values' => array(
                                    '' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DEFAULT'),
                                    'lg' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_LARGE'),
                                    'sm' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_SMALL'),
                                    'xs' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_EXTRA_SAMLL'),
                                ),
                            ),
                            'button_type' => array(
                                'type' => 'select',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE_DESC'),
                                'values' => array(
                                    'default' => JText::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
                                    'primary' => JText::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
                                    'success' => JText::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
                                    'info' => JText::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
                                    'warning' => JText::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
                                    'danger' => JText::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
                                    'link' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
                                ),
                                'std' => 'default',
                            ),
                            'button_before_icon' => array(
                                'type' => 'icon',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_BEFORE_TITLE_BUTTON_ICON'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_BEFORE_BUTTON_DESC'),
                            ),
                            'button_after_icon' => array(
                                'type' => 'icon',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_AFTER_TITLE_BUTTON_ICON'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_BEFORE_BUTTON_DESC'),
                            ),
                        )
                    ),
                )
            )
        )
);

