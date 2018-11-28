<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Make sure the same methods/classes aren’t loaded twice for free/premium versions
if ( !function_exists( 'press_elements_freemius' ) ) {
    /**
     * Load Freemius SDK
     *
     * Load and init Freemius SDK for this plugin.
     *
     * @since 1.0.0
     */
    function press_elements_freemius()
    {
        global  $press_elements_freemius ;
        
        if ( !isset( $press_elements_freemius ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/libs/freemius/start.php';
            $press_elements_freemius = fs_dynamic_init( array(
                'id'             => '761',
                'slug'           => 'press-elements',
                'type'           => 'plugin',
                'public_key'     => 'pk_fe2850d57f7d4f206aefaa106b91f',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'    => 'press-elements',
                'contact' => false,
                'support' => false,
                'pricing' => false,
                'parent'  => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'        => true,
            ) );
        }
        
        return $press_elements_freemius;
    }

}
// Make sure the same methods/classes aren’t loaded twice for free/premium versions
if ( !function_exists( 'press_elements_freemius_header' ) ) {
    /**
     * Add header title
     *
     * Insets H1 title to the freemius templates.
     *
     * @since 1.6.0
     *
     * @param string $html Template html.
     *
     * @return string Updated template html.
     */
    function press_elements_freemius_header( $html )
    {
        $title = sprintf( '<h1>%1$s</h1><p>%2$s</p>', esc_html__( 'Press Elements - Widgets for Elementor', 'press-elements' ), esc_html__( 'Easy-to-use widgets that help you display and design your content using Elementor page builder.', 'press-elements' ) );
        return $title . $html;
    }

}
// Init Freemius
press_elements_freemius();
press_elements_freemius()->add_filter( 'templates/account.php', 'press_elements_freemius_header' );
press_elements_freemius()->add_filter( 'templates/billing.php', 'press_elements_freemius_header' );
// Signal that SDK was initiated.
do_action( 'press_elements_freemius_loaded' );