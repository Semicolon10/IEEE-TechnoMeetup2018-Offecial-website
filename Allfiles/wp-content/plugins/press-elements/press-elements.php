<?php

/**
 * Plugin Name: Press Elements - Widgets for Elementor
 * Description: Easy-to-use widgets that help you display and design your content using Elementor page builder.
 * Plugin URI:  https://wordpress.org/plugins/press-elements/
 * Version:     1.7.2
 * Author:      Press Elements
 * Author URI:  https://press-elements.com/
 * Text Domain: press-elements
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Make sure the same class is not loaded twice in free/premium versions.
if ( !class_exists( 'Press_Elements' ) ) {
    /**
     * Main Press Elements Class
     *
     * The main class that initiates and runs the Press Elements plugin.
     *
     * @since 1.7.0
     */
    final class Press_Elements
    {
        /**
         * Press Elements Version
         *
         * Holds the version of the plugin.
         *
         * @since 1.7.0
         * @since 1.7.1 Moved from property with that name to a constant.
         *
         * @var string The plugin version.
         */
        const  VERSION = '1.7.2' ;
        /**
         * Minimum Elementor Version
         *
         * Holds the minimum Elementor version required to run the plugin.
         *
         * @since 1.7.0
         * @since 1.7.1 Moved from property with that name to a constant.
         *
         * @var string Minimum Elementor version required to run the plugin.
         */
        const  MINIMUM_ELEMENTOR_VERSION = '1.7.0' ;
        /**
         * Minimum PHP Version
         *
         * Holds the minimum PHP version required to run the plugin.
         *
         * @since 1.7.0
         * @since 1.7.1 Moved from property with that name to a constant.
         *
         * @var string Minimum PHP version required to run the plugin.
         */
        const  MINIMUM_PHP_VERSION = '5.4' ;
        /**
         * Instance
         *
         * Holds a single instance of the `Press_Elements` class.
         *
         * @since 1.7.0
         *
         * @access private
         * @static
         *
         * @var Press_Elements A single instance of the class.
         */
        private static  $_instance = null ;
        /**
         * Instance
         *
         * Ensures only one instance of the class is loaded or can be loaded.
         *
         * @since 1.7.0
         *
         * @access public
         * @static
         *
         * @return Press_Elements An instance of the class.
         */
        public static function instance()
        {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        /**
         * Clone
         *
         * Disable class cloning.
         *
         * @since 1.7.0
         *
         * @access protected
         *
         * @return void
         */
        public function __clone()
        {
            // Cloning instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'press-elements' ), '1.7.0' );
        }
        
        /**
         * Wakeup
         *
         * Disable unserializing the class.
         *
         * @since 1.7.0
         *
         * @access protected
         *
         * @return void
         */
        public function __wakeup()
        {
            // Unserializing instances of the class is forbidden.
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'press-elements' ), '1.7.0' );
        }
        
        /**
         * Constructor
         *
         * Initialize the Press Elements plugins.
         *
         * @since 1.7.0
         *
         * @access public
         */
        public function __construct()
        {
            $this->core_includes();
            $this->init_hooks();
            do_action( 'press_elements_loaded' );
        }
        
        /**
         * Include Files
         *
         * Load core files required to run the plugin.
         *
         * @since 1.7.0
         *
         * @access public
         */
        public function core_includes()
        {
            require_once __DIR__ . '/press-elements-freemius.php';
            require_once __DIR__ . '/press-elements-admin.php';
        }
        
        /**
         * Init Hooks
         *
         * Hook into actions and filters.
         *
         * @since 1.7.0
         *
         * @access private
         */
        private function init_hooks()
        {
            add_action( 'init', [ $this, 'i18n' ] );
            add_action( 'plugins_loaded', [ $this, 'init' ] );
        }
        
        /**
         * Load Textdomain
         *
         * Load plugin localization files.
         *
         * @since 1.7.0
         *
         * @access public
         */
        public function i18n()
        {
            load_plugin_textdomain( 'press-elements' );
        }
        
        /**
         * Init Press Elements
         *
         * Load the plugin after Elementor (and other plugins) are loaded.
         *
         * @since 1.0.0
         * @since 1.7.0 The logic moved from a standalone function to this class method.
         *
         * @access public
         */
        public function init()
        {
            // Press Elements Admin - displays even if Elementor is not active
            new \PressElements\Admin();
            // Check if Elementor installed and activated
            
            if ( !did_action( 'elementor/loaded' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
                return;
            }
            
            // Check for required Elementor version
            
            if ( !version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
                return;
            }
            
            // Check for required PHP version
            
            if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
                return;
            }
            
            // Add new Elementor Categories
            add_action( 'elementor/init', [ $this, 'add_elementor_category' ] );
            // Register Widget Scripts
            add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_widget_scripts' ] );
            // Register Widget Styles
            add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_widget_styles' ] );
            // Register New Widgets
            add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
        }
        
        /**
         * Admin notice
         *
         * Warning when the site doesn't have Elementor installed or activated.
         *
         * @since 1.1.0
         * @since 1.7.0 Moved from a standalone function to a class method.
         *
         * @access public
         */
        public function admin_notice_missing_main_plugin()
        {
            $message = sprintf(
                /* translators: 1: Press Elements 2: Elementor */
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'press-elements' ),
                '<strong>' . esc_html__( 'Press Elements', 'press-elements' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'press-elements' ) . '</strong>'
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }
        
        /**
         * Admin notice
         *
         * Warning when the site doesn't have a minimum required Elementor version.
         *
         * @since 1.1.0
         * @since 1.7.0 Moved from a standalone function to a class method.
         *
         * @access public
         */
        public function admin_notice_minimum_elementor_version()
        {
            $message = sprintf(
                /* translators: 1: Press Elements 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'press-elements' ),
                '<strong>' . esc_html__( 'Press Elements', 'press-elements' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'press-elements' ) . '</strong>',
                self::MINIMUM_ELEMENTOR_VERSION
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }
        
        /**
         * Admin notice
         *
         * Warning when the site doesn't have a minimum required PHP version.
         *
         * @since 1.7.0
         *
         * @access public
         */
        public function admin_notice_minimum_php_version()
        {
            $message = sprintf(
                /* translators: 1: Press Elements 2: PHP 3: Required PHP version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'press-elements' ),
                '<strong>' . esc_html__( 'Press Elements', 'press-elements' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'press-elements' ) . '</strong>',
                self::MINIMUM_PHP_VERSION
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }
        
        /**
         * Add new Elementor Categories
         *
         * Register new widget categories for Press Elements widgets.
         *
         * @since 1.0.0
         * @since 1.7.1 The method moved to this class.
         *
         * @access public
         */
        public function add_elementor_category()
        {
            \Elementor\Plugin::instance()->elements_manager->add_category( 'press-elements-site-elements', [
                'title' => __( 'Site Elements', 'press-elements' ),
            ], 1 );
            \Elementor\Plugin::instance()->elements_manager->add_category( 'press-elements-post-elements', [
                'title' => __( 'Post Elements', 'press-elements' ),
            ], 2 );
            \Elementor\Plugin::instance()->elements_manager->add_category( 'press-elements-effects', [
                'title' => __( 'Press Elements Pro Effects', 'press-elements' ),
            ], 3 );
            \Elementor\Plugin::instance()->elements_manager->add_category( 'press-elements-integrations', [
                'title' => __( 'Press Elements Pro Integrations', 'press-elements' ),
            ], 4 );
        }
        
        /**
         * Register Widget Scripts
         *
         * Register custom scripts required to run Press Elements.
         *
         * @since 1.6.0
         * @since 1.7.1 The method moved to this class.
         *
         * @access public
         */
        public function register_widget_scripts()
        {
            // Typing Effect
            wp_register_script( 'typedjs', plugins_url( 'press-elements/libs/typed/typed.js' ), array( 'jquery' ) );
            wp_register_script(
                'typing-effect',
                plugins_url( 'press-elements/assets/js/typing-effect.min.js' ),
                array( 'typedjs' ),
                rand()
            );
        }
        
        /**
         * Register Widget Styles
         *
         * Register custom styles required to run Press Elements.
         *
         * @since 1.7.0
         * @since 1.7.1 The method moved to this class.
         *
         * @access public
         */
        public function register_widget_styles()
        {
            // Typing Effect
            wp_register_style( 'typing-effect', plugins_url( 'press-elements/assets/css/typing-effect.min.css' ) );
            wp_enqueue_style( 'typing-effect' );
        }
        
        /**
         * Register New Widgets
         *
         * Include Press Elements widgets files and register them in Elementor.
         *
         * @since 1.0.0
         * @since 1.7.1 The method moved to this class.
         *
         * @access public
         */
        public function on_widgets_registered()
        {
            $this->include_widgets();
            $this->register_widgets();
        }
        
        /**
         * Include Widgets Files
         *
         * Load Press Elements widgets files.
         *
         * @since 1.0.0
         * @since 1.7.1 The method moved to this class.
         *
         * @access private
         */
        private function include_widgets()
        {
            // Site Elements
            require_once __DIR__ . '/widgets/site-title.php';
            require_once __DIR__ . '/widgets/site-description.php';
            require_once __DIR__ . '/widgets/site-logo.php';
            require_once __DIR__ . '/widgets/site-counters.php';
            // Post Elements
            require_once __DIR__ . '/widgets/post-title.php';
            require_once __DIR__ . '/widgets/post-excerpt.php';
            require_once __DIR__ . '/widgets/post-date.php';
            require_once __DIR__ . '/widgets/post-author.php';
            require_once __DIR__ . '/widgets/post-terms.php';
            require_once __DIR__ . '/widgets/post-featured-image.php';
            require_once __DIR__ . '/widgets/post-custom-field.php';
            require_once __DIR__ . '/widgets/post-comments.php';
            // Effects
            require_once __DIR__ . '/widgets/image-accordion.php';
            require_once __DIR__ . '/widgets/before-after-effect.php';
            require_once __DIR__ . '/widgets/notes.php';
            require_once __DIR__ . '/widgets/typing-effect.php';
            // Integrations
            require_once __DIR__ . '/widgets/advanced-custom-fields.php';
            require_once __DIR__ . '/widgets/gravatar.php';
            require_once __DIR__ . '/widgets/flickr.php';
            require_once __DIR__ . '/widgets/pinterest.php';
        }
        
        /**
         * Register Widgets
         *
         * Register Press Elements widgets.
         *
         * @since 1.0.0
         * @since 1.7.1 The method moved to this class.
         *
         * @access private
         */
        private function register_widgets()
        {
            // Site Elements
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Site_Title() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Site_Description() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Site_Logo() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Site_Counters() );
            // Post Elements
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Title() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Excerpt() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Date() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Author() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Terms() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Featured_Image() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Custom_Field() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Post_Comments() );
            // Effects
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Image_Accordion() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Before_After_Effect() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Notes() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Typing_Effect() );
            // Integrations
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Advanced_Custom_Fields() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Gravatar() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Flickr() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \PressElements\Widgets\Press_Elements_Pinterest() );
        }
    
    }
}
// Make sure the same function is not loaded twice in free/premium versions.

if ( !function_exists( 'press_elements_load' ) ) {
    /**
     * Load Press Elements
     *
     * Main instance of Press_Elements.
     *
     * @since 1.0.0
     * @since 1.7.0 The logic moved from this function to a class method.
     */
    function press_elements_load()
    {
        return Press_Elements::instance();
    }
    
    // Run Press Elements
    press_elements_load();
}
