<?php
/**
 * Connection types for Posts 2 Posts.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Post_Connections' ) ) {
	/**
	 * Register Posts 2 Posts connections.
	 */
	class NewMR_Post_Connections {
		/**
		 * Setup hooks.
		 */
		public function __construct() {
			add_action( 'p2p_init', array( $this, 'register' ) );
		}

		/**
		 * Register connection types.
		 */
		public function register() {
			p2p_register_connection_type(
				array(
					'name' => 'presentation_to_event',
					'from' => 'presentation',
					'to'   => 'event',
				)
			);

			p2p_register_connection_type(
				array(
					'name' => 'presentation_to_person',
					'from' => 'presentation',
					'to'   => 'person',
				)
			);

			p2p_register_connection_type(
				array(
					'name' => 'presentation_to_advert',
					'from' => 'presentation',
					'to'   => 'advert',
				)
			);

			p2p_register_connection_type(
				array(
					'name' => 'event_to_advert',
					'from' => 'event',
					'to'   => 'advert',
				)
			);
		}
	}
}
