<?php

namespace DatabaseCrudOperations;

defined('ABSPATH') || die();

/**
 * Plugin Installer class
 */
class Installer {

    /**
     * DB dablle name
     */
    public $table_name;

    /**
     * active
     *
     * @return void
     */
    public function active() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'students_crud';

        update_option( 'students_crud_version', DCO_VERSION );
        $this->create_student_tables();
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_student_tables() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $sql );
    }
}