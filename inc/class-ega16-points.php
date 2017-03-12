<?php
/**
 * Helper class for the points feature
 *
 * @package ega16
 */

if ( ! class_exists( 'EGA16_Points' ) ) {

	/**
	 * EGA16_Points
	 *
	 * @package ega16
	 */
	class EGA16_Points {

		/**
		 * Instance of the object
		 *
		 * @var EGA16_Points
		 * @access protected
		 * @static
		 */
		protected static $instance;

		/**
		 * Sum of possible points based on theme settings
		 *
		 * @var array
		 */
		protected $total_points;

		/**
		 * Whether the points feature is enabled or not
		 *
		 * @var bool
		 */
		protected $points_enabled;

		/**
		 * Local copy of the theme mods
		 *
		 * @var array
		 */
		protected $theme_mods;

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
		 * @return EGA16_Points
		 */
		public static function instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new EGA16_Points();
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
			add_action( 'wp_ajax_nopriv_get_win_content', array( $this, 'get_win_content' ) );
			add_action( 'wp_ajax_get_win_content', array( $this, 'get_win_content' ) );

			$this->theme_mods = get_theme_mods();
			if ( ! empty( $this->theme_mods['points_enabled'] ) && true === $this->theme_mods['points_enabled'] ) {
				$this->points_enabled = true;
				$this->total_points = 20 * ( count( $this->get_points_page_selectors() ) + count( $this->get_points_click_selectors() ) );
			} else {
				$this->points_enabled = false;
				$this->total_points = 0;
			}
		}

		/**
		 * Get the total allowed points
		 *
		 * @return int
		 */
		public function get_total_points() {
			return $this->total_points;
		}

		/**
		 * Whether or not the points system is enabled
		 *
		 * @return bool
		 */
		public function points_enabled() {
			return $this->points_enabled;
		}

		/**
		 * Get the total player score from the cookie
		 *
		 * @return int
		 */
		public function get_score() {
			if ( ! empty( $_COOKIE['ega16_score'] ) && intval( $_COOKIE['ega16_score'] ) ) {
				return intval( $_COOKIE['ega16_score'] );
			} else {
				return 0;
			}
		}

		/**
		 * Get a collection of pages that award points for visiting
		 *
		 * @return array
		 */
		public function get_points_page_selectors() {
			$points_page_selectors = array();
			if ( $this->points_enabled && ! empty( $this->theme_mods['points_page_selectors'] ) ) {
				$points_page_selectors = explode( ',', $this->theme_mods['points_page_selectors'] );
				if ( ! empty( $points_page_selectors ) ) {
					$points_page_selectors = array_map( 'trim', array_unique( $points_page_selectors ) );
				}
			}
			return $points_page_selectors;
		}

		/**
		 * Get a collection of jQuery selectors that award points if clicked
		 *
		 * @return array
		 */
		public function get_points_click_selectors() {
			$points_click_selectors = array();
			if ( $this->points_enabled && ! empty( $this->theme_mods['points_click_selectors'] ) ) {
				$points_click_selectors = explode( ',', $this->theme_mods['points_click_selectors'] );
				if ( ! empty( $points_click_selectors ) ) {
					$points_click_selectors = array_map( 'trim', array_unique( $points_click_selectors ) );
				}
			}
			return $points_click_selectors;
		}

		public function get_win_content() {
			$args = array(
				'name' => 'win',
				'post_type' => 'page',
				'post_status' => 'publish',
				'numberposts' => 1,
			);
			$win_query = new WP_Query( $args );

			if ( $win_query->post_count ) {
				echo apply_filters( 'the_content', $win_query->posts[0]->post_content );
			}
			wp_die();
		}
	}

}

EGA16_Points::instance();
