<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('restricted aceess');

class SppagebuilderAddonQuick_admission extends SppagebuilderAddons {

    public function render() {

        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

        //Options
        $qa_image = (isset($this->addon->settings->qa_image) && $this->addon->settings->qa_image) ? $this->addon->settings->qa_image : '';
        $qa_image_padding = (isset($this->addon->settings->qa_image_padding) && $this->addon->settings->qa_image_padding) ? $this->addon->settings->qa_image_padding : '';
        $degree = (isset($this->addon->settings->degree) && $this->addon->settings->degree) ? $this->addon->settings->degree : '';
        $cource = (isset($this->addon->settings->cource) && $this->addon->settings->cource) ? $this->addon->settings->cource : '';
        $duration = (isset($this->addon->settings->duration) && $this->addon->settings->duration) ? $this->addon->settings->duration : '';
        $qa_description = (isset($this->addon->settings->qa_description) && $this->addon->settings->qa_description) ? $this->addon->settings->qa_description : '';
        $link_url = (isset($this->addon->settings->link_url) && $this->addon->settings->link_url) ? $this->addon->settings->link_url : '';
        $button_text = (isset($this->addon->settings->button_text) && $this->addon->settings->button_text) ? $this->addon->settings->button_text : '';

        $output = '';
        $qa_image_padding = ($qa_image_padding) ? 'style="padding: ' . $qa_image_padding . '"' : '';

        $qa_image = is_object($qa_image) ? $qa_image->src : $qa_image;

        $output = '<div class="sppb-qa-admission-wrapper ' . $class . '">';
        $output .= '<' . $heading_selector . ' class="sppb-addon-title">' . $title . '</' . $heading_selector . '>';
        $output .= '<div class="sppb-qa-media">';
        $output .= '<div class="pull-left">';
        $output .= '<img class="img-responsive" ' . $qa_image_padding . ' src="' . $qa_image . '" alt="' . $title . '">';
        $output .= '</div>';
        $output .= '<div class="sppb-qa-media-body">';
        $output .= '<span class="sppb-qa-admission-degree">' . $degree . '</span>';
        $output .= '<span class="sppb-qa-admission-course">Course : ' . $cource . '</span>';
        $output .= '<span class="sppb-qa-admission-duration">Course Duration : ' . $duration . '</span>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<p class="sppb-qa-admission-text">' . $qa_description . '</p>';
        if (!empty($button_text)) {
            $output .= '<a class="btn-style" href="' . $link_url . '">' . $button_text . '</a>';
        }
        $output .= '</div>';

        return $output;
    }

    public static function getTemplate() {
        $output = '
            <#
                let contentClass = (!_.isEmpty(data.class) && data.class) ? data.class : "";
                let title = (!_.isEmpty(data.title) && data.title) ? data.title : "";
                let heading_selector = (!_.isEmpty(data.heading_selector) && data.heading_selector) ? data.heading_selector : "h3";
                // let qa_image = (!_.isEmpty(data.qa_image) && data.qa_image) ? data.qa_image : "";
                let qa_image_padding = (!_.isEmpty(data.qa_image_padding) && data.qa_image_padding) ? data.qa_image_padding : "";
                let degree = (!_.isEmpty(data.degree) && data.degree) ? data.degree : "";
                let cource = (!_.isEmpty(data.cource) && data.cource) ? data.cource : "";
                let duration = (!_.isEmpty(data.duration) && data.duration) ? data.duration : "";
                let qa_description = (!_.isEmpty(data.qa_description) && data.qa_description) ? data.qa_description : "";
                let link_url = (!_.isEmpty(data.link_url) && data.link_url) ? data.link_url : "";
                let button_text = (!_.isEmpty(data.button_text) && data.button_text) ? data.button_text : "";
                qa_image_padding = (qa_image_padding) ? \'style="padding: \' + qa_image_padding + \'"\' : "";

                var qa_image = "";
                if((typeof data.qa_image !== "undefined") && (typeof data.qa_image.src !== "undefined")){
                    qa_image = "src=" + data.qa_image.src;
                } else {
                    qa_image =  "src=" + data.qa_image
                }

            #>

                <div class="sppb-qa-admission-wrapper {{contentClass}}">
                <# if(heading_selector){ #>
                    <{{heading_selector}} class="sppb-addon-title">{{{title}}}</{{heading_selector}}>
                <# } #>

                <div class="sppb-qa-media">
                <div class="pull-left">
                <img class="img-responsive" {{{qa_image_padding}}} {{qa_image}} alt="{{{title}}}">
                </div>
                <div class="sppb-qa-media-body">
                <span class="sppb-qa-admission-degree">{{{degree}}}</span>
                <span class="sppb-qa-admission-course">Course : {{cource}}</span>
                <span class="sppb-qa-admission-duration">Course Duration : {{duration}}</span>
                </div>
                </div>
                <p class="sppb-qa-admission-text">{{qa_description}}</p>
                <# if (!_.isEmpty(button_text)) { #>
                    <a class="btn-style" href="{{link_url}}">{{button_text}}</a>
                <# } #>
                </div>
                ';
        return $output;
    }

}
