<?php
/**
 * Customizing the Customizer with custom customizations
 *
 * @package ega16
 */

if ( ! class_exists( 'EGA16_Customizer' ) ) {

	/**
	 * EGA16_Customizer
	 *
	 * @package ega16
	 */
	class EGA16_Customizer {

		/**
		 * Instance of the object
		 *
		 * @var EGA16_Customizer
		 * @access protected
		 * @static
		 */
		protected static $instance;

		/**
		 * Instance of the WP_Customize_Manager
		 *
		 * @var WP_Customize_Manager
		 */
		protected $wp_customize;

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
		 * @return EGA16_Customizer
		 */
		public static function instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new EGA16_Customizer();
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
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
		}

		/**
		 * Customize all the things!
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @return void
		 */
		public function customize_register( $wp_customize ) {
			$this->wp_customize = $wp_customize;
			$this->add_post_message_support();
			$this->add_global_section();
			$this->add_global_callout();
			$this->add_global_sidebar();
			$this->add_homepage_section();
			$this->add_homepage_controls();
			$this->add_audio_section();
			$this->add_audio_controls();
			$this->add_points_section();
			$this->add_points_controls();
			$this->add_404_section();
			$this->add_404_controls();
		}

		/**
		 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
		 *
		 * @return void
		 */
		public function customize_preview_js() {
			wp_enqueue_script( 'ega16_customizer', get_template_directory_uri() . '/static/js/customizer.js', array( 'customize-preview' ), '20151215', true );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @return void
		 */
		protected function add_post_message_support() {
			$this->wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
			$this->wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
			$this->wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		}

		/**
		 * Create a section for global settings
		 *
		 * @return void
		 */
		protected function add_global_section() {
			$this->wp_customize->add_section( 'global_section', array(
				'title' => __( 'EGA 16 Global Settings' ),
				'description' => __( 'Settings that affect the theme globally' ),
				'priority' => 160,
			) );
		}

		/**
		 * Create settings for the global callout box
		 *
		 * @return void
		 */
		protected function add_global_callout() {
			$this->wp_customize->add_setting( 'global_callout_enabled', array(
				'type' => 'theme_mod',
				'default' => false,
			) );
			$this->wp_customize->add_setting( 'global_callout_content', array(
				'type' => 'theme_mod',
				'default' => '',
				'sanitize_callback' => 'wp_kses_post',
			) );

			$this->wp_customize->add_control( 'global_callout_enabled', array(
				'type' => 'checkbox',
				'section' => 'global_section',
				'label' => __( 'Enable Global Header Callout', 'ega16' ),
				'description' => __( 'This allows you to display a callout box on all pages in the header.', 'ega16' ),
			) );
			$this->wp_customize->add_control( 'global_callout_content', array(
				'type' => 'textarea',
				'section' => 'global_section',
				'label' => __( 'Global Header Callout Content', 'ega16' ),
				'description' => __( 'The text to display in the callout (HTML is allowed)', 'ega16' ),
			) );
		}

		protected function add_global_sidebar() {
			$this->wp_customize->add_setting( 'global_sidebar_enabled', array(
				'type' => 'theme_mod',
				'default' => true,
			) );
			$this->wp_customize->add_setting( 'global_sidebar_sticky', array(
				'type' => 'theme_mod',
				'default' => true,
			) );

			$this->wp_customize->add_control( 'global_sidebar_enabled', array(
				'type' => 'checkbox',
				'section' => 'global_section',
				'label' => __( 'Enable Sidebar On Blog Pages', 'ega16' ),
				'description' => __( 'This allows you to enable / disable the sidebar on blog archives and single posts. Pages use a page template to enable / disable the sidebar.', 'ega16' ),
			) );
			$this->wp_customize->add_control( 'global_sidebar_sticky', array(
				'type' => 'checkbox',
				'section' => 'global_section',
				'label' => __( 'Make The Sidebar Sticky', 'ega16' ),
				'description' => __( 'Should the sidebar float down with the page as it scrolls?.', 'ega16' ),
			) );
		}

		/**
		 * Create a section for global settings
		 *
		 * @return void
		 */
		protected function add_homepage_section() {
			$this->wp_customize->add_section( 'homepage_section', array(
				'title' => __( 'EGA 16 Homepage Settings' ),
				'description' => __( 'Settings for the homepage' ),
				'priority' => 160,
			) );
		}

		/**
		 * Create settings for the global callout box
		 *
		 * @return void
		 */
		protected function add_homepage_controls() {
			$this->wp_customize->add_setting( 'homepage_callout_enabled', array(
				'type' => 'theme_mod',
				'default' => false,
			) );
			$this->wp_customize->add_setting( 'homepage_callout_content', array(
				'type' => 'theme_mod',
				'default' => '',
				'sanitize_callback' => 'wp_kses_post',
			) );

			$this->wp_customize->add_control( 'homepage_callout_enabled', array(
				'type' => 'checkbox',
				'section' => 'homepage_section',
				'label' => __( 'Enable Homepage Header Callout', 'ega16' ),
				'description' => __( 'This allows you to display a callout box on the homepage in the header.', 'ega16' ),
			) );
			$this->wp_customize->add_control( 'homepage_callout_content', array(
				'type' => 'textarea',
				'section' => 'homepage_section',
				'label' => __( 'Homepage Header Callout Content', 'ega16' ),
				'description' => __( 'The text to display in the callout (HTML is allowed)', 'ega16' ),
			) );
		}

		/**
		 * Create a section for global settings
		 *
		 * @return void
		 */
		protected function add_audio_section() {
			$this->wp_customize->add_section( 'audio_section', array(
				'title' => __( 'EGA 16 Audio Settings' ),
				'description' => __( 'Settings for the audio feature' ),
				'priority' => 160,
			) );
		}

		/**
		 * Create settings for the global callout box
		 *
		 * @return void
		 */
		protected function add_audio_controls() {
			$this->wp_customize->add_setting( 'audio_enabled', array(
				'type' => 'theme_mod',
				'default' => false,
			) );

			$this->wp_customize->add_setting( 'audio_file_toggled', array(
				'type' => 'theme_mod',
				'default' => '',
			) );

			$this->wp_customize->add_control( 'audio_enabled', array(
				'type' => 'checkbox',
				'section' => 'audio_section',
				'label' => __( 'Enable Audio In The Theme', 'ega16' ),
				'description' => __( 'This allows you to have some fun with the audio by playing audio for some pages', 'ega16' ),
			) );

			$this->wp_customize->add_control( new WP_Customize_Media_Control( $this->wp_customize, 'audio_file_toggled', array(
				'label' => __( 'Audio File When Toggled On', 'ega16' ),
				'description' => __( 'Which audio file should play when the user toggles the sound on?', 'ega16' ),
				'section' => 'audio_section',
				'mime_type' => 'audio',
			) ) );

			$audio_control_count = 5;

			for ( $i = 1; $i <= $audio_control_count; $i++ ) {

				$this->wp_customize->add_setting( 'audio_file_' . $i, array(
					'type' => 'theme_mod',
					'default' => '',
				) );
				$this->wp_customize->add_setting( 'audio_slugs_' . $i, array(
					'type' => 'theme_mod',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field',
				) );

				$this->wp_customize->add_control( new WP_Customize_Media_Control( $this->wp_customize, 'audio_file_' . $i, array(
				  'label' => sprintf( __( 'Audio File %s', 'ega16' ), $i ),
				  'section' => 'audio_section',
				  'mime_type' => 'audio',
				) ) );

				$this->wp_customize->add_control( 'audio_slugs_' . $i, array(
					'type' => 'text',
					'section' => 'audio_section',
					'label' => sprintf( __( 'Page / Post Class Names for Audio File %s (comma separated)', 'ega16' ), $i ),
					'description' => __( 'Which post(s) / page(s) should this audio play? (e.g. "page", "single", "home", "hello-world")', 'ega16' ),
				) );

			}

		}

		/**
		 * Create a section for global settings
		 *
		 * @return void
		 */
		protected function add_points_section() {
			$this->wp_customize->add_section( 'points_section', array(
				'title' => __( 'EGA 16 Points Settings' ),
				'description' => __( 'Settings for the points feature' ),
				'priority' => 160,
			) );
		}

		/**
		 * Create settings for the global callout box
		 *
		 * @return void
		 */
		protected function add_points_controls() {
			$this->wp_customize->add_setting( 'points_enabled', array(
				'type' => 'theme_mod',
				'default' => false,
			) );

			$this->wp_customize->add_control( 'points_enabled', array(
				'type' => 'checkbox',
				'section' => 'points_section',
				'label' => __( 'Enable Points In The Theme', 'ega16' ),
				'description' => __( 'This allows you to have some fun with awarding points for visiting pages and clicking things', 'ega16' ),
			) );

			$this->wp_customize->add_setting( 'points_click_selectors', array(
				'type' => 'theme_mod',
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$this->wp_customize->add_control( 'points_click_selectors', array(
				'type' => 'text',
				'section' => 'points_section',
				'label' => __( 'CSS selectors for anything that should award points for clicking (comma separated)', 'ega16' ),
				'description' => __( 'When the user clicks something that matches the selector, points are awarded', 'ega16' ),
			) );

			$this->wp_customize->add_setting( 'points_page_selectors', array(
				'type' => 'theme_mod',
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$this->wp_customize->add_control( 'points_page_selectors', array(
				'type' => 'text',
				'section' => 'points_section',
				'label' => __( 'Page / Post Class Names for Awarding Points for a Visit', 'ega16' ),
				'description' => __( 'Which post(s) / page(s) should the visitor get points for visiting? (e.g. "page", "single", "home", "hello-world")', 'ega16' ),
			) );

		}

		/**
		 * Create a section for global settings
		 *
		 * @return void
		 */
		protected function add_palette_section() {
			$this->wp_customize->add_section( 'palette_section', array(
				'title' => __( 'EGA 16 Palette Settings' ),
				'description' => __( 'Settings for the 16 color palette' ),
				'priority' => 160,
			) );
		}

		/**
		 * Create a section for global settings
		 *
		 * @return void
		 */
		protected function add_404_section() {
			$this->wp_customize->add_section( '404_section', array(
				'title' => __( 'EGA 16 404 Page Settings' ),
				'description' => __( 'Settings for the 404 not found page' ),
				'priority' => 160,
			) );
		}

		/**
		 * Create settings for the global callout box
		 *
		 * @return void
		 */
		protected function add_404_controls() {
			$this->wp_customize->add_setting( '404_title', array(
				'type' => 'theme_mod',
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$this->wp_customize->add_setting( '404_content', array(
				'type' => 'theme_mod',
				'default' => '',
				'sanitize_callback' => 'wp_kses_post',
			) );

			$this->wp_customize->add_control( '404_title', array(
				'type' => 'text',
				'section' => '404_section',
				'label' => __( 'Title heading for the 404 page', 'ega16' ),
			) );

			$this->wp_customize->add_control( '404_content', array(
				'type' => 'textarea',
				'section' => '404_section',
				'label' => __( 'Custom Content for 404 Page', 'ega16' ),
				'description' => __( 'Any custom content to display on the 404 template (HTML allowed)', 'ega16' ),
			) );

		}

	}

}

EGA16_Customizer::instance();
