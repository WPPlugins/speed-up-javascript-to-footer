<?php
/*
 Plugin Name: Speed Up - JavaScript To Footer
 Plugin URI: http://wordpress.org/plugins/speed-up-javascript-to-footer/
 Description: Move all the possible JavaScript files from head to footer and improve page load times.
 Version: 1.0.3
 Author: Simone Nigro
 Author URI: https://profiles.wordpress.org/nigrosimone
 License: GPLv2 or later
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( !defined('ABSPATH') ) exit;

class SpeedUp_JavaScriptToFooter {
    
    /**
     * Instance of the object.
     *
     * @since  1.0.0
     * @static
     * @access public
     * @var null|object
     */
    public static $instance = null;
    
    
    /**
     * Access the single instance of this class.
     *
     * @since  1.0.0
     * @return SpeedUp_JavaScriptToFooter
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     *
     * @since  1.0.0
     * @return SpeedUp_JavaScriptToFooter
     */
    private function __construct(){
        
        if( !is_admin() ){
            add_action( 'wp_enqueue_scripts', array( $this, 'move_scripts') );
        }
        
    }
    
    /**
     * Move scripts from head to bottom/footer.
     * 
     * @since  1.0.1
     * @return void
     */
    public function move_scripts(){
        // clean head
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        remove_action('wp_head', 'wp_enqueue_scripts', 1);
        
        // move script to footer
        add_action('wp_footer', 'wp_print_scripts', 5);
        add_action('wp_footer', 'wp_print_head_scripts', 5);
        add_action('wp_footer', 'wp_enqueue_scripts', 5);
    }
}

// Init
SpeedUp_JavaScriptToFooter::get_instance();