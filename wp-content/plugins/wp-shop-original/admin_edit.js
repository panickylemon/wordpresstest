(function($) {
	// we create a copy of the WP inline edit post function
	var $wp_inline_edit = inlineEditPost.edit;
	// and then we overwrite the function with our own code
	inlineEditPost.edit = function( id ) {
		// "call" the original WP edit function
		// we don't want to leave WordPress hanging
		$wp_inline_edit.apply( this, arguments );

		// now we take care of our business

		// get the post ID
		var $post_id = 0;
		if ( typeof( id ) == 'object' )
			$post_id = parseInt( this.getId( id ) );

		if ( $post_id > 0 ) {
			// define the edit row
			var $edit_row = $( '#edit-' + $post_id );
			var $post_row = $( '#post-' + $post_id );

			// get the data
			var $cost = $( '.column-cost', $post_row ).html();
			var $sklad = $( '.column-sklad', $post_row ).html();
		
			// populate the data
			$( ':input[name="cost"]', $edit_row ).val( $cost );
			$( ':input[name="sklad"]', $edit_row ).val( $sklad );
		}
	};
	
	$( '#bulk_edit' ).on( 'click', function() {

	   // define the bulk edit row
	   var $bulk_row = $( '#bulk-edit' );

	   // get the selected post ids that are being edited
	   var $post_ids = new Array();
	   $bulk_row.find( '#bulk-titles' ).children().each( function() {
		  $post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
	   });

	   // get the release date
	   var $cost = $bulk_row.find( 'input[name="cost"]' ).val();
	   var $sklad = $bulk_row.find( 'input[name="sklad"]' ).val();

	   // save the data
	   $.ajax({
		  url: ajaxurl, // this is a variable that WordPress has already defined for us
		  type: 'POST',
		  async: false,
		  cache: false,
		  data: {
			action: 'my_column_save_bulk_edit', // this is the name of our WP AJAX function that we'll set up next
			post_ids: $post_ids, // and these are the 2 parameters we're passing to our function
			cost: $cost,
			sklad: $sklad
		  }
	   });

	});

})(jQuery); 



