<?php

namespace PressElements\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Utils ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Scheme_Color ;
use  Elementor\Scheme_Typography ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Text_Shadow ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Image Accordion Effect
 *
 * Elementor widget for image accordion.
 *
 * @since 1.6.0
 */
class Press_Elements_Image_Accordion extends Widget_Base
{
    public function get_name()
    {
        return 'image-accordion';
    }
    
    public function get_title()
    {
        return __( 'Image Accordion', 'press-elements' );
    }
    
    public function get_icon()
    {
        return 'eicon-slider-push';
    }
    
    public function get_categories()
    {
        return [ 'press-elements-effects' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_pro_feature', [
            'label' => __( 'Image Accordion', 'press-elements' ),
        ] );
        $this->add_control( 'pro_feature', [
            'type'      => Controls_Manager::RAW_HTML,
            'raw'       => '<div class="elementor-panel-nerd-box">
							<i class="elementor-panel-nerd-box-icon fa fa-lock"></i>
							<div class="elementor-panel-nerd-box-title">' . __( 'Premium Feature', 'press-elements' ) . '</div>
							<div class="elementor-panel-nerd-box-message">' . sprintf(
            /* translators: %s: Press Elements Pro */
            __( 'This feature is only available on "%s".', 'press-elements' ),
            '<strong>' . __( 'Press Elements Pro', 'press-elements' ) . '</strong>'
        ) . '</div>
							<a class="elementor-panel-nerd-box-link elementor-button elementor-button-default elementor-go-pro" href="' . press_elements_freemius()->get_upgrade_url() . '" target="_blank">' . __( 'Upgrade Now!', 'press-elements' ) . '</a>
						</div>',
            'separator' => 'none',
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
    }
    
    protected function _content_template()
    {
    }

}