/*
 * 1. Drag & drop file upload relies on a number of different JavaScript API's, so we'll need to check on all of them.
 *	First, drag & drop events themselves
 * 
 */
function isDragAndDropSupported(){
	var div = document.createElement( 'div' );
	return ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div );
}

// console.log( "isDragAndDropSupported() : " + isDragAndDropSupported()  );

/*
 * 2. Check if FormData interface is support by the browser
 * which is for forming a programmatic object of the selected file(s) so they can be sent to the server via Ajax:
 * 
 */
function isFormDataInterfaceSupported(){
	return 'FormData' in window;
}

// console.log( "isFormDataInterfaceSupported() : " + isFormDataInterfaceSupported()  );

/**
 * 3. Last, we need the DataTransfer object. 
 * This one is a bit tricky because there is no bullet-proof way to detect the availability of the 
 * object before user's first interaction with the drag & drop interface. Not all browsers expose the object.
 * 
 *  The trick here is to check the availability of FileReader API right when the document loads. The idea behind 
 *  this is that browsers that support FileReader support DataTransfer too:
 * 
 */
function isDataTransferObjectSupported(){
	return 'FileReader' in window;
}

// Combining above functions into one single Anonymous function
var isAjaxFileUploadSupported = function(){
	return isDragAndDropSupported() && isFormDataInterfaceSupported() && isDataTransferObjectSupported();
}();


/**
 * 
 * OOPS, making it as a plugin
 * 
 */var sc_form_name, sc_file_name, sc_url;
function SCAjaxFileUpload(){
	var random 				= Math.round( (Math.random() * 100000) );
	sc_form_name 			= "sc_form_file_upload" + random;
	sc_file_name 			= "sc_file" + random;
	sc_error_message 		= "Failed to upload !";
	sc_success_message		= "Uploaded successfully !"
	sc_uploading_message	= "Uploading is in progress...Please be patient !";
	
	var init = function(){
		
	}
}



/**
 * With this working feature detection, now we can let the users know they can drag & drop their files into our form (or not). 
 * We can style the form by adding a class to it in the case of support:
 * 
 */
if( isAjaxFileUploadSupported ){
	
	var form = $( '.box' );
	form.addClass( 'ajax-upload-supported' );
	
	var droppedFiles = false;
	
	form.on( 'drag dragstart dragenter dragover dragend dragleave drop', function( e ){
		e.preventDefault();
		e.stopPropagation();
		/**
		 * e.preventDefault() and e.stopPropagation() prevent any unwanted behaviors for the assigned events across browsers.
		 *
		 */
	})
	.on( 'dragover dragenter', function(){
		form.addClass( 'dragged-over' );
	})
	.on( 'dragleave dragend drop', function(){
		form.removeClass( 'dragged-over' );
	})
	.on( 'drop', function( e ) {
	    droppedFiles = e.originalEvent.dataTransfer.files;
	    console.log( droppedFiles );
	    /**
	     * 
	     * e.originalEvent.dataTransfer.files returns the list of files that were dropped
	     * 
	     */
	    
	    form.children( 'div.box_error' ).removeClass( 'sc-show-element' );
	    form.children( 'div.box_success' ).removeClass( 'sc-show-element' );
    	
	    if( ! isFileTypeValid( droppedFiles[ 0 ] ) ){
	    	//showNotification( "error", "bottomRight", "Not a valid file type !", 5000, 0 );
	    	
	    	form.children( 'div.box_error' ).addClass( 'sc-show-element' );
	    	form.children( 'div.box_error' ).children( 'p.error_message' ).text( "Invalid file type !" );
	    	form.removeClass( 'is-uploading' );
	    	
	    	return;
	    }
	    if( ! isFileSizeValid( droppedFiles[ 0 ] ) ){
	    	//showNotification( "error", "bottomRight", "File Size out of limit !", 5000, 0 );
	    	
	    	form.children( 'div.box_error' ).addClass( 'sc-show-element' );
	    	form.children( 'div.box_error' ).children( 'p.error_message' ).text( "File size out of limits !" );
	    	form.removeClass( 'is-uploading' );
	    	
	    	return;
	    }
	    
	    if( form.hasClass( 'is-uploading' ) ) {
	    	alert( 'Please wait for the current upload to finish !' );
	    	return false;
	    } // To protect another image to drag and drop while current one is uploading
	    
	    
	    // If everything is valid, then upload the file, show uploading_box
	    form.addClass( 'is-uploading' );
	    
	    
	    // Show Uploading Message
	    form.children( 'div.box_uploading' ).addClass( 'sc-show-element' );
    	form.children( 'div.box_uploading' ).children( 'p.uploading_message' ).text( "Uploading is in process...Please be patient !" );
    	form.children( 'div.box_input' ).removeClass( 'sc-show-element' );
    	
    	
    	// Upload the File
    	uploadTheFile( form, droppedFiles[ 0 ] );
	    
	});
	
	
	
}
else{
	// Write css codes for when ajax-upload not supported
	//..
	//..
	//..
	
}

