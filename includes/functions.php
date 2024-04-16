<?php

/**
 * Insert a new student
 * @param  array  $student
 *
 * @return int
 */
function dco_insert_student( $student = [] ) {
    global $wpdb;

    //check it's valide name 
    if ( empty( $student['name'] ) ) {
        return new \WP_Error( 'name-is-empty', __( 'You must provide a name.', 'database-crud-operations' ) );
    }

    //default value
    $default_val = [
        'name'      => '',
        'email'     => '',
    ];

    $data = wp_parse_args( $student, $default_val );

    //insert new data
    $inserted = $wpdb->insert(
        $wpdb->prefix . 'students_crud',
        $data,
        [
            '%s',
            '%s', 
        ]
    );

    if ( ! $inserted ) {
        return new \WP_Error( 'not-inserted', __( 'Failed to insert student', 'database-crud-operations' ) );
    }

    return $wpdb->insert_id;
}

/**
 * Update a student
 * @param  array  $student
 *
 * @return int
 */
function dco_update_student( $student = [] ) {
    global $wpdb;

    //check it's valide name 
    if ( empty( $student['id'] ) ) {
        return new \WP_Error( 'name-is-empty', __( 'You must provide a ID.', 'database-crud-operations' ) );
    }

    $id = $student['id'];
    unset( $student['id'] );

    $updated = $wpdb->update(
        $wpdb->prefix . 'students_crud',
        $student,
        [ 'id' => $id ],
        [
            '%s',
            '%s',
        ],
        [ '%d' ]
    );

    return $updated;
}

/**
 * Get student by ID
 *
 * @param  int $id
 *
 * @return object
 */
function dco_get_student( $id ) {
    global $wpdb;

    $student = $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}students_crud WHERE id = %d", $id )
    );

    return $student;
}

/**
 * Fetch Students
 *
 * @param  array  $args
 *
 * @return array
 */
function dco_get_students( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 10,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC'
    ];

    $data = wp_parse_args( $args, $defaults );

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}students_crud
            ORDER BY {$data['orderby']} {$data['order']}
            LIMIT %d, %d",
            $data['offset'], $data['number']
    );

    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Get the count of total students count
 * @return int
 */
function dco_student_count() {
    global $wpdb;
    $total_count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}students_crud" );

    return $total_count;
}

/**
 * Delete Student
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function  dco_delete_student( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'students_crud',
        [ 'id' => $id ],
        [ '%d' ]
    );
}