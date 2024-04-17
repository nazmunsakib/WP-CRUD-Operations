<?php
namespace DatabaseCrudOperations\Admin;

defined('ABSPATH') || die();

/**
 * Plugin Dashboard class
 *
 * @package DatabaseCrudOperations
 */
class Students {

    public function __construct() {
       
    }


    /**
	 * Admin page data
     * 
     * @return void
	 *
	 */
    public function admin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch( $action ) {
            case 'add': 
                $template_file = __DIR__ . '/parts/add-student.php';
                break;
            case 'edit': 
                $student = dco_get_student( $id );
                $template_file = __DIR__ . '/parts/edit-student.php';
                break;
            
            default:
                $template_file = __DIR__ . '/parts/student-list.php';
                break;
        }

        if( file_exists( $template_file ) ){
            include $template_file;
        }
    }

    /**
	 * add new student page data
     * 
     * @return void
	 *
	 */
    public function add_student(){
        wp_enqueue_style('database-crud-operations');
        $template_file = __DIR__ . '/parts/add-student.php';

        if( file_exists( $template_file ) ){
            include $template_file;
        }
    }

    /**
     * Handle student form
     *
     * @return void
     */
    public function add_form_handler() {
        if ( ! isset( $_POST['submit_student'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-student' ) ) {
            wp_die( 'Invalid request!' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Invalid request!' );
        }

       $id      = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
       $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
       $email   = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';

       if( $id ){
            dco_update_student(
                array(
                    'id'    => $id,
                    'name'  => $name,
                    'email' => $email,
                )
            );

            $redirect = admin_url( 'admin.php?page=database-crud&action=edit&updated-student=true&id=' . $id );
       }else{

            if( empty( $name ) ){
                $redirect = admin_url( 'admin.php?page=add-new-student&added=false' );
            }else{
                dco_insert_student(
                    array(
                        'name'  => $name,
                        'email' => $email,
                    )
                );
    
                $redirect = admin_url( 'admin.php?page=database-crud&added=true' );
            }
       }

        wp_redirect( $redirect );

        exit;
    }

    public function delete_student() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'doc-delete-student' ) ) {
            wp_die( 'Invalid request!' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Invalid request!' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( dco_delete_student( $id ) ) {
            $redirect = admin_url( 'admin.php?page=database-crud&student-deleted=true' );
        } else {
            $redirect = admin_url( 'admin.php?page=database-crud&student-deleted=false' );
        }

        wp_redirect( $redirect );

        exit;
    }

}