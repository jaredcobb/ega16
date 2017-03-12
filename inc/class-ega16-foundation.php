<?php
/**
 * Helper class to customize WordPress in various ways to support Foundation
 *
 * @package ega16
 */

if ( ! class_exists( 'EGA16_Foundation' ) ) {

	/**
	 * EGA16_Foundation
	 *
	 * @package ega16
	 */
	class EGA16_Foundation {

		/**
		 * Instance of the object
		 *
		 * @var EGA16_Foundation
		 * @access protected
		 * @static
		 */
		protected static $instance;

		/**
		 * List of tags that can have data attrs
		 *
		 * @var array
		 */
		protected $tags = array(
			'a',
			'button',
			'div',
			'input',
			'li',
			'span',
			'ul',
		);

		/**
		 * List of allowed foundation data attrs
		 *
		 * @var array
		 */
		protected $data_attributes = array(
			'data-abide' => array(),
			'data-abide-validator' => array(),
			'data-accordion' => array(),
			'data-alert' => array(),
			'data-button' => array(),
			'data-caption' => array(),
			'data-class' => array(),
			'data-clearing' => array(),
			'data-clearing-interchange' => array(),
			'data-close' => array(),
			'data-content' => array(),
			'data-dropdown' => array(),
			'data-dropdown-content' => array(),
			'data-equalizer' => array(),
			'data-equalizer-mq' => array(),
			'data-equalizer-watch' => array(),
			'data-equalto' => array(),
			'data-id' => array(),
			'data-interchange' => array(),
			'data-invalid' => array(),
			'data-joyride' => array(),
			'data-magellan-arrival' => array(),
			'data-magellan-destination' => array(),
			'data-magellan-expedition' => array(),
			'data-offcanvas' => array(),
			'data-options' => array(),
			'data-orbit' => array(),
			'data-orbit-link' => array(),
			'data-orbit-slide' => array(),
			'data-orbit-slide-number' => array(),
			'data-prev-text' => array(),
			'data-reveal' => array(),
			'data-reveal-ajax' => array(),
			'data-reveal-id' => array(),
			'data-slider' => array(),
			'data-tab' => array(),
			'data-text' => array(),
			'data-tooltip' => array(),
			'data-topbar' => array(),
		);

		/**
		 * Do not initialize with the constructor
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Initialize this class with the instance() method.
		}

		/**
		 * Get the instance of the object
		 *
		 * @access public
		 * @static
		 * @return EGA16_Foundation
		 */
		public static function instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new EGA16_Foundation();
				static::$instance->setup();
			}
			return static::$instance;
		}

		/**
		 * Setup the instance of the object
		 *
		 * @access public
		 * @return void
		 */
		public function setup() {
			add_action( 'after_setup_theme', array( $this, 'whitelist_foundation_data_attrs' ) );
		}

		/**
		 * Allow foundation data attributes to exist in post content
		 *
		 * @return void
		 */
		public function whitelist_foundation_data_attrs() {
			xdebug_break();
			global $allowedposttags;

			foreach ( $this->tags as $tag ) {
				if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) ) {
					$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $this->data_attributes );
				}
			}
		}

	}
}

EGA16_Foundation::instance();
