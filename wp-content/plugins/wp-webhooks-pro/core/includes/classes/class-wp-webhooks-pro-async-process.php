<?php

/**
 * WP_Webhooks_Pro_Async_Process Class
 *
 * This class contains all of the available api functions
 *
 * @since 4.3.0
 */

/**
 * The async class of the plugin.
 *
 * @since 4.3.0
 * @package WPWHPRO
 * @author Ironikus <info@ironikus.com>
 */
class WP_Webhooks_Pro_Async_Process extends WP_Background_Process {

	/**
	 * The remaining batch in case given
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $remaining_batch = null;

	public function __construct( $args = array() ) {
		/** We need to set the prefix and the identifier before constructing the parent class `WP_Async_Request` */
		$this->prefix = isset( $args['prefix'] ) ? $args['prefix'] : 'wpwh';
		$this->action = isset( $args['action'] ) ? $args['action'] : 'wpwh_default_process';
		$this->execution_action = 'continue';

		parent::__construct();
	}

	/**
	 * Clear the queue
	 *
	 * @since 6.0
	 *
	 * @return $this
	 */
	public function clear_queue() {
		$this->data = array();

		return $this;
	}

	/**
	 * Get the remaining batch of a current execution
	 *
	 * @since 6.0
	 *
	 * @return $this
	 */
	public function get_remaining_batch() {
		return $this->remaining_batch;
	}

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item_data Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $item_data ) {
		$return = false;

		if( $this->execution_action === 'continue' &&  is_array( $item_data ) ){

			$item_data = apply_filters( 'wpwhpro/async/process/' . $this->action, $item_data, $this );

			if( isset( $item_data['set_class_data'] ) && is_array( $item_data['set_class_data'] ) && ! empty( $item_data['set_class_data'] ) ){
				foreach( $item_data['set_class_data'] as $data_key => $data_value ){
					$this->{ $data_key } = $data_value;
				}
			}

			//since 5.2.2
			if( isset( $item_data['merge_class_data'] ) && is_array( $item_data['merge_class_data'] ) && ! empty( $item_data['merge_class_data'] ) ){
				foreach( $item_data['merge_class_data'] as $data_key => $data_value ){

					if( ! isset( $this->{ $data_key } ) || ! is_array( $this->{ $data_key } ) ){
						$this->{ $data_key } = array();
					}

					$this->{ $data_key } = array_merge( $this->{ $data_key }, $data_value );
				}
			}

			//Maybe retry action
			if( isset( $item_data['retry'] ) && $item_data['retry'] === true ){
				$return = $item_data;
			}

			//Maybe cancel task
			if( isset( $item_data['cancel'] ) && $item_data['cancel'] === true ){
				$this->execution_action = 'skip';
			}

			//Maybe pause task
			if( isset( $item_data['pause'] ) && $item_data['pause'] === true ){
				$this->execution_action = 'pause';
			}

		}

		return $return;
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		do_action( 'wpwhpro/async/process/completed/' . $this->action, $this );

		//reset execution action
		$this->execution_action = 'continue';

		parent::complete();
	}

	/**
	 * Overwritten handler to ccustomize the way we add tasks 
	 */
	protected function handle() {
		$this->lock_process();

		do {
			$batch = $this->get_batch();

			foreach ( $batch->data as $key => $value ) {

				$this->remaining_batch = $batch;

				$task = $this->task( $value );
				
				if ( false !== $task ) {
					$batch->data[ $key ] = $task;
				} else {
					unset( $batch->data[ $key ] );
				}

				if ( $this->time_exceeded() || $this->memory_exceeded() ) {
					// Batch limits reached.
					break;
				}
			}

			// Update or delete current batch.
			if ( ! empty( $batch->data ) ) {
				$this->update( $batch->key, $batch->data );
			} else {
				$this->delete( $batch->key );
			}
		} while ( ! $this->time_exceeded() && ! $this->memory_exceeded() && ! $this->is_queue_empty() );

		$this->unlock_process();
			
		// Start next batch or complete process.
		if ( ! $this->is_queue_empty() ) {
			$this->dispatch();
		} else {
			$this->complete();
		}

		wp_die();
	}

}
