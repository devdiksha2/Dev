<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('restricted aceess');

class SppagebuilderAddonSlideshow extends SppagebuilderAddons {

    public function render() {

        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';

        //Options
        $autoplay = (isset($this->addon->settings->autoplay) && $this->addon->settings->autoplay) ? $this->addon->settings->autoplay : '0';
        $controllers = (isset($this->addon->settings->controllers) && $this->addon->settings->controllers) ? $this->addon->settings->controllers : '0';
        $arrows = (isset($this->addon->settings->arrows) && $this->addon->settings->arrows) ? $this->addon->settings->arrows : '0';
        $background = (isset($this->addon->settings->background) && $this->addon->settings->background) ? $this->addon->settings->background : '';
        $color = (isset($this->addon->settings->color) && $this->addon->settings->color) ? $this->addon->settings->color : '';
        $button_before_icon = (isset($this->addon->settings->button_before_icon) && $this->addon->settings->button_before_icon) ? $this->addon->settings->button_before_icon : '';
        $button_after_icon = (isset($this->addon->settings->button_after_icon) && $this->addon->settings->button_after_icon) ? $this->addon->settings->button_after_icon : '';
        
        $background = is_object($background) ? $background->src : $background;

        $output = '';
        $helix3_path = JPATH_PLUGINS . '/system/helix3/core/helix3.php';
        //Check Auto Play
        $slide_autoplay = ($autoplay) ? 'data-sppb-slide-ride="true"' : '';
        $slide_controllers = ($controllers) ? 'data-sppb-slide-controllers="true"' : '';

        // Generate css styles
        $SlideStyle = '';
        if ($background || $color) {
            $SlideStyle .= 'style="';
            if ($background) {
                $SlideStyle .= 'background: ' . $background . '; ';
            }

            if ($color) {
                $SlideStyle .= 'color: ' . $color . '; ';
            }
            $SlideStyle .= '"';
        }

        $output = '<div class="sppb-slider-wrapper owl-theme' . $class . '">';
        $output .= '<div class="sppb-slider-item-wrapper" ' . $SlideStyle . '>';
        $output .= '<div class="sppb-slider-items owl-carousel " ' . $slide_autoplay . ' ' . $slide_controllers . '>';

        foreach ($this->addon->settings->sp_slideshow_item as $key => $value) {
            // if have bg then add class
            $bg = is_object($value->bg) ? $value->bg->src : $value->bg;
            $title = isset($value->title) ? $value->title : '';
            $sub_title = isset($value->sub_title) ? $value->sub_title : '';
            $content = isset($value->content) ? $value->content : '';
            $button_before_icon = isset($value->button_before_icon) ? $value->button_before_icon : '';
            $button_after_icon = isset($value->button_after_icon) ? $value->button_after_icon : '';
            $button_text =  isset($value->button_text) ? $value->button_text : '';
            $button_url = isset($value->button_url) ? $value->button_url : '';
            $button_type = isset($value->button_type) ? $value->button_type : '';


            $has_bg = ($bg) ? 'sppb-item-has-bg' : '';
            $bg_image = ($bg) ? 'style="background-image: url(' . JURI::base() . $bg . ');"' : '';
            $button_before_icon = ($button_before_icon) ? '<i class="fa ' . $button_before_icon . '"></i>' : '';
            $button_after_icon = ($button_after_icon) ? '<i class="fa ' . $button_after_icon . '"></i>' : '';


            $output .= '<div class="sppb-slideshow-item item ' . $has_bg . '">';

            $output .= '<div class="sppb-slideshow-item-bg" ' . $bg_image . '>';
            $output .= '<div class="sppb-slideshow-item-text">';

            if (($title) || ($content)) {
                if ($title) {
                    $output .= '<h1 class="sppb-slidehsow-title">' . $title . ' <small class="sppb-slidehsow-sub-title">' . $sub_title . '</small></h1>';
                }
                if ($content) {
                    $output .= '<p class="details">' . $content . '</p>';
                }
                if ($button_text && $button_url) {
                    if ($button_text && $button_url) {
                        $output .= '<a href="' . $button_url . '" class="">' . $button_before_icon . $button_text . $button_after_icon . '</a>';
                    }
                }
            }
            $output .= '</div>'; // END:: /.sppb-slideshow-item-content
            $output .= '</div>'; // END:: /.sppb-slideshow-item-bg
            $output .= '</div>'; // END:: /.sppb-slideshow-item
        }

        $output .= '</div>'; //END:: /.sppb-slider-items
        $output .= '</div>'; // END:: /.sppb-slider-item-wrapper
        // has next/previous arrows
        if ($arrows) {
            $output .= '<div class="customNavigation">';
            $output .= '<a class="sppbSlidePrev"><i class="fa fa-angle-left"></i></a>';
            $output .= '<a class="sppbSlideNext"><i class="fa fa-angle-right"></i></a>';
            $output .= '</div>'; // END:: /.customNavigation
        }

        // has dot controls
        if ($controllers) {
            $output .= '<div class="owl-dots">';
            $output .= '<div class="owl-dot active"><span></span></div>';
            $output .= '<div class="owl-dot"><span></span></div>';
            $output .= '<div class="owl-dot"><span></span></div>';
            $output .= '</div>';
        }

        $output .= '</div>'; // END:: /.sppb-slider-wrapper
        //Slideshow Overlay
        $output .= '<div class="slideshow-overlay"><div class="slideshow-overlay-container"><div class="placeholder"></div></div></div>';


        return $output;
    }

    public function scripts() {
        JHtml::_('jquery.framework');
        $app = JFactory::getApplication();
        $template_jspath = JURI::base(true) . '/templates/' . $app->getTemplate() . '/js/';
        return array($template_jspath . 'owl.carousel.min.js', $template_jspath . 'addon.slider.js');
    }

