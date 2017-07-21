( function( marked, $ ) {
	var $markdown_editor_container,
		$markdown_editor,
		$markdown_preview,
		$wp_editor;

	function initialize() {
		$markdown_editor_container = $( document.getElementById( 'awesome-markdown-wp' ) );
		$markdown_editor = $markdown_editor_container.find( '.wp-editor-area' );
		$markdown_preview = $markdown_editor_container.find( '.awesome-markdown-wp_preview' );

		// get the wp_editor, typically the id is content
		$wp_editor = $( document.getElementById( 'content' ) );
		if( ! $wp_editor.length ) {
			// if we don't have editor, then get it by traversing the DOM
			$wp_editor = $markdown_editor_container
				.closest( '.wp-editor-wrap' )
				.find( '.wp-editor-container:not( #awesome-markdown-wp ) textarea' );
		}
	}

	$( document ).ready( initialize );
} )( marked, jQuery );
