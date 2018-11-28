<?php

namespace PressElements\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Scheme_Color ;
use  Elementor\Scheme_Typography ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Text_Shadow ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Press Elements Post Custom Field
 *
 * Single post/page custom field element for elementor.
 *
 * @since 1.0.0
 */
class Press_Elements_Post_Custom_Field extends Widget_Base
{
    public function get_name()
    {
        return 'post-custom-field';
    }
    
    public function get_title()
    {
        $post_type_object = get_post_type_object( get_post_type() );
        return sprintf(
            /* translators: %s: Post type singular name (e.g. Post or Page) */
            __( '%s Custom Field', 'press-elements' ),
            $post_type_object->labels->singular_name
        );
    }
    
    public function get_icon()
    {
        return 'fa fa-plus-circle';
    }
    
    public function get_categories()
    {
        return [ 'press-elements-post-elements' ];
    }
    
    protected function _register_controls()
    {
        $post_type_object = get_post_type_object( get_post_type() );
        $this->start_controls_section( 'section_pro_feature', [
            'label' => sprintf(
            /* translators: %s: Post type singular name (e.g. Post or Page) */
            __( '%s Custom Field', 'press-elements' ),
            $post_type_object->labels->singular_name
        ),
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