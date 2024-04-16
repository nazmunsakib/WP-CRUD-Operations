<?php
/**
 * Plugin Enqueue Assets.
 *
 * @package Enqueue
 */
namespace DatabaseCrudOperations;

defined('ABSPATH') || die();

class Enqueue {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 100 );
	}

	/**
	 * Enqueue frontend assets.
	 *
	 * Frontend assets handler
	 *
	 * @return void
	 */
	public function admin_enqueue() {
		wp_register_style(
			'database-crud-operations',
			DCO_ASSETS . '/css/style.css',
			null,
			DCO_VERSION
		);
	}

}