$( '.box_file+label' ).on( 'click', function(){
	$( '#login_page_logo' ).click();
});


function isFileTypeValid( files ){
	var valid_types = [ "image/png", "image/jpeg", "image/gif", "image/jpeg" ];
	return ( $.inArray( files.type, valid_types ) > -1 );
}

function isFileSizeValid( files ){
	var size_limit = 100000; // 300KB
	return files.size <= size_limit;
}

function uploadTheFile( form, files ){
	
	// var ajaxData = new FormData( $( '#form_upload_login_page_logo' ).get( 0 ) );
	console.log(  $( '#form_upload_login_page_logo' ).children( '.what_do_you_want' ).val() );
	
	var data = new FormData();
	data.append( 'login_page_logo', files );
	data.append( 'what_do_you_want', $( '#form_upload_login_page_logo' ).find( '.what_do_you_want' ).val() );
	/*data.append( 'op_name', $( '#op_name' ).val() );
	data.append( 'op_email', $( '#op_email' ).val() );
	data.append( 'op_applying_for', $( '#op_applying_for' ).val() );
	data.append( 'g-recaptcha-response', $( '#g-recaptcha-response' ).val() );*/
	
	var xhr = new XMLHttpRequest();
	
	// Create a new XMLHttpRequest
	xhr.open( 'POST', 'webservice.php', true );
	 
	 // File Location, this is where the data will be posted
	 xhr.send( data );
	 xhr.onload = function () {                  
	 	 if ( xhr.status === 200 ) {
	 		console.log( xhr.responseText );
	 		var jSon = $.parseJSON( xhr.responseText );
	 		
	 		$.each( jSon, function(){
	 			if( this[ 'type' ] == "error" ){
	 				alert( this[ 'info' ] );
	 				//grecaptcha.reset();
	 				return;
	 			}
	 			if( this[ 'type' ] == "success" ){
	 				//alert( this[ 'info' ] );
	 				//$( '.remodal-close' ).click();
	 				form.removeClass( 'is-uploading' );
	 				form.children( 'div.box_uploading' ).removeClass( 'sc-show-element' );
	 				
	 				form.children( 'div.box_success' ).addClass( 'sc-show-element' );
	 		    	form.children( 'div.box_success' ).children( 'p.success_message' ).text( this[ 'info' ] );
	 		    	form.children( 'div.box_input' ).addClass( 'sc-show-element' );
	 		    	
	 		    	var path = "images/logo/horizontal-cms-logo.png";
	 		    	$( '.img_login_page_logo' ).attr( 'src', path + "?"+(new Date()).getTime() );
	 				
	 				return;
	 			}
	 		});
		 }
	 	 else{
	 		 alert( 'Oops ! Something went wrong...' );
	 	 }
	 }
	
	/*$.ajax({
	    url: 'webservice.php?what_do_you_want=upload_logo_image',
	    type: 'POST',
	    data: ajaxData,
	    dataType: 'json',
	    cache: false,
	    contentType: false,
	    processData: false,
	    complete: function() {
	      //$form.removeClass('is-uploading');
	    },
	    success: function(data) {
	    	console.log( data );
	      $form.addClass( data.success == true ? 'is-success' : 'is-error' );
	      if (!data.success) $errorMsg.text(data.error);
	    },
	    error: function() {
	      // Log the error, show an alert, whatever works for you
	    }
	  });*/
	
}
