<?php

/**
 * Plugin Name: Cookie disclaimer
 * Description: Simple cookie disclaimer
 * Author: Vitaly Nikolaev
 * Version: 0.0.1
 */
class Cookie_Disclaimer {

	const PARENT_SLUG = 'options-general.php';
	const OPTIONS_NAME = 'cookie_disclaimer';

	var $page_slug = 'cookie-disclaimer';
	var $view_cap = 'manage_options';
	var $flushing_enabled = true;
	var $sources = array();

	private $options = array();
	private $defaults = array(
		'cookie_statement'       => "We use cookies to give you the best online experience",
		'site_ownership_default' => "By using our website, you agree to our <a href=\"#\" target=\"_blank\">privacy policy</a>",
		'accept_button'          => "I Accept",
		'base-color'             => '#f7c413'
	);

	/**
	 * Construct the plugin
	 */
	function __construct() {
		add_action( 'init', array( $this, 'action_init' ) );
	}

	/**
	 * Initialize the plugin
	 */
	function action_init() {
		$this->options = wp_parse_args( get_option( self::OPTIONS_NAME ), $this->defaults );

		add_action( 'wp_footer', array( $this, 'show_popup' ) );


		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts_and_styles' ) );
		add_action( 'admin_menu', array( $this, 'action_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );

	}

	public function show_popup() {
		if ( ! isset( $_COOKIE['cookie-disclaimer-accepted'] ) ) {
			$options = $this->options;
			include 'templates/popup.php';
		}

	}

	/**
	 * Add our sub-menu page
	 */
	function action_admin_menu() {
		add_submenu_page( self::PARENT_SLUG, __( 'Cookie disclaimer settings', 'cookie-disclaimer' ), __( 'Cookie disclaimer', 'cookie-disclaimer' ), $this->view_cap, $this->page_slug, array(
			$this,
			'settings_page'
		) );

	}


	public function admin_enqueue_scripts_and_styles() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

	}

	public function settings_page() {

		?>
        <div class="wrap">
            <h2><?php _e( 'Cookie disclaimer settings', 'cookie-disclaimer' ) ?></h2>
            <form method="post" action="options.php">
				<?php
				settings_fields( 'cookie_disclaimer_general' );
				do_settings_sections( 'cookie-disclaimer-setting' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	public function page_init() {
		register_setting(
			'cookie_disclaimer_general',
			self::OPTIONS_NAME,
			array( $this, 'sanitize' )
		);

		add_settings_section(
			'general',
			__( 'General', 'cookie-disclaimer' ),
			array( $this, 'print_section_info' ),
			'cookie-disclaimer-setting'
		);


		add_settings_field(
			'cookie_statement',
			__( 'Cookie statement', 'cookie-disclaimer' ),
			array( $this, 'statement_field' ),
			'cookie-disclaimer-setting',
			'general'
		);

		add_settings_field(
			'site_ownership_default',
			__( 'Site ownership', 'cookie-disclaimer' ),
			array( $this, 'ownership_field' ),
			'cookie-disclaimer-setting',
			'general'
		);

		add_settings_field(
			'accept_button',
			__( 'Accep button text', 'cookie-disclaimer' ),
			array( $this, 'accept_button_field' ),
			'cookie-disclaimer-setting',
			'general'
		);

		add_settings_field(
			'base-color',
			__( 'Base color', 'cookie-disclaimer' ),
			array( $this, 'base_color_field' ),
			'cookie-disclaimer-setting',
			'general'
		);

	}


	public function print_section_info() {

	}

	public function statement_field() {
		printf(
			'<textarea id="cookie_statement" class="large-text" name="%s[cookie_statement]">%s</textarea>
             <p class="description" id="tagline-description">displayed always as the first sentence in the banner.</p>',
			self::OPTIONS_NAME,
			$this->options['cookie_statement']
		);
	}

	public function ownership_field() {
		printf(
			'<textarea id="site_ownership_default" class="large-text" name="%s[site_ownership_default]">%s</textarea>
             <p class="description" id="tagline-description">displayed as the second sentence in the banner</p>',
			self::OPTIONS_NAME,
			$this->options['site_ownership_default']
		);
	}

	public function accept_button_field() {
		printf(
			'<input type="text" id="accept_button"  name="%s[accept_button]" value="%s" />
             <p class="description" id="tagline-description">text on the button always</p>',
			self::OPTIONS_NAME,
			$this->options['accept_button']
		);
	}

	public function base_color_field() {
		printf(
			'<input type="text" id="base-color"  name="%s[base-color]" value="%s" />
             <p class="description" id="tagline-description">used to define base color for border and button</p>
             <script>jQuery(function($) {$( "#base-color" ).wpColorPicker();});</script>',
			self::OPTIONS_NAME,
			$this->options['base-color']
		);
	}


	/**
	 * Sanitize each setting field as needed
	 *
	 * @param $input array Contains all settings fields as array keys
	 *
	 * @return array
	 */
	public function sanitize( $input ) {
		return $input;
	}

}

new Cookie_Disclaimer();

