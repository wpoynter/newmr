<?php

class AdvertsV2 extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'adverts_v2_widget', // Base ID
			__('Adverts V2', 'fourwalls'), // Name
			array( 'description' => __( 'This widget displays all site wide adverts.', 'fourwalls' ), )
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
	
		echo __( 'Hello, World!', 'fourwalls' );
		
		echo $args['after_widget'];
	}

	/**
	 * Ouputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

function load_widget() {
    register_widget( 'AdvertsV2' );
}
add_action( 'widgets_init', 'load_widget' );

?>
