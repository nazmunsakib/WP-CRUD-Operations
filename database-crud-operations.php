<?php
/*
Plugin Name: Database CRUD Operations
Plugin URI: https://nazmunsakib.co/
Description: Database CRUD Operations!
Version: 1.0.0
Author: Nazmun Sakib
Author URI: https://nazmunsakib.com
License: GPL2
Text Domain: database-crud-operations
Domain Path: /languages
*/

defined('ABSPATH') || die();

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Database_Crud_Operations class.
 *
 * @class Database_Crud_Operations class
 */
final class Database_Crud_Operations {

    /**
	 * Plugin instance
	 */
    private static $instance = null;

    /**
	 * Plugin version.
	 */
    private static $version = '1.0.0';

    /**
     * Class constructor.
     * 
     * @access private
     */
    private function __construct() {
        $this->define_const();
        $this->add_hooks();
    }

    /**
     * Initializes the Database_Crud_Operations() class.
     *
     * Checks for an existing Database_Crud_Operations() instance
     * 
     *  @since 1.0.0
     *
	 * @access public
	 * @static
	 *
	 * @return Database_Crud_Operations
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    /**
     * Define plugin constants.
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function define_const() {
        define( 'DCO_VERSION', self::$version );
        define( 'DCO_FILE', __FILE__ );
        define( 'DCO_PATH', __DIR__ );
        define( 'DCO_URL', plugins_url( '', DCO_FILE ) );
        define( 'DCO_ASSETS', DCO_URL . '/assets' );
    }

    /**
     * Add Hooks.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function add_hooks() {
        add_action( 'init', array( $this, 'load_textdomain' ) );
        add_action('plugins_loaded', array( $this, 'init') );
        register_activation_hook( __FILE__,array( $this, 'activation' ) );
    }

    /**
     * Plugins loaded.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init() {
        $this->includes();
    }

    /**
     * Includes classes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function includes() {
        new DatabaseCrudOperations\Enqueue();

        if( is_admin() ){
            new DatabaseCrudOperations\Admin\Admin_Menu();
            new DatabaseCrudOperations\Admin\Dashboard();
        }
    }

    /**
     * Load Plugin Text domain.
     *
     * @uses load_plugin_textdomain()
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'database-crud-operations', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
     * Plugin activation
     *
     */
    public function activation() {
        $installer = new DatabaseCrudOperations\Installer();
        $installer->active();
    }     
}

/**
 * Initialize Database_Crud_Operations().
 * 
 * @since 1.0.0
 *
 * @return \Database_Crud_Operations
 */
function database_crud_operations() {
    return Database_Crud_Operations::instance();
}

//run the plugin
database_crud_operations();
