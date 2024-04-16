<?php
namespace DatabaseCrudOperations\Admin;

defined('ABSPATH') || die();

/**
 * Plugin Dashboard class
 *
 * @package DatabaseCrudOperations
 */
class Dashboard {

    public function __construct() {
        $students = new Students();
        $this->bind_actions( $students );
    }

    /**
     * bind actions
     *
     * @return void
     */
    public function bind_actions( $students ) {
        add_action( 'admin_init', array( $students, 'add_form_handler' ) );
        add_action( 'admin_post_doc-delete-student', array( $students, 'delete_student' ) );
    }

}