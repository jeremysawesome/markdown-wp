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

	}

}

// for now simply new up a new Awesome_Markdown_WP object, _maybe_ convert to Singleton later
new Awesome_Markdown_WP();

endif; // end the `! class_exists( 'Awesome_Markdown_WP' )` test
