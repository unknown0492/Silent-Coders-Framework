<?php
	include( 'library/config.php' );	
	include( 'library/functions.php' );
	include( 'library/custom_functions.php' );
		
	@$what_do_you_want = $_REQUEST[ 'what_do_you_want' ];
	// print_r( $_SESSION );
	// Do the Logging function here
	
	/*
	 * Funcitons Performed By Webservice
	 *
	 */
	$webservice_fns = array();
	$sql = "SELECT functionality_name FROM functionalities";
	$result_set = selectQuery( $sql );
	while( ( $val = mysqli_fetch_object( $result_set ) ) != NULL ){
		array_push( $webservice_fns, $val->functionality_name );
	}
	array_push( $webservice_fns, "login" );
	array_push( $webservice_fns, "logout" );
	array_push( $webservice_fns, "get_all_validation_constants" );
	
	// include( "webservice/functions/sub-functions.php" );
	include( 'plugins/page_management/webservice/page_management_functions.php' );
	include( 'plugins/privilege_management/webservice/privilege_management_functions.php' );
	include( 'plugins/user_role_management/webservice/role_management_functions.php' );
	include( 'plugins/website_configuration/webservice/site_config_functions.php' );
	include( 'plugins/user_management/webservice/user_management_functions.php' );
	include( 'plugins/plugin_management/webservice/plugin_functions.php' );
	
	if( ( $what_do_you_want == '' ) || ( $what_do_you_want == NULL ) ){
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, "webservice", "Webservice does not perform such an action, Sorry !!" );
	}
	else if( in_array( $what_do_you_want, $webservice_fns ) ){
		$what_do_you_want();
	}
	else{
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, "webservice", "Webservice does not perform such an action, Sorry !!" );
	}
	
	/* 1 */
	function login(){
		$user_id  = $_REQUEST[ 'user_id' ];
		$password = md5( $_REQUEST[ 'password' ] );
		
		if( containSpecialCharacters( $user_id, array( '"', "'" ) ||
				containSpecialCharacters( $password, array( '"', "'" ) ) ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, "login", "Invaid username/password" );
			exit();
		}
		
		$sql = "Select * from ". DB_USERS_TABLE ." where user_id='$user_id' And password='$password'";
		$result_set = selectQuery( $sql );
		
		if( mysqli_num_rows( $result_set ) == 1 ){
			$value = mysqli_fetch_array( $result_set );
			if( ( $value[ 'user_id' ] == $user_id ) && ( $value[ 'password' ] == $password ) ){
				$_SESSION[ SESSION_AUTHORIZATION ] = $value[ "role_id" ];
				$_SESSION[ SESSION_USER_ID ] = $user_id;
				$_SESSION[ 'fname' ] = $value[ 'fname' ];
				$_SESSION[ 'lname' ] = $value[ 'lname' ];
				
				// Generate a session token
				
				//$_SESSION[ SESSION_ROLE_ID ] = $value[ 'role_id' ];
				
				echo createJSONMessage( GENERAL_SUCCESS_MESSAGE, "login", "You have been logged in successfully !" );
				exit();
			}
			else{
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, "login", "Invaid username/password" );
				exit();
			}
		}
		else{
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, "login", "Invaid username/password" );
			exit();
		}
	}
	
	/* 2 */
	function logout(){
		session_destroy();
		redirect( PAGE_LOGIN );
	}
	
	/* 3 */
	function get_all_validation_constants(){
		getAllValidationConstants();
	}
	