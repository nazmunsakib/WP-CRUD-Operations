<?php

namespace DatabaseCrudOperations\Admin;

defined('ABSPATH') || die();

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

 /**
 * Wp List Table Class
 *
 * @package DatabaseCrudOperations
 */
class Student_List extends \WP_List_Table {

    function __construct() {
        parent::__construct( [
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => false
        ] );
    }

    /**
     * not data found
     *
     * @return void
     */
    function no_items() {
        _e( 'No Student found!', 'database-crud-operations' );
    }

    /**
     * Get list column names
     *
     * @return array
     */
    public function get_columns() {
        return [
            'cb'    => '<input type="checkbox" />',
            'id'    => __( 'ID', 'database-crud-operations' ),
            'name'  => __( 'Name', 'database-crud-operations' ),
            'email' => __( 'Email', 'database-crud-operations' ),
        ];
    }

    /**
     * Make sortable of name column
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = [
            'id'    => [ 'id', true ],
            'name'  => [ 'name', true ],
        ];

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash'  => __( 'Move to Trash', 'wedevs-academy' ),
        );

        return $actions;
    }

    /**
     * Default column values
     *
     * @param  object $item
     * @param  string $column_name
     *
     * @return string
     */
    protected function column_default( $item, $column_name ) {

        switch ( $column_name ) {

            case 'created_at':
                return wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) );

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Render the "name" column
     *
     * @param  object $item
     *
     * @return string
     */
    public function column_name( $item ) {
        $actions = [];

        $nonce_url = wp_nonce_url( admin_url( 'admin-post.php?action=doc-delete-student&id=' . $item->id ), 'doc-delete-student');

        $actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=database-crud&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'database-crud-operations' ), __( 'Edit', 'database-crud-operations' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are You Sure?\');" title="%s">%s</a>',  $nonce_url, $item->id, __( 'Delete', 'database-crud-operations' ) );

        return sprintf(
            '<span><strong>%1$s</strong></span> %2$s', $item->name, $this->row_actions( $actions )
        );
    }

    /**
     * Render the "check box" column
     *
     * @param  object $item
     *
     * @return string
     */
    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="student_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Get students list
     *
     * @return void
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $column, $hidden, $sortable ];

        $per_page     = 10;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset,
        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items = dco_get_students( $args );
        $this->set_pagination_args( [
            'total_items' => dco_student_count(),
            'per_page'    => $per_page
        ] );
    }
}