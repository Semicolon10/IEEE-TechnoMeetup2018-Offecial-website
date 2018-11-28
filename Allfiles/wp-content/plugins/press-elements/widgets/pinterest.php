<?php

namespace PressElements\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Press Elements Pinterest
 *
 * Pinterest element for elementor.
 *
 * @since 1.5.0
 */
class Press_Elements_Pinterest extends Widget_Base
{
    public function get_name()
    {
        return 'pinterest';
    }
    
    public function get_title()
    {
        return __( 'Pinterest', 'press-elements' );
    }
    
    public function get_icon()
    {
        return 'fa fa-pinterest';
    }
    
    public function get_categories()
    {
        return [ 'press-elements-integrations' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_pro_feature', [
            'label' => __( 'Pinterest', 'press-elements' ),
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
    
    public function get_pins( $username, $total_pins )
    {
        // Set RSS cache lifetime in seconds
        $cache_lifetime = 900;
        add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return ' . $cache_lifetime . ';' ) );
        // Get the RSS feed
        $url = sprintf( 'https://pinterest.com/%s/feed.rss', $username );
        $rss = fetch_feed( $url );
        if ( is_wp_error( $rss ) ) {
            return null;
        }
        $maxitems = $rss->get_item_quantity( $total_pins );
        $rss_items = $rss->get_items( 0, $maxitems );
        if ( is_null( $rss_items ) ) {
            return null;
        }
        // Build patterns to search/replace in the image urls. Pattern to replace for the images.
        $search = array( '_b.jpg' );
        $replace = array( '_t.jpg' );
        // Make urls protocol relative
        array_push( $search, 'https://' );
        array_push( $replace, '//' );
        $pins = array();
        foreach ( $rss_items as $item ) {
            $title = $item->get_title();
            $description = $item->get_description();
            $url = $item->get_permalink();
            if ( preg_match_all( '/<img src="([^"]*)".*>/i', $description, $matches ) ) {
                $image = str_replace( $search, $replace, $matches[1][0] );
            }
            array_push( $pins, array(
                'title' => $title,
                'image' => $image,
                'url'   => $url,
            ) );
        }
        return $pins;
    }

}