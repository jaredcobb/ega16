<?php
/**
 * Helper class for the audio feature
 *
 * @package ega16
 */

if ( ! class_exists( 'EGA16_Audio' ) ) {

	/**
	 * EGA16_Audio
	 *
	 * @package ega16
	 */
	class EGA16_Audio {

		/**
		 * Instance of the object
		 *
		 * @var EGA16_Audio
		 * @access protected
		 * @static
		 */
		protected static $instance;

		/**
		 * Local copy of the theme mods
		 *
		 * @var array
		 */
		protected $theme_mods;

		/**
		 * Whether the audio is enabled or not
		 *
		 * @var bool
		 */
		protected $audio_enabled;

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
		 * @return EGA16_Audio
		 */
		public static function instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new EGA16_Audio();
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
			$this->theme_mods = get_theme_mods();
			if ( ! empty( $this->theme_mods['audio_enabled'] ) && true === $this->theme_mods['audio_enabled'] ) {
				$this->audio_enabled = true;
			} else {
				$this->audio_enabled = false;
			}
		}

		/**
		 * Whether or not audio is enabled
		 *
		 * @return bool
		 */
		public function audio_enabled() {
			return $this->audio_enabled;
		}

		/**
		 * Return the audio file to play when audio
		 * is toggled on, or false if not set
		 *
		 * @return mixed
		 */
		public function get_audio_toggle_file() {
			if (
				! empty( $this->theme_mods['audio_enabled'] )
				&& true === $this->theme_mods['audio_enabled']
				&& ! empty( $this->theme_mods['audio_file_toggled'] )
			) {
				return wp_get_attachment_url( $this->theme_mods['audio_file_toggled'] );
			} else {
				return false;
			}
		}

		/**
		 * Array of pages that are mapped to audio files
		 *
		 * @return array
		 */
		public function get_audio_page_hash() {
			$audio_page_hash = array();

			if ( ! empty( $this->theme_mods ) && ! empty( $this->theme_mods['audio_enabled'] ) && true === $this->theme_mods['audio_enabled'] ) {
				foreach ( $this->theme_mods as $name => $value ) {
					if ( false !== strpos( $name, 'audio_file_' ) ) {
						// We have an audio file, check if we have pages linked to it.
						$file_index = substr( $name, -1 );
						if ( ! empty( $this->theme_mods[ "audio_slugs_{$file_index}" ] ) ) {
							$page_slug_array = explode( ',', $this->theme_mods[ "audio_slugs_{$file_index}" ] );
							if ( ! empty( $page_slug_array ) ) {
								foreach ( $page_slug_array as $page_slug ) {
									$audio_page_hash[ $page_slug ] = wp_get_attachment_url( $value );
								}
							}
						}
					}
				}
			}
			return $audio_page_hash;
		}

	}

}

EGA16_Audio::instance();
