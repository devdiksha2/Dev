<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('restricted aceess');

class SppagebuilderAddonCustom_text extends SppagebuilderAddons {

    public function render() {

        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : '';

        //Options
        $title_font_size = (isset($this->addon->settings->title_font_size) && $this->addon->settings->title_font_size) ? $this->addon->settings->title_font_size : '';
        $custom_layout = (isset($this->addon->settings->custom_layout) && $this->addon->settings->custom_layout) ? $this->addon->settings->custom_layout : '';
        $custom_image = (isset($this->addon->settings->custom_image) && $this->addon->settings->custom_image) ? $this->addon->settings->custom_image : '';
        $custom_image_padding = (isset($this->addon->settings->custom_image_padding) && $this->addon->settings->custom_image_padding) ? $this->addon->settings->custom_image_padding : '';
        $custom_text = (isset($this->addon->settings->custom_text) && $this->addon->settings->custom_text) ? $this->addon->settings->custom_text : '';
        $link_url = (isset($this->addon->settings->link_url) && $this->addon->settings->link_url) ? $this->addon->settings->link_url : '';
        $button_text = (isset($this->addon->settings->button_text) && $this->addon->settings->button_text) ? $this->addon->settings->button_text : '';
        $title_padding_bottom = (isset($this->addon->settings->title_padding_bottom) && $this->addon->settings->title_padding_bottom) ? $this->addon->settings->title_padding_bottom : '';

        $output = '';
        $custom_image_padding = ($custom_image_padding) ? 'style="padding: ' . $custom_image_padding . '"' : '';
        $output .= '<' . $heading_selector . ' class="sppb-addon-title" >' . $title . '</' . $heading_selector . '>';

        $custom_image = is_object($custom_image) ? $custom_image->src : $custom_image;

        if ($custom_layout == 'ctlw') {
            $output = '<div class="sppb-custom-text-wrapper' . $class . '">';
            $output .= '<div class="sppb-row">';
            $output .= '<div class="sppb-col-sm-5"><img src="' . $custom_image . '" ' . $custom_image_padding . ' alt="" /></div>';
            $output .= '<div class="sppb-col-sm-7">';
            if ($title) {
                $title_style = '';
                if ($title_padding_bottom)
                    $title_style .= 'padding-bottom:' . (int) $title_padding_bottom . 'px;';
                if ($title_font_size)
                    $title_style .= 'font-size:' . $title_font_size . 'px;line-height:' . $title_font_size . 'px;';

                $output .= '<h3 class="custom-text-title" style="' . $title_style . '">' . $title . '</h3>';
            }

            //$output .= '<h3 class="custom-text-title"'.$title_font_size.'>'.$title.'</h3>';
            $output .= '<p>' . $custom_text . '</p>';
            if (!empty($link_url)) {
                $output .= '<a href="' . $link_url . '">' . $button_text . ' <i class="fa fa-chevron-right"></i> </a>';
            }
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        } else {

            $output = '<div class="sppb-custom-text-wrapper' . $class . '">';
            if ($title) {
                $title_style = '';
                if ($title_padding_bottom)
                    $title_style .= 'padding-bottom:' . (int) $title_padding_bottom . 'px;';
                if ($title_font_size)
                    $title_style .= 'font-size:' . $title_font_size . 'px;line-height:' . $title_font_size . 'px;';

                $output .= '<h3 class="custom-text-title" style="' . $title_style . '">' . $title . '</h3>';
            }
            $output .= '<img ' . $custom_image_padding . ' src="' . $custom_image . '" alt="' . $title . '" />';
            $output .= '<p>' . $custom_text . '</p>';
            if (!empty($link_url)) {
                $output .= '<a href="' . $link_url . '">' . $button_text . ' <i class="fa fa-chevron-right"></i></a>';
            }
            $output .= '</div>';
        }


        return $output;
    }

    public static function getTemplate() {
        $output = '
            <#
                let contentClass = (!_.isEmpty(data.class) && data.class) ? data.class : "";
                let title = (!_.isEmpty(data.title) && data.title) ? data.title : "";
                let heading_selector = (!_.isEmpty(data.heading_selector) && data.heading_selector) ? data.heading_selector : "";

                let title_font_size = (!_.isEmpty(data.title_font_size) && data.title_font_size) ? data.title_font_size : "";
                let custom_layout = (!_.isEmpty(data.custom_layout) && data.custom_layout) ? data.custom_layout : "";
                let custom_image = (!_.isEmpty(data.custom_image) && data.custom_image) ? data.custom_image : "";
                let custom_image_padding = (!_.isEmpty(data.custom_image_padding) && data.custom_image_padding) ? data.custom_image_padding : "";
                let custom_text = (!_.isEmpty(data.custom_text) && data.custom_text) ? data.custom_text : "";
                let link_url = (!_.isEmpty(data.link_url) && data.link_url) ? data.link_url : "";
                let button_text = (!_.isEmpty(data.button_text) && data.button_text) ? data.button_text : "";
                let title_padding_bottom = (!_.isEmpty(data.title_padding_bottom) && data.title_padding_bottom) ? data.title_padding_bottom : "";

                custom_image_padding = (custom_image_padding) ? \'style="padding: \' + custom_image_padding + \'"\' : "";

                custom_image = _.isObject(custom_image) ? custom_image.src : custom_image;

            #>
                <# if (custom_layout == "ctlw") { #>
                    <div class="sppb-custom-text-wrapper {{contentClass}}">
                    <div class="sppb-row">
                    <div class="sppb-col-sm-5"><img src="{{custom_image}}" {{{custom_image_padding}}} alt="" /></div>
                    <div class="sppb-col-sm-7">
                    <# if (title) {
                        let title_style = "";
                        if (title_padding_bottom){
                            title_style += \'padding-bottom:\' + title_padding_bottom + \'px;\';
                        }
                        if (title_font_size){
                            title_style += \'font-size:\' + title_font_size + \'px;line-height:\' + title_font_size + \'px;\';
                        }
                        if(heading_selector !==""){
                        #>
                            <{{heading_selector}} class="custom-text-title" style="{{title_style}}">{{{title}}}</{{heading_selector}}>
                        <# }
                    } #>
                    <p>{{{custom_text}}}</p>
                    <# if (!_.isEmpty(link_url)) { #>
                        <a href="{{link_url}}">{{button_text}} <i class="fa fa-chevron-right"></i> </a>
                    <# } #>
                    </div>
                    </div>
                    </div>
                <# } else { #>
                    <div class="sppb-custom-text-wrapper {{contentClass}}">
                    <# if (title) {
                        let title_style = "";
                        if (title_padding_bottom){
                            title_style += \'padding-bottom:\' + title_padding_bottom + \'px;\';
                        }
                        if (title_font_size){
                            title_style += \'font-size:\' + title_font_size + \'px;line-height:\' + title_font_size + \'px;\';
                        }
                        if(heading_selector !==""){
                        #>
                            <{{heading_selector}} class="custom-text-title" style="{{title_style}}">{{{title}}}</{{heading_selector}}>
                        <# }

                    } #>
                    <img {{{custom_image_padding}}} src="{{custom_image}}" alt="{{{title}}}" />
                    <p>{{{custom_text}}}</p>
                    <# if (!_.isEmpty(link_url)) { #>
                        <a href="{{link_url}}">{{button_text}} <i class="fa fa-chevron-right"></i></a>
                    <# } #>
                    </div>
                <# } #>
            ';
        return $output;
    }

}
