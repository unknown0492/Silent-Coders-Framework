<?php
	
	function create_page_group(){
		checkPrivilegeForFunction( __FUNCTION__ );
		
		$page_group_sequence 	= $_REQUEST[ 'page_group_sequence' ];
		$page_group_name 		= $_REQUEST[ 'page_group_name' ];
		$icon 					= $_REQUEST[ 'icon' ];
		
		// Do the validation Here
		
		// emptiness validations
		validateEmptyString( $page_group_name, __FUNCTION__, 'Page Group Name is required. Please enter a valid name and try again !' );
		validate( $page_group_name, __FUNCTION__, "/^[a-zA-Z0-9 ]*$/", 'Only use lowercase, uppercase alphabets, digits and white spaces !' );
		/*if ( empty( $page_group_name ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Group Name is required. Please enter a valid name and try again !" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z0-9 ]*$/", $page_group_name ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only use lowercase, uppercase alphabets, digits and white spaces !" );
				return;
			}
		}*/
		
		validate( $icon, __FUNCTION__, "/^[a-zA-Z_ -]*$/", 'Only Alphabets, white spaces, underscore and hyphen are allowed' );
		/*if( !preg_match( "/^[a-zA-Z_ -]*$/", $icon ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets, white spaces, underscore and hyphen are allowed" );
			return;
		}*/
		 /* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		 return; */
		
		$page_group_sequence 	= htmlentities( $_REQUEST[ 'page_group_sequence' ] );
		$page_group_name 		= htmlentities( $_REQUEST[ 'page_group_name' ] );
		$icon 					= htmlentities( $_REQUEST[ 'icon' ] );
		
		$sql = "SELECT page_group_name FROM page_group WHERE page_group_name = '$page_group_name'";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) > 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Group with the name $page_group_name already exist. Please try again with another name !" );
			return;
		}
		
		$sql  = "INSERT into page_group( `page_group_name`, `page_group_sequence`, `icon` ) VALUES( '$page_group_name', $page_group_sequence, '$icon' )";
		$rows = insertQuery( $sql );
		if( $rows > 0 ){
			echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Page Group created successfully" );
			return;
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred while trying to create page group" );
		return;
	}
	
	function create_page(){
		checkPrivilegeForFunction( __FUNCTION__ );
	
		$page_group_id 		= $_REQUEST[ 'page_group_id' ];
		$page_name 			= $_REQUEST[ 'page_name' ];
		$page_sequence 		= $_REQUEST[ 'page_sequence' ];
		$icon 				= $_REQUEST[ 'icon' ];
		$visible			= $_REQUEST[ 'visible' ];
		$page_title 		= $_REQUEST[ 'page_title' ];
		$functionality_id	= $_REQUEST[ 'functionality_id' ];
		$description		= $_REQUEST[ 'description' ];
		$plugin_name		= $_REQUEST[ 'plugin_name' ];
		$tags				= $_REQUEST[ 'tags' ];
		$image				= $_REQUEST[ 'image' ];
		$content			= $_REQUEST[ 'content' ];
		
		// Do the validation Here
		
		// checking for emptiness
		validateEmptyDigitString( $page_group_id, __FUNCTION__, 'Page Group ID is missing. Refresh the page and try again !' );
		/*if( trim( $page_group_id ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Group ID is missing. Refresh the page and try again !" );
			return;
		}*/
		validateEmptyString( $page_name, __FUNCTION__, 'Page Name is required !' );
		validate( $icon, __FUNCTION__, "/^[a-z_]*$/", 'Only use lowercase and underscores. Use the sample format `some_name_page`' );
		/*if( empty( $page_name ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Name is required !" );
			return;
		}
		else{
			if( !preg_match( "/^[a-z_]*$/" , $page_name ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only use lowercase and underscores. Use the sample format `some_name_page`" );
				return;
			}
		}*/
		
		if ( trim( $page_sequence ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Sequence is required. Please select and try again !" );
			return;
		}
		
		if( !preg_match( "/^[a-zA-Z_ -]*$/", $icon ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets, white spaces, underscore and hypen are allowed" );
			return;
		}
		
		if ( trim( $visible ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Visiblity is required !" );
			return;
		}
		
		if ( empty( $page_title ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Title is required !" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z_ !@#$%*()\[\]?&-,\/]*$/", $page_title ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Please remove some special characters from the `Page Title` and try again !" );
				return;
			}
		}
		
		if ( $functionality_id == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Functionality is required !" );
			return;
		}
		
		if( !preg_match( "/^[a-zA-Z0-9 ,.#$&*\[\]]*$/", $description ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Use only from lowercase, uppercase alphabets, digits, white spaces and the special characters ,.#$&*[]" );
			return;
		}
		
		if( !preg_match( "/^[a-zA-Z0-9 ,]*$/" , $tags )){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Special Characters not allowed except comma !" );
			return;
		}
		
		//image URL validation
		if( trim( $image ) != "" ){
			if( !preg_match( '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS', $image )){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Please enter Valid URL for the image" );
				return;
			}
		}
		
		//Content validation
		if( !preg_match( "/^[a-zA-Z0-9 ,.#$&*\[\]]*$/" , $content )){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Use only from lowercase, uppercase alphabets, digits, white spaces and the special characters ,.#$&*[]" );
			return;
		}

		//validate dropdown for Plugin
		validateEmptyDigitString( $plugin_name, __FUNCTION__, 'Please select Plugin !' );
		
		/* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		return; */
		
		/* if( ( strlen( $page_name ) - strrpos( $page_name, "_page" ) ) != 5 ){
			$page_name .= "_page";
		} */
		/* echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "$page_name" );
		return; */
		
		// Check if the page_name already exist
		$sql = "SELECT page_name FROM pages WHERE page_name = '$page_name'";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) > 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "A Page with the name \"$page_name\" already exist. Please try another name !" );
			return;
		}
		
		/* // Check if the functionality_name already exist
		$sql = "SELECT * FROM functionalities WHERE functionality_name = '$functionality_name'";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) > 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "A functionality with the entered name already exist. Please try another name !" );
			return;
		} */
		
		$sql  = "INSERT into pages( `page_name`, `page_sequence`, `icon`, `visible`, `page_title`, `functionality_id`, `description`, `tags`, `image`, `content`, `plugin_name` ) VALUES( '$page_name', '$page_sequence', '$icon', '$visible', '$page_title', '$functionality_id', '$description' , '$tags' , '$image' , '$content' , '$plugin_name' )";
		$rows = insertQuery( $sql );
		if( $rows > 0 ){
			// get page_id
			$sql 			= "SELECT page_id FROM pages WHERE page_name = '$page_name'";
			$result_set 	= selectQuery( $sql );
			$val 			= mysqli_fetch_object( $result_set );
			$page_id 		= $val->page_id;
			
			// insert into pages_groups
			$sql  = "INSERT into pages_groups( `group_id`, `page_id`, `page_sequence` ) VALUES( '$page_group_id', '$page_id', $page_sequence )";
			$rows = insertQuery( $sql );
			if( $rows > 0 ){
				echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Page created and mapped to the Functionality successfully" );
				return;
			}
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Failed to create page !" );
		return;
	}
	
	function delete_page(){
		checkPrivilegeForFunction( __FUNCTION__ );
		
		$page_id = @$_REQUEST[ 'page_id' ];
		
		if( trim( $page_id ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Invalid Page ID !" );
			return;
		}
		
		$sql = "DELETE FROM pages WHERE page_id = $page_id";
		$rows = deleteQuery( $sql );
		
		if( $rows > 0 ){
			echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Page deleted successfully" );
			return;
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
		return;
	}
	
	function update_page_group(){
		checkPrivilegeForFunction( __FUNCTION__ );
		
		$page_group_id 			= $_REQUEST[ 'page_group_id' ];
		$page_group_name 		= $_REQUEST[ 'page_group_name' ];
		$page_group_sequence 	= $_REQUEST[ 'page_group_sequence' ];
		$icon 					= $_REQUEST[ 'page_group_icon' ];
		
		// Do the validation Here
		// emptiness validations
		if ( empty( $page_group_name ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Group Name is required. Please enter a valid name and try again !" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z0-9 ]*$/", $page_group_name ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only use lowercase, uppercase alphabets, digits and white spaces !" );
				return;
			}
		}
		
		if( !preg_match( "/^[a-zA-Z_ -]*$/", $icon ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets, white spaces, underscore and hyphen are allowed" );
			return;
		}
		
		/* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		return; */
		
		$page_group_sequence 	= htmlentities( $_REQUEST[ 'page_group_sequence' ] );
		$page_group_name 		= htmlentities( $_REQUEST[ 'page_group_name' ] );
		$icon 					= htmlentities( $_REQUEST[ 'page_group_icon' ] );
		/* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		return; */
		
		$sql = "SELECT page_group_id FROM page_group WHERE page_group_id = $page_group_id";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) <= 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Invalid Page Group ID" );
			return;
		}
		
		$sql  = "UPDATE page_group SET page_group_name = '$page_group_name', page_group_sequence = $page_group_sequence, icon = '$icon' WHERE page_group_id = $page_group_id";
		$rows = updateQuery( $sql );
		if( $rows > 0 ){
			echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Page Group information updated successfully" );
			return;
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
		return;
	}
	
	function update_page(){
		checkPrivilegeForFunction( __FUNCTION__ );
		
		$page_group_id 		= $_REQUEST[ 'page_group_id' ];
		$page_id 			= $_REQUEST[ 'page_id' ];
		$page_name 			= $_REQUEST[ 'page_name' ];
		$page_sequence 		= $_REQUEST[ 'page_sequence' ];
		$icon 				= $_REQUEST[ 'icon' ];
		$visible			= $_REQUEST[ 'visible' ];
		$page_title 		= $_REQUEST[ 'page_title' ];
		$functionality_id	= $_REQUEST[ 'functionality_id' ];
		$description		= $_REQUEST[ 'description' ];
		$plugin_name		= $_REQUEST[ 'plugin_name' ];
		$tags				= $_REQUEST[ 'tags' ];
		$image				= $_REQUEST[ 'image' ];
		$content			= $_REQUEST[ 'content' ];
		
		// Do the validation Here
	// checking for emptiness
		if( trim( $page_group_id ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Group ID is missing. Refresh the page and try again !" );
			return;
		}
		
		if( empty( $page_name ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Name is required !" );
			return;
		}
		else{
			if( !preg_match( "/^[a-z_]*$/" , $page_name ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only use lowercase and underscores. Use the sample format `some_name_page`" );
				return;
			}
		}
		
		if ( trim( $page_sequence ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Sequence is required. Please select and try again !" );
			return;
		}
		
		if( !preg_match( "/^[a-zA-Z_ -]*$/", $icon ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets, whitespaces, underscore and hyphen are allowed" );
			return;
		}
		
		if ( trim( $visible ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Visiblity is required !" );
			return;
		}
		
		if ( empty( $page_title ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Page Title is required !" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z_ !@#$%*()\]\[?&-,\/]*$/", $page_title ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Please remove some special characters from the `Page Title` and try again !" );
				return;
			}
		}
		
		if ( trim( $functionality_id ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Functionality is required !" );
			return;
		}
		
		if( !preg_match( "/^[a-zA-Z0-9 ,.#$&*\[\]]*$/", $description ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Use only from lowercase, uppercase alphabets, digits, white spaces and the special characters ,.#$&*[]" );
			return;
		}
		
		if( !preg_match( "/^[a-zA-Z0-9 ,]*$/" , $tags )){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Special Characters not allowed except comma" );
			return;
		}
		
		//image URL validation
		if( trim( $image ) != "" ){
			if( !preg_match( '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS', $image )){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Please enter Valid URL for the image !" );
				return;
			}
		}
		
		//Content validation
		if( !preg_match( "/^[a-zA-Z0-9 ,.#$&*\[\]]*$/" , $content )){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Use only from lowercase, uppercase alphabets, digits, white spaces and the special characters ,.#$&*[]" );
			return;
		}

		//validate dropdown for Plugin
		validateEmptyDigitString( $plugin_name, __FUNCTION__, 'Please select Plugin !' );
		
		/* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		return; */
		
		
		// Check if Page_id is valid
		$sql = "SELECT page_id FROM pages WHERE page_id = $page_id";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) <= 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Invalid Page ID" );
			return;
		}
		
		$sql	= "UPDATE pages SET page_name = '$page_name', page_sequence='$page_sequence', icon='$icon', visible='$visible', page_title='$page_title', functionality_id='$functionality_id', description = '$description', tags='$tags', image='$image', content='$content', plugin_name = '$plugin_name' WHERE page_id = $page_id";
		$rows	= updateQuery( $sql );
		//echo $sql;
		if( $rows > 0 ){
			// Move the page_id to new page_group_id if it has changed
			$sql = "DELETE FROM pages_groups WHERE page_id = $page_id";
			deleteQuery( $sql );
			
			$sql  = "INSERT INTO pages_groups( `group_id`, `page_id`, `page_sequence` ) VALUES( $page_group_id, $page_id, $page_sequence )";
			$rows = insertQuery( $sql );
			if( $rows > 0 ){
				echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Page information updated !" );
				return;
			}
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Failed to update page group !" );
			return;
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
		return;
	}
	
	
	function delete_page_group(){
		checkPrivilegeForFunction( __FUNCTION__ );
	
		$page_group_id = @$_REQUEST[ 'page_group_id' ];
		
		if( $page_group_id == 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Default Page Group cannot be deleted !" );
			return;
		}
		
		if( trim( $page_group_id ) == "" ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Invalid Page Group ID !" );
			return;
		}
	
		$sql 		= "SELECT page_group_id FROM page_group WHERE page_group_id = $page_group_id";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) <= 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Invalid Page Group ID" );
			return;
		}
	
		// Move the page from the group to be deleted to the Default Group (id=0)
		$sql = "UPDATE pages_groups SET group_id = 0 WHERE group_id = $page_group_id";
		$rows = updateQuery( $sql );
		if( $rows > 0 ){
			$sql = "DELETE FROM page_group WHERE page_group_id = $page_group_id";
			$rows = deleteQuery( $sql );
			if( $rows > 0 ){
				echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Page Group deleted successfully" );
				return;
			}
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Deleting page group failed. The child pages have been moved to the Default Page Group" );
			return;
		}
	
	
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
	}
	
?>