    public function js() {
        $addon_id = '#sppb-addon-' . $this->addon->id;
        return '
        
        jQuery(document).ready(function ($) {
                "use strict";
                //Slideshow
                var $sppbSlider = $("' . $addon_id . ' .sppb-slider-items");

            // Autoplay
            var $autoplay = $sppbSlider.attr("data-sppb-slide-ride");
            if ($autoplay == "true") {
                var $autoplay = true;
            } else {
                var $autoplay = false;
            }

            // controllers
            var $controllers = $sppbSlider.attr("data-sppb-slide-controllers");
            if ($controllers == "true") {
                var $controllers = true;
            } else {
                var $controllers = false;
            }

            //Slider Options
            $sppbSlider.owlCarousel({
                animateOut: "slideOutLeft",
                animateIn: "flipInX",
                loop: true,
                autoHeight: true,
                autoplay: $autoplay,
                center: true,
                nav: false,
                autoWidth: true,
                //responsiveClass:true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                },
                dots: $controllers,

            });

            $(".sppbSlidePrev").click(function () {
                $sppbSlider.trigger("prev.owl.carousel");
            });

            $(".sppbSlideNext").click(function () {
                $sppbSlider.trigger("next.owl.carousel");
            });
        });
        ';
    }

    public function stylesheets() {
        $app = JFactory::getApplication();
        $template_csspath = JURI::base(true) . '/templates/' . $app->getTemplate() . '/css/';
        return array($template_csspath . 'owl.carousel.css', $template_csspath . 'owl.transitions.css');
    }

    public static function getTemplate() {
        $output = '
            <#
                let contentClass = (!_.isEmpty(data.class) && data.class) ? data.class : "";
                let autoplay = (typeof data.autoplay !=="undefined") ? data.autoplay : 0;
                let controllers = (typeof data.controllers !=="undefined") ? data.controllers : 0;
                let arrows = (typeof data.arrows !=="undefined") ? data.arrows : 0;
                let background = (!_.isEmpty(data.background) && data.background) ? data.background : "";
                let COLOR = (!_.isEmpty(data.COLOR) && data.COLOR) ? data.COLOR : "";
                let button_before_icon = (!_.isEmpty(data.button_before_icon) && data.button_before_icon) ? data.button_before_icon : "";
                let button_after_icon = (!_.isEmpty(data.button_after_icon) && data.button_after_icon) ? data.button_after_icon : "";

                let slide_autoplay = (autoplay > 0) ? \'data-sppb-slide-ride="true"\' : "";
                let slide_controllers = (controllers > 0) ? \'data-sppb-slide-controllers="true"\' : "";

                let SlideStyle = "";
                if (background || COLOR) {
                    SlideStyle += \'style="\';
                    if (background) {
                        SlideStyle += \'background: \' + background + \'; \';
                    }

                    if (COLOR) {
                        SlideStyle += \'color: \' + COLOR + \'; \';
                    }
                    SlideStyle += \'"\';
                }
            #>

                <div class="sppb-slider-wrapper owl-theme {{contentClass}}">
                <div class="sppb-slider-item-wrapper" {{{SlideStyle}}}>
                <div class="sppb-slider-items owl-carousel " {{{slide_autoplay}}} {{{slide_controllers}}}>

                <# _.each (data.sp_slideshow_item, function(value, key) {
                    console.log(value.bg);
                    var bg = "";
                    if((typeof value.bg !== "undefined") && (typeof value.bg.src !== "undefined")){
                        bg = "background-image: url(" + value.bg.src + ")";
                    } else {
                        bg = "background-image: url(" + value.bg + ")";
                    }
                    let has_bg = (value.bg) ? "sppb-item-has-bg" : "";
                    let button_before_icon = (value.button_before_icon) ? \'<i class="fa \' + value.button_before_icon + \'"></i>\' : "";
                    let button_after_icon = (value.button_after_icon) ? \'<i class="fa \' + value.button_after_icon + \'"></i>\' : "";

                #>
                    <div class="sppb-slideshow-item item {{has_bg}}">

                    <div class="sppb-slideshow-item-bg" style="{{bg}};">
                    <div class="sppb-slideshow-item-text">

                    <# if ((value.title) || (value.content)) {
                        if (value.title) {
                    #>
                            <h1 class="sppb-slidehsow-title">{{{value.title}}} <small class="sppb-slidehsow-sub-title">{{{value.sub_title}}}</small></h1>
                        <# }
                        if (value.content) {
                        #>
                            <p class="details">{{value.content}}</p>
                        <# }
                        if (value.button_text && value.button_url) {
                            if (value.button_text && value.button_url) {
                        #>
                                <a href="{{value.button_url}}" class="">{{{button_before_icon}}} {{value.button_text}} {{{button_after_icon}}}</a>
                            <# }
                        }
                    }
                    #>
                    </div>
                    </div>
                    </div>
                <# }) #>

                </div>
                </div>

                <# if (arrows > 0) { #>
                    <div class="customNavigation">
                    <a class="sppbSlidePrev"><i class="fa fa-angle-left"></i></a>
                    <a class="sppbSlideNext"><i class="fa fa-angle-right"></i></a>
                    </div>
                <# }

                if (controllers) {
                #>
                    <div class="owl-dots">
                    <div class="owl-dot active"><span></span></div>
                    <div class="owl-dot"><span></span></div>
                    <div class="owl-dot"><span></span></div>
                    </div>
                <# } #>

                </div>
                <div class="slideshow-overlay"><div class="slideshow-overlay-container"><div class="placeholder"></div></div></div>
                ';
        return $output;
    }

}
