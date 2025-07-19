<?php
/**
 * Dashboard Glancer utilities for NewMR.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'NewMR_Dashboard_Glancer' ) ) {
	/**
	 * Register custom post types in the At a Glance widget.
	 */
	class NewMR_Dashboard_Glancer {
		/**
		 * List of post types to display.
		 *
		 * @var array
		 */
		protected $post_types = array();

		/**
		 * Setup hooks.
		 */
		public function __construct() {
			add_action( 'dashboard_glance_items', array( $this, 'show' ) );
		}

		/**
		 * Add post types to the list.
		 *
		 * @param string|array $types Post type names.
		 */
		public function add( $types ) {
			foreach ( (array) $types as $type ) {
				$object = get_post_type_object( $type );
				if ( $object ) {
					$this->post_types[] = $type;
				}
			}
		}

		/**
		 * Output dashboard items.
		 */
		public function show() {
			foreach ( $this->post_types as $type ) {
				$object = get_post_type_object( $type );
				if ( ! $object ) {
					continue;
				}
				$count = wp_count_posts( $type )->publish;
				if ( ! $count ) {
					continue;
				}

				$label = ( 1 === $count ) ? $object->labels->singular_name : $object->labels->name;
				$text  = sprintf( "%1$s %2$s", number_format_i18n( $count ), $label );

				if ( current_user_can( $object->cap->edit_posts ) ) {
					$text = sprintf(
						'<a href="%s">%s</a>',
						esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
						$text
					);
				}

				echo '<li class="' . esc_attr( $type ) . '-count">' . $text . '</li>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
}
