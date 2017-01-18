<?php
	
	function update_site_config(){
		checkPrivilegeForFunction( __FUNCTION__ );
		$id					= $_REQUEST[ 'id' ];
		$site_name 			= $_REQUEST[ 'site_name' ];
		$site_tagline 		= $_REQUEST[ 'site_tagline' ];
		$domain_name		= $_REQUEST[ 'domain_name' ];
		$protocol			= $_REQUEST[ 'protocol' ];
		//$site_logo_image	= $_REQUEST[ 'site_logo_image' ];
		//print_r($site_logo_image);
		
		// Do the validation Here
		//site name validations
		if (empty($site_name)){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Site Name is required. Please Fill and try again" );
			return;
		}
		else{
			if(!preg_match( "/^[a-zA-Z0-9.\s]*$/",$site_name)){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets, Numbers and Spaces are allowed" );
				return;
			}
		}
		
		//site tagline validations
		if (empty($site_tagline)){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Site Tagline is required. Please Fill and try again" );
			return;
		}
		else{
			if(!preg_match( "/^[a-zA-Z0-9\s]*$/",$site_tagline)){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets, Numbers and Spaces are allowed" );
				return;
			}
		}
		
		//Domain Name validations
		if (empty($domain_name)){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Domain Name is required. Please Fill and try again" );
			return;
		}
		else{
			if(!preg_match( "/^[a-zA-Z0-9._\/\s]*$/",$domain_name)){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only Alphabets , Numbers and ./_ are allowed" );
				return;
			}
		} 
		
		//Protocol validations
		if (empty($protocol)){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Protocol is required. Please Select one and try again" );
			return;
		}
		
		 /* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		 return; */
		 
		 $sql  = "UPDATE site_config SET site_name = '$site_name', site_tagline = '$site_tagline' , domain_name = '$domain_name'  , protocol = '$protocol'  WHERE id = $id ";
		 $rows = updateQuery( $sql );
		 if( $rows > 0 ){
		 	echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Site Config information updated successfully" );
		 	return;
		 }
		 echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
		 return;	
	}
	
	//create hooks function
	function create_hooks_page(){
		checkPrivilegeForFunction( __FUNCTION__ );
		
		$hook_name 					= $_REQUEST[ 'hook_name' ];
		$hook_description 			= $_REQUEST[ 'hook_description' ];
		$hook_content 				= $_REQUEST[ 'hook_content' ];
		$hook_content_meta			= $_REQUEST[ 'hook_content_meta' ];
	
		// Do the validation Here
		//Hook name validation
		if (empty($hook_name)){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Name is required. Please Fill and try again" );
			return;
		}
		else{
			if( !preg_match( "/^[a-z_]*$/" , $hook_name ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only lowercase alphabets and underscores are allowed" );
				return;
			}
		}
	
		//Hook Description validation
		if( empty($hook_description) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Description is required. Please Fill and try again" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z0-9 \/&$#<>]*$/" , $hook_description ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only lowercase alphabets and underscores are allowed for Hook Description" );
				return;
			}
		}
	
		//Hook Content validation
		if ( empty($hook_content) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Content is required. Please Fill and try again" );
			return;
		}
		else{
			/* if( !preg_match( "/^[a-z_\s]*$/" ,$hook_content ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only lowercase alphabets and underscores are allowed" );
				return;
			} */
		}
	
		//Hook Content meta validation
		if ( empty($hook_content_meta) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Content Meta is required. Please Fill and try again" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z0-9\s]*$/" , $hook_content_meta )){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only alphabets, numbers and spaces are allowed" );
				return;
			}
		}
		
		/* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
			return; */
	
		// Check if the hook_name already exist
		$sql = "SELECT * FROM hooks WHERE hook_name = '$hook_name'";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) > 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "A Hook with the entered name already exist. Please try another name !" );
			return;
		}
		
		$sql  = "INSERT into hooks( `hook_name`, `hook_description`, `hook_content`, `hook_content_meta` ) VALUES( '$hook_name', '$hook_description', '$hook_content', '$hook_content_meta' )";
		$rows = insertQuery( $sql );
		if( $rows > 0 ){
			echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Hook Created Successfully !" );
			return; 
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Failed to create Hook !" );
		return;
	}
	
	//delete function for hooks
	function delete_hook(){
		checkPrivilegeForFunction( __FUNCTION__ );
	 	
		$id = $_REQUEST[ 'id' ];
		
		$sql = "DELETE FROM hooks WHERE id = $id ";
		$rows = deleteQuery( $sql );
		
		if( $rows > 0 ){
			echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Hook deleted successfully" );
			return;
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
		return;
	}
	
	//edit function for hooks
	function update_hook(){
		checkPrivilegeForFunction( __FUNCTION__ );
		$id							= $_REQUEST[ 'id' ];	
		$hook_name 					= $_REQUEST[ 'hook_name' ];
		$hook_description 			= $_REQUEST[ 'hook_description' ];
		$hook_content 				= $_REQUEST[ 'hook_content' ];
		$hook_content_meta			= $_REQUEST[ 'hook_content_meta' ];
		
		// Do the validation here
		//Hook name validation
		if (empty($hook_name)){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Name is required. Please Fill and try again" );
			return;
		}
		else{
			if( !preg_match( "/^[a-z_]*$/" , $hook_name ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only lowercase alphabets and underscores are allowed for Hook Name" );
				return;
			}
		}
		
		//Hook Description validation
		if( empty($hook_description) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Description is required. Please Fill and try again" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z0-9 \/&$#<>]*$/" , $hook_description ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only lowercase alphabets and underscores are allowed for Hook Description" );
				return;
			}
		}
		
		//Hook Content validation
		if ( empty($hook_content) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Content is required. Please Fill and try again" );
			return;
		}
		else{
			//if( !preg_match( "/^[a-zA-Z0-9 \/\"\'=&$#<>]*$/" ,$hook_content ) ){
				//echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only lowercase alphabets and underscores are allowed for Hook Content" );
// 				/return;
			//}
		}
		
		//Hook Content meta validation
		if ( empty($hook_content_meta) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Hook Content Meta is required. Please Fill and try again" );
			return;
		}
		else{
			if( !preg_match( "/^[a-zA-Z0-9\s]*$/" , $hook_content_meta )){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Only alphabets, numbers and spaces are allowed" );
				return;
			}
		}
		
		/* echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "validated" );
		 return; */
		
		// Check if id is valid
		$sql = "SELECT id FROM hooks WHERE id = $id";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) <= 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Invalid ID" );
			return;
		}
		
		$sql	= "UPDATE hooks SET hook_name = '$hook_name', hook_description = '$hook_description' , hook_content='$hook_content' , hook_content_meta='$hook_content_meta' WHERE id = $id";
		$rows	= updateQuery( $sql );
		if( $rows > 0 ){
			echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, __FUNCTION__, "Hooks information updated !" );
			return;
		}
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "Error occurred !" );
		return;
	}
	
?>

