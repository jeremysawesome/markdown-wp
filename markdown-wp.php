<?php
/**
 * Plugin Name: Markdown for WordPress
 * Plugin URI: https://github.com/jeremysawesome/markdown-wp
 * Description: Adds a Markdown editor and preview pane when writing posts in WordPress.
 * Text Domain: awesome-markdown-wp
 * Version: 0.0.1
 * Author: Jeremy Smith
 * Author URI: http://jeremysawesome.com
 */

// recommended by https://codex.wordpress.org/Writing_a_Plugin
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

// do not redefine the class if it already exists
if( ! class_exists( 'Awesome_Markdown_WP' ) ) :

/**
 * Adds a markdown editor and preview pane when writing posts in WordPress.
 *
 * Allows posts to be written and editing using Markdown. Markdown inserted into this editor is parsed and displayed
 * in a preview section. Utilizes GitHub flavored Markdown (see: https://github.github.com/gfm/).
 *
 * @since 0.0.1
 */
class Awesome_Markdown_WP {

	public function __construct() {
		$this->init();
	}

	/**
	 * Adds actions and filters.
	 *
	 * Registers the actions and filters that the Awesome_Markdown_WP plugin uses.
	 *
	 * @since 0.0.1
	 * @access private
	 */
	private function init() {

		// TODO: Initialize language translations and generate POT files.

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_filter( 'wp_editor_settings', array( $this, 'filter_wp_editor_settings' ), 10, 2 );
			add_filter( 'the_editor', array( $this, 'expand_the_editor' ), 10, 1 );
		}
	}

	/**
	 * Enqueue the plugin styles.
	 *
	 * Registers the plugin styles and queues them up for output.
	 *
	 * @since 0.0.1
	 * @access private
	 *
	 * {@see 'wp_register_style'}
	 * {@see 'wp_enqueue_style'}
	 */
	private function enqueue_admin_css() {
		wp_register_style( 'awesome-markdown-wp_css',
			plugins_url( 'css/markdown-wp.css', __FILE__ ),
			array(),
			'0.0.1'
		);

		wp_enqueue_style( 'awesome-markdown-wp_css' );
	}

	/**
	 * Enqueue the plugin JavaScript.
	 *
	 * Registers the plugin JavaScript files and queues them up for output.
	 *
	 * @since 0.0.1
	 * @access private
	 */
	private function enqueue_admin_js() {

		// see the "marked" library: https://github.com/chjj/marked
		wp_register_script( 'awesome-markdown-wp_marked',
			plugins_url( 'js/lib/marked-0.3.6.min.js', __FILE__ )
		);

		wp_register_script( 'awesome-markdown-wp_js',
			plugins_url( 'js/markdown-wp.js', __FILE__ ),
			array( 'awesome-markdown-wp_marked' ),
			'0.0.1'
		);

		wp_enqueue_script( 'awesome-markdown-wp_js' );
	}

	/**
	 * Builds out the HTML for the editor buttons.
	 *
	 * Creates two new buttons to be used with the editor. The "Markdown" button and the "HTML" button.
	 * These two buttons are used to toggle between the two kinds of editors. The Markdown editor and the HTML editor.
	 *
	 * @since 0.0.1
	 * @access private
	 *
	 * {@see 'esc_html'}
	 *
	 * @return string The html necessary to display the new editor buttons.
	 */
	private function build_editor_buttons() {

		// nest the buttons inside the `wp-editor-tools` and `wp-editor-tabs` divs to appear more like the default editor
		$buttons = [
			'<div class="wp-editor-tools hide-if-no-js"><div class="wp-editor-tabs">',
				'<button type="button" id="awesome-markdown-wp_markdown" class="wp-switch-editor switch-markdown">',
					esc_html( __( 'Markdown', 'awesome-markdown-wp' ) ),
				'</button><button type="button" id="awesome-markdown-wp_html" class="wp-switch-editor switch-html">',
					esc_html( __( 'HTML', 'awesome-markdown-wp' ) ),
				'</button>',
			'</div></div>'
		];

		return implode( "", $buttons );
	}

	/**
	 * Builds out the HTML for the Markdown editor.
	 *
	 * The Markdown editor consists of two sections, a preview section and a textarea. The preview pane is used to show
	 * the rendered result of the inserted markdown.
	 *
	 * @since 0.0.1
	 * @access private
	 */
	private function build_markdown_editor() {

		// TODO: Load in any previously saved Markdown to display in the text area

		// the markdown editor will consist of two pieces. A preview pane which shows the rendered HTML and a text area
		$editor = '<div id="awesome-markdown-wp" class="wp-editor-container">'.
			'<div class="awesome-markdown-wp_preview"></div>'.
			'<textarea class="wp-editor-area"></textarea></div>';

		return $editor;
	}

	/**
	 * Register and enqueue the scripts used by the plugin.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @see enqueue_admin_js
	 *
	 * @param string $hook The current admin page as specified by the `admin_enqueue_scripts` action.
	 */
	public function enqueue_scripts( $hook ) {
		$this->enqueue_admin_css();
		$this->enqueue_admin_js();
	}

	/**
	 * Expands the WP Editor.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Editor's HTML markup.
	 */
	public function expand_the_editor( $output ){
		// add the expanded editor buttons above the editor
		$output = $this->build_editor_buttons() . $output;

		// add the markdown editor inside the wp-editor-container
		$output .= $this->build_markdown_editor();

		return $output;
	}

	/**
	 * Filters the WP Editor settings.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param array $settings The array of WP Editor settings to be filtered.
	 * @param string $editor_id ID for the current editor instance.
	 *
	 * @return array The filtered WP Editor settings.
	 */
	public function filter_wp_editor_settings( $settings, $editor_id ) {
		// disable TinyMCE
		$settings['tinymce'] = false;

		// disable media buttons - this takes care of also disabling the built in editor tab container.
		$settings['media_buttons'] = false;

		return $settings;
	}

}

// for now simply new up a new Awesome_Markdown_WP object, _maybe_ convert to Singleton later
new Awesome_Markdown_WP();

endif; // end the `! class_exists( 'Awesome_Markdown_WP' )` test
