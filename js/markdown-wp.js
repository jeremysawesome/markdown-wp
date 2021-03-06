( function( marked, $, document ) {
	var $markdown_editor_container,
		$markdown_editor,
		$markdown_preview,
		$editor_wrap_container,
		$wp_editor;

	function initialize() {
		$markdown_editor_container = $( document.getElementById( 'awesome-markdown-wp' ) );
		$markdown_editor = $markdown_editor_container.find( '.wp-editor-area' );
		$markdown_preview = $markdown_editor_container.find( '.awesome-markdown-wp_preview' );
		$editor_wrap_container = $markdown_editor_container.closest( '.wp-editor-wrap' );

		// get the wp_editor, typically the id is content
		$wp_editor = $( document.getElementById( 'content' ) );
		if( ! $wp_editor.length ) {
			// if we don't have editor, then get it by traversing the DOM
			$wp_editor = editor_wrap_container.find( '.wp-editor-container:not( #awesome-markdown-wp ) textarea' );
		}

		switch_to_markdown_editor();

		// set the default WP editor to be readonly, we aren't doing two way Markdown conversion at this point
		$wp_editor.attr( 'readonly', 'readonly' );

		initialize_editor_tabs();
		$markdown_editor.on( 'input', handle_markdown_editor_change );
	}

	function handle_markdown_editor_change() {
		let parsed_html = marked( $markdown_editor.val() );

		$markdown_preview.html( parsed_html );
		$wp_editor.text( parsed_html );
	}

	function initialize_editor_tabs() {
		$( document.getElementById( 'awesome-markdown-wp_markdown' ) ).on( 'click', switch_to_markdown_editor );
		$( document.getElementById( 'awesome-markdown-wp_html' ) ).on( 'click', switch_to_html_editor );
	}

	function switch_to_markdown_editor() {
		$editor_wrap_container.addClass( 'markdown-active' )
			.removeClass( 'html-active' );
	}

	function switch_to_html_editor() {
		$editor_wrap_container.addClass( 'html-active' )
			.removeClass( 'markdown-active' );
	}

	$( document ).ready( initialize );
} )( marked, jQuery, document );
