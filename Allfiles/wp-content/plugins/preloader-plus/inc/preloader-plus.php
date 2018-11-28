<?php

/**
 * Main Preloader Plus plugin class/file.
 *
 * @package preloader-plus
 */
namespace Preloader_Plus;

/**
 * Preloader Plus class, so we don't have to worry about namespaces.
 */
class Preloader_Plus
{
    /**
     * The instance *Singleton* of this class
     *
     * @var object
     */
    private static  $instance ;
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Preloader_Plus the *Singleton* instance.
     */
    public static function get_instance()
    {
        if ( null === static::$instance ) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    /**
     * Class construct function, to initiate the plugin.
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        // Actions.
        add_action( 'admin_menu', array( $this, 'create_top_menu_page' ) );
        add_action( 'admin_menu', array( $this, 'create_plugin_page' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ) );
        add_action( 'wp_footer', array( $this, 'preloader_view' ) );
        add_action( 'before_preloader_plus', array( $this, 'show_prog_bar' ) );
        add_action( 'upload_mimes', array( $this, 'add_svg_mime' ) );
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        // Loads files
        require_once PRELOADER_PLUS_PATH . 'inc/customizer.php';
    }
    
    /**
     * Private clone method to prevent cloning of the instance of the *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }
    
    /**
     * Private unserialize method to prevent unserializing of the *Singleton* instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
    
    /**
     * Creates the main settings page.
     */
    public function create_top_menu_page()
    {
        add_menu_page(
            'Preloader Plus',
            'Preloader Plus',
            'manage_options',
            'preloader_plus_setting_page',
            '',
            PRELOADER_PLUS_URL . 'assets/img/preloader-plus-logo.png'
        );
    }
    
    /**
     * Creates the plugin page and a submenu item in WP menu.
     */
    public function create_plugin_page()
    {
        $plugin_page_setup = array(
            'parent_slug' => 'preloader_plus_setting_page',
            'page_title'  => esc_html__( 'Preloader Plus', 'bie' ),
            'menu_title'  => esc_html__( 'Preloader Plus', 'bie' ),
            'capability'  => 'import',
            'menu_slug'   => 'preloader_plus_setting_page',
        );
        $this->plugin_page = add_submenu_page(
            $plugin_page_setup['parent_slug'],
            $plugin_page_setup['page_title'],
            $plugin_page_setup['menu_title'],
            $plugin_page_setup['capability'],
            $plugin_page_setup['menu_slug'],
            array( $this, 'display_plugin_page' )
        );
    }
    
    /**
     * Plugin page display.
     * Output (HTML) is in another file.
     */
    public function display_plugin_page()
    {
        require_once PRELOADER_PLUS_PATH . 'views/plugin-page.php';
    }
    
    public function enqueue_scripts()
    {
        
        if ( $this->is_preloader_active() ) {
            $preloader_plus_settings = wp_parse_args( get_option( 'preloader_plus_settings', array() ), preloader_plus_get_default() );
            if ( false !== $preloader_plus_settings['show_on_front'] && !is_front_page() ) {
                return;
            }
            wp_enqueue_style(
                'preloader-plus',
                PRELOADER_PLUS_URL . 'assets/css/preloader-plus.min.css',
                array(),
                PRELOADER_PLUS_VERSION
            );
            
            if ( is_customize_preview() ) {
                wp_enqueue_script(
                    'preloader-plus-preview',
                    PRELOADER_PLUS_URL . '/assets/js/preloader-plus-preview.js',
                    array( 'jquery' ),
                    PRELOADER_PLUS_VERSION,
                    false
                );
                wp_localize_script( 'preloader-plus-preview', 'preloader_plus', array(
                    'animation_delay'    => $preloader_plus_settings['animation_delay'],
                    'animation_duration' => $preloader_plus_settings['animation_duration'],
                ) );
            } else {
                wp_enqueue_script(
                    'preloader-plus',
                    PRELOADER_PLUS_URL . '/assets/js/preloader-plus.min.js',
                    array( 'jquery' ),
                    PRELOADER_PLUS_VERSION,
                    false
                );
                // Get preloader options.
                wp_localize_script( 'preloader-plus', 'preloader_plus', array(
                    'animation_delay'    => $preloader_plus_settings['animation_delay'],
                    'animation_duration' => $preloader_plus_settings['animation_duration'],
                ) );
            }
        
        }
    
    }
    
    public function enqueue_admin_scripts( $page )
    {
        if ( 'toplevel_page_preloader_plus_setting_page' == $page ) {
            wp_enqueue_style(
                'preloader-plus-options',
                PRELOADER_PLUS_URL . 'assets/admin/css/preloader-plus-options.css',
                array(),
                PRELOADER_PLUS_VERSION
            );
        }
        wp_enqueue_style(
            'preloader-plus-admin',
            PRELOADER_PLUS_URL . 'assets/admin/css/preloader-plus-admin.css',
            array(),
            PRELOADER_PLUS_VERSION
        );
    }
    
    public function enqueue_control_scripts()
    {
        wp_enqueue_style(
            'preloader-plus-customizer',
            PRELOADER_PLUS_URL . 'assets/admin/css/preloader-plus-customizer.css',
            array(),
            PRELOADER_PLUS_VERSION
        );
    }
    
    /**
     * Get preloader options.
     *
     * @since 1.0
     */
    public function get_options()
    {
        // Get preloader options.
        $preloader_plus_settings = wp_parse_args( get_option( 'preloader_plus_settings', array() ), preloader_plus_get_default() );
        return $preloader_plus_settings;
    }
    
    public function add_new_elements()
    {
        $new_choices = array(
            'custom_image'   => esc_html__( 'Custom image', 'preloader-plus' ),
            'icon'           => esc_html__( 'Built-in icon', 'preloader-plus' ),
            'blog_name'      => esc_html__( 'Blog name', 'preloader-plus' ),
            'custom_content' => esc_html__( 'Custom content', 'preloader-plus' ),
            'counter'        => esc_html__( 'Percentage counter', 'preloader-plus' ),
            'progress_bar'   => esc_html__( 'Progress bar', 'preloader-plus' ),
        );
        return $new_choices;
    }
    
    /**
     * Display the preloader.
     *
     * @since 1.0
     */
    public function preloader_view()
    {
        if ( !$this->is_preloader_active() ) {
            return;
        }
        // Get preloader options.
        $settings = $this->get_options();
        if ( false !== $settings['show_on_front'] && !is_front_page() ) {
            return;
        }
        ?>
		 <div class="preloader-plus"> <?php 
        do_action( 'before_preloader_plus' );
        ?>
			 <div class="preloader-content"> <?php 
        $elements = $settings['elements'];
        if ( !empty($elements) && is_array( $elements ) ) {
            foreach ( $elements as $element ) {
                // Custom image
                
                if ( !empty($settings['custom_icon_image']) && 'custom_image' == $element ) {
                    ?>
  	 					<img class="preloader-custom-img" src="<?php 
                    echo  esc_url( $settings['custom_icon_image'] ) ;
                    ?>" /> <?php 
                }
                
                // Default icon
                if ( 'icon' == $element ) {
                    if ( file_exists( PRELOADER_PLUS_PATH . 'views/' . $settings['icon_image'] . '.php' ) ) {
                        include_once PRELOADER_PLUS_PATH . 'views/' . $settings['icon_image'] . '.php';
                    }
                }
                // Site title
                
                if ( 'blog_name' == $element ) {
                    ?>
  						<h1 class="preloader-site-title"> <?php 
                    esc_html( bloginfo( 'name' ) );
                    ?></h1> <?php 
                }
                
                // Counter
                if ( 'counter' == $element ) {
                    ?>
  						<p id="preloader-counter">0</p> <?php 
                }
                if ( 'progress_bar' == $element && 'middle' === $settings['prog_bar_position'] ) {
                    ?>
							<div class="prog-bar-wrapper middle">
								<div class="prog-bar-bg"></div>
								<div class="prog-bar"></div>
							</div> <?php 
                }
            }
        }
        ?>

			 </div>
		 </div> <?php 
    }
    
    /**
     * Display/Hide the progress bar.
     *
     * @since 1.0
     */
    public function show_prog_bar()
    {
        // Get preloader options.
        $settings = $this->get_options();
        if ( in_array( 'progress_bar', $settings['elements'] ) && 'middle' !== $settings['prog_bar_position'] ) {
            ?>
			<div class="prog-bar-wrapper">
				<div class="prog-bar-bg"></div>
				<div class="prog-bar"></div>
			</div> <?php 
        }
    }
    
    /**
     * Check if the preloader is enabled.
     *
     * @since 1.0
     */
    public function is_preloader_active()
    {
        // Get preloader options.
        $preloader_plus_settings = wp_parse_args( get_option( 'preloader_plus_settings', array() ), preloader_plus_get_default() );
        if ( $preloader_plus_settings['enable_preloader'] === false ) {
            return false;
        }
        return true;
    }
    
    /**
     * Allow svg file upload.
     *
     * @since 1.0
     */
    public function add_svg_mime( $mimes )
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    
    /**
     * Load the plugin textdomain, so that translations can be made.
     */
    public function load_textdomain()
    {
        load_plugin_textdomain( 'preloader-plus', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
    }

}