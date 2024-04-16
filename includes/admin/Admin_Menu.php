<?php
namespace DatabaseCrudOperations\Admin;

defined('ABSPATH') || die();

/**
 * Plugin Admin menu class
 *
 * @package DatabaseCrudOperations
 */
class Admin_Menu {

    public function __construct() {
        add_action('admin_menu', array( $this, 'admin_menu') );
    }

    /**
	 * Add admin menu
	 *
     * @return void
	 */
    function admin_menu() {
        $parent_slug = 'database-crud';
        $capability = 'manage_options';

        $hook = add_menu_page( __('Database CRUD', 'database-crud-operations'), __('Database CRUD', 'database-crud-operations'),  $capability,  $parent_slug, array( $this, 'students_page'), 'dashicons-admin-generic' );
        add_submenu_page( $parent_slug,  __('Students Data', 'database-crud-operations'),  __('Students Data', 'database-crud-operations'),  $capability, $parent_slug, array( $this, 'students_page'));
        add_submenu_page( $parent_slug,  __('Add New Student', 'database-crud-operations'),  __('Add New Student', 'database-crud-operations'),  $capability, 'add-new-student', array( $this, 'add_new_student'));

        add_action( 'admin_head-' . $hook, [ $this, 'admin_assets' ] );
    }

    /**
	 * create admin page
     * 
     * @return void
	 *
	 */
    public function students_page() {
        $students = new Students();
        $students->admin_page();
    }

    /**
	 * create admin page
     * 
     * @return void
	 *
	 */
    public function add_new_student() {
        $students = new Students();
        $students->add_student();
    }

    /**
	 * load admin style
     * 
     * @return void
	 *
	 */
    public function admin_assets(){
        wp_enqueue_style('database-crud-operations');
    }

}