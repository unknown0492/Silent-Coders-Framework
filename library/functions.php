<?php 
	@session_start();
	$con = null;
	include( dirname( __DIR__ ) . "/includes/constants.php" );
	//include( dirname( __DIR__ ) . "/library/Classes/FileIncluder.php"  );
	include( dirname( __DIR__ ) . "/library/Classes/MyRegex.php"  );
	include( dirname( __DIR__ ) . "/library/Classes/FormHelper.php"  );
	
	define( 'PAGE_NAME_LOGIN', 'login' );
	define( 'PAGE_LOGIN', 'login.php' );
	
	define( 'PAGE_NAME_ADMIN', 'adminpanel' );
	
	define( 'PAGE_NAME_404', '404error' );
	define( 'PAGE_404', '404error.php' );
	
	// WEBSITE DETAILS
	initWebsite();
	define( 'WEBSITE_ADMINPANEL_URL', "adminpanel" . WEBSITE_LINK_ENDS_WITH );
	define( 'URL_MAINTENANCE_PAGE', 'http://' . WEBSITE_DOMAIN_NAME . "maintenance.php" );
	$VLDTN = getAllValidationConstants();
	
	function connect(){
		require( dirname( __DIR__ ) . "/library/config.php" );
		global $con;
		
		if( empty( $host ) || empty( $database_username ) ){
			$error = createJSONMessage( GENERAL_ERROR_MESSAGE, "config-file", "config.php file not yet configured !" );
			echo $error;
			return;
		}
		if( $con == null ){
			$con = mysqli_connect( $host, $database_username, $database_password ) or die( 'Cannot connect to database' );
			mysqli_select_db( $con, $database_name ) or die( 'cannot select database ' + $database_name );
			
		}
	}
	
	function createId( $prefix ){
		/*
		 * Creates a randomly generated ID with a prefix of your choice
		 * $prefix -> an identifier of your choice followed by 10 Digit Random Number
		 */
		$id = $prefix . "-" . rand( 1, 99999 ) . rand( 1, 99999 );
		return $id;
	}
	
	function createMessage( $type, $for, $info ){
		/*
		 * Generates an Array of Error or Success information
		*
		* $type -> Identifier of the message ; success or error
		* $for  -> Purpose/Task
		* $info -> Custom message associated with the identifier and purpose
		*
		*/
		$arr = array();
		array_push( $arr, array( "type"=>$type, "for"=>$for,  "info"=>$info ));
		return $arr;
	}
	
	function createJSONMessage( $type, $for, $info ){
		/*
		 * Generates a Json Encoded Array of Error or Success information
		 * 
		 * $type -> Identifier of the message ; success or error
		 * $for  -> Purpose/Task
		 * $info -> Custom message associated with the identifier and purpose
		 * 
		 */
		$arr = array();               
		array_push( $arr, array( "type"=>$type, "for"=>$for,  "info"=>$info ));
		return json_encode( $arr );
	}
	
	function isValidFileExtension( $file_url, $allowed_file_extensions ){
		/*
		 * To check if the file extension is allowed
		 * $file_url -> URL or name of the file
		 * $allowed_file_extensions -> Array of valid file extensions
		 *
		 */
		$file_extension = substr( $file_url, strpos( $file_url, "." ) + 1 );
		//for( $i=0; $i<count( $allowed_file_extensions ); $i++ ){
		if( ! in_array( $file_extension, $allowed_file_extensions ) ){
			return false;	
		}
		return true;
		//}
	}
	
	function getFileExtension( $file_url ){
		/*
		* To get the file extension of the File that has been input
		* $file_url -> URL or name of the file
		*
		*/
		return substr( $file_url, strpos( $file_url, "." ) + 1 );
	}
	
	function getFileName( $file_url ){
		/*
		* To get the file name of the File URL that has been input, removing the slashes and its extension
		* $file_url -> URL or name of the file
		*
		*/
		if( ( $pos = strpos( $file_url, "/" ) ) != false )
			return substr( $file_url, $pos+1, strpos( $file_url, "." ) - $pos - 1 );
		
		return substr( $file_url, 0, strpos( $file_url, "." ) );
	}
	
	function rawQuery( $sql ){
		/*
		 * Fires the Generic Query over the database handle opened using $con object
		 * $sql -> The query to be fired
		 *
		 */
		connect();
		global $con;
		mysqli_query( $con, $sql ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error( $con ) ) );
		
		if( count( @$error ) > 0 ){
			echo $error;
			return;
		}
	}
	
	function selectQuery( $sql ){
		/* 
		 * Fires the Select Query over the database handle opened using $con object
		 * $sql -> The query to be fired
		 * 
		 */
		connect();
		global $con;
		$result_set = mysqli_query( $con, $sql ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error( $con ) ) );
		
		if( count( @$error ) > 0 ){
			echo $error;
			return;
		}
		
		return $result_set;
	}
	
	function insertQuery( $query ){
		/*
		* Fires the Insert Query over the database handle opened using $con object
		* $query -> The query to be fired
		*
		*/
		connect();
		global $con;
		$num_rows_inserted = mysqli_query( $con, $query ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error($con) ) );
	
		if( count( @$error ) > 0 ){
			echo $error;
			return;
		}
	
		return $num_rows_inserted;
	}
	
	function updateQuery( $query ){
		/*
		 * Fires the Update Query over the database handle opened using $con object
		* $query -> The query to be fired
		*
		*/
		connect();
		global $con;
		$num_rows_updated = mysqli_query( $con, $query ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error($con) ) );
	
		if( count( @$error ) > 0 ){
			echo $error;
			return;
		}
	
		return $num_rows_updated;
	}
	
	function deleteQuery( $query ){
	   /*
		* Fires the Delete Query over the database handle opened using $con object
		* $query -> The query to be fired
		*
		*/
		connect();
		global $con;
		$num_rows_deleted = mysqli_query( $con, $query ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error($con) ) );
	
		if( count( @$error ) > 0 ){
			echo $error;
			return;
		}
		
		return $num_rows_deleted;
	}
	
	function redirect( $relative_destination_url ){
		/*
		 * Redirects to $relative_destination_url
		 * The URL should be relative to the current page
		 * 
		 */
		echo '<script>window.location.href="' . $relative_destination_url . '"</script>';
	}
	
	function bin2base64( $file_url ){
		/*
		 * Outputs the Base64 Encoded Version of Input File
		 * $file_url -> Input file URL
		 */
		$binary_file = file_get_contents( $file_url );
		echo base64_encode( $binary_file );
	}
	
	function containSpecialCharacters( $string, $special_chars = array("'", '"', "\\", ".", "+", ",") ){
		/*
		 * Checks if the String contains Special Characters supplied in $special_chars aray
		 * $string -> String to be checked fo presence of special chars
		 * $special_chars -> Array containing special chars which has to be checked for their presence
		 * 
		 */
		
		//$special_chars = array("'", '"', "\\", ".", "+", ",");
		for( $i=0; $i<count( $special_chars ) ; $i++ ){
			if( strstr( $string, $special_chars[ $i ] ) ){
				return true;
			}
		}
		return false;
	}

	function resizeImage( $file_url, $required_width, $required_height, $select_width ) {
		/*
		 * To resize Image specified by the URL $file_url with the Proportions Constrained
		 * $file_url -> URL of the image
		 * $required_width -> Desired width of the image, so that height will be adjusted automatically
		 * $required_height -> Desired width of the image, so that width will be adjusted automatically
		 * $select_width -> Boolean, if true, Only width will be considered, if False, only Height will be considered
		 * 
		 * Returns a $img_new (gd image) object which can be passed to imagepng( $img_new, $tmp_image ) to save the new resized image to $tmp_image URL
		 *
		 */
			
		$size = getimagesize( $file_url );
		$width = $size[ 0 ];
		$height  = $size[ 1 ];
		
		if( $select_width ){
			$factor = $width / $required_width;
			$new_width = $width / $factor;
			$new_height = $height / $factor;
		}
		else{
			$factor = $height / $required_height;
			$new_height = $height / $factor;
			$new_width = $width / $factor;
		}
		/* echo "Original Width : " . $size[0] . "<br>";
		 echo "Original Height : " . $size[1] . "<br>";
		echo "New Width : " . $new_width . "<br>";
		echo "New Height : " . $new_height . "<br>";
		*/
		$image_extension = getFileExtension( $file_url );
			
		// implement switch case for png, jpg, gif, bmp
		switch( $image_extension ){
			case "jpg":
			case "jpeg":
			case "JPG":
			case "JPEG":
				$src = imagecreatefromjpeg( $file );
				break;
	
			case "png":
			case "PNG":
				$src = imagecreatefrompng( $file );
				break;
	
			case "gif":
			case "GIF":
				$src = imagecreatefromgif( $file );
				break;
	
			case "bmp":
			case "BMP":
				$src = imagecreatefromwbmp( $file );
				break;
					
		}
			
		$img_new = imagecreatetruecolor( $new_width, $new_height );
		imagecopyresampled( $img_new, $file_url, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		//imagepng( $dst, $file );  // save the $dst i.e new small image to the same file $file
			
		return $img_new;
	}
	
	function convertTimestamp( $timestamp, $format ){
		/*
		 * Converts the timestamp retrieved from the Database into specified $format
		 * $timestamp -> Timestamp value taken from the database e.g: 2014-09-24 15:42:12
		 * $format -> Output to be seen e.g: 09 July, 1992 i.e. $format = "d F, Y"
		 * 
		 * Returns the string representation of the Formatted timestamp
		 * 
		 */
		
		// $timestamp = 2014-09-24 15:42:12;
		$split = explode( "-", $timestamp );
		$year  = $split[ 0 ];
		$month = $split[ 1 ];
		$day   = substr( $split[ 2 ], 0, 2 );
			
		$d = date( $format, mktime( 0,0,0, $month, $day, $year ) );
		return $d;
	}
	
	function uploadBinaryFileFromAndroid( $file_name, $file_extension, $directory ){
		/*
		 * Uploads a Binary File to the same directory from Android Device
		 * 
		 * $file_name -> File to be Named As
		 * $file_extension -> Extension for the File
		 * $directory -> Directory name where file has to be moved after getting uploaded
		 * 
		 * Returns the Constructed FileName
		 */
		
		$filename .= "." . $file_extension;
		$fileData = file_get_contents( 'php://input' );
		$fhandle = fopen($filename, 'wb');
		fwrite( $fhandle, $fileData );
		fclose( $fhandle );
		rename( $file_name, $directory . FILE_SEPARATOR . $file_name );
		//copy( $filename, "./$move_to/" . $filename );
		// delete from here
		echo $filename;
	}
	
	function sendMail( $to, $from, $subject, $message ){
		
		//Headers
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "From: <" . $from . ">" ;
		
		mail( $to, $subject, $message, $headers );
	}

	function sendMailObject(){
	
		require( "PHPMailer/class.phpmailer.php" );
		require( "PHPMailer/class.smtp.php" );
		$mail = new PHPMailer();
		$mail->IsSMTP();  // telling the class to use SMTP
		$mail->Host     = EMAIL_SERVER_HOST; // SMTP server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = EMAIL_NOREPLY;                 // SMTP username
		$mail->Password = EMAIL_NOREPLY_PASSWORD;                           // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		
		//$mail->setFrom( EMAIL_NOREPLY, 'SC FRAMEWORK.' );
		//$mail->addCC( EMAIL_ADMIN );				// Sending the copy to the administrator
		//$mail->isHTML( true );
		
		return $mail;
	}
	
	function getPageName( $url_type ){
		/*
		* Returns the name of the Curent Page Stripping off all the other parts of the URL
		*
		* $url_type -> the type of URL that is Provided as Input (currently on clean is supported)
		*
		* Returns the name of the Current Page
		*/
		
		if( $url_type == "clean" ){
			$current_relative_path = $_SERVER['REQUEST_URI']; // /silentcoders/services.html	 --- On Server, it gives only /
			$page_name = substr( $current_relative_path, 0, strrpos( $current_relative_path, "." ) );
			$page_name = substr( $page_name, strrpos( $page_name, "/" ) + 1 );
		}
	
		return $page_name;
	}
	
	function getDomainName(){
		/*
		 * Returns the domain name without "www."
		 * 
		 */
		
		$host = $_SERVER[ 'HTTP_HOST' ];
		return ( strpos( $host, "www." ) )?( trim( $host, "www." ) ):$host;
	}
	
	function initHooks(){
		/*
		* Fire SQL query to initialize hooks 
		* 
		* Returns The Mysqli_fetched_Associative_array containing all the hook data
		*
		*/
		connect();
		global $con;
		$query = "Select * from " . DB_HOOKS_TABLE;
		$result_set = mysqli_query( $con, $query ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error($con) ) );
		$hooks_array = array();
		
		if( count( @$error ) > 0 ){
			echo $error;
			return;
		}
		
		while( ( $row = mysqli_fetch_assoc( $result_set ) ) != null ){
			$hooks_array[] = $row;
		}
		return $hooks_array;
	}
	
	function getHookContent( $hook_name ){
		/*
		 * Retuns the content corresponding to the supplied hook
		*
		* $hook_name -> The name of the hook whose content is needed
		*
		*/
		global $hooks_array;
		foreach ( $hooks_array as $data ){
			if ( $data[ 'hook_name' ] == $hook_name )
				return $data[ 'hook_content' ];
		}
	}
	
	function initWebsite(){
		/*
		 * Initialize the DOMAIN_NAME constant
		*
		*/
		connect();
		global $con, $email_server_host, $noreply_email, $noreply_password;
		$sql = "Select * from " . DB_SITE_CONFIG_TABLE;
		$result_set = selectQuery( $sql );
		$value = mysqli_fetch_array( $result_set );
		
		
		define( 'WEBSITE_URL_TYPE', $value[ 'url_type' ] ); // No ? in the URL
		define( 'WEBSITE_LINK_ENDS_WITH', $value[ 'link_ends_with' ] );
		define( 'WEBSITE_DOMAIN_NAME', $value[ 'domain_name' ] );
		
		$index = ( ( $v = strpos( $value[ 'domain_name' ], "/" ) ) == false )?strlen( $value[ 'domain_name' ] ):$v;
		define( 'WEBSITE_SUB_DOMAIN_DIRECTORY', substr( $value[ 'domain_name' ], $index, strlen( $value[ 'domain_name' ] ) ) );
		define( 'WEBSITE_PROTOCOL', $value[ 'protocol' ] );
		define( 'EMAIL_SERVER_HOST', $email_server_host );
		define( 'EMAIL_NOREPLY', $noreply_email );
		define( 'EMAIL_NOREPLY_PASSWORD', $noreply_password );
		
	}

	function getUrlParameters( $url ){
		// $url = "/digital_signage/events.html?menu=create&oi=tou";
		// $url = "/digital_signage/events.html";
		
		// check if Question mark exist in the url
		if( strpos( $url, "?" ) == false ){ // false is returned if question mark is not found
			return false;
		}
		else{
			$params = substr( $url, strpos( $url, "?" ) + 1 );
		}
		
		/* 
		if( $params == $url ){  // no question mark found
			echo false;
			exit();
		} */
		
		$params2 = explode( "&", $params );
		// print_r( $params2 );
		
		for( $i = 0 ; $i < count( $params2 ) ; $i++ ){
			$temp = explode( "=", $params2[ $i ] );
			$params_arr[ $temp[ 0 ] ] = $temp[ 1 ];
		}
		
		/* if( $params2[ 0 ] == $params ){ // no & is found, meaning only one paramter exist
			$params3 = explode( "=", $params2[ 0 ] );
			$params_arr[ $params3[ 0 ] ] = $params3[ 1 ];
			// print_r( $params_arr );
			
		}
		else{
			for( $i = 0 ; $i < count( $params2 ) ; $i++ ){
				$temp = explode( "=", $params2[ $i ] );
				$params_arr[ $temp[ 0 ] ] = $temp[ 1 ];
			}
		} */
		
		// print_r( $params_arr );
		return $params_arr;
	}
	
	function generateQRFromText( $text, $dest_image ){
		include "phpqrcode/qrlib.php";
		QRcode::png( $text, $dest_image, 'XL', 6, 2 );
		return $dest_image;
	}
	
	function havePrivilege( $functionality_name, $functionality_id ){
		
		$role_id = $_SESSION[ SESSION_AUTHORIZATION ];
		
		if( ( $functionality_id == false ) || ( trim( $functionality_id ) == "" ) ){
			$sql = "Select role_id FROM roles_privileges WHERE privilege_id = 
						( SELECT privilege_id FROM privileges_functionalities WHERE functionality_id = 
						(SELECT functionality_id FROM functionalities WHERE functionality_name = '$functionality_name') ) AND role_id = $role_id";
		}
		else{
			$sql = "Select role_id FROM roles_privileges WHERE privilege_id =
			( SELECT privilege_id FROM privileges_functionalities WHERE functionality_id = $functionality_id ) AND role_id=$role_id";
		}
		
		$result_set = selectQuery( $sql );		
		
		if( mysqli_num_rows( $result_set ) == 0 ){
			return false;
		}
		return true;	
	}
	
	function equals( $var1, $var2 ){
		if( $var1 === $var2 )
			return true;
		return false;
	}
	
	function contains( $str, $part ){
		if( strpos( $str, $part ) == false )
			return false;
		return true;
	}
	
	function timeNow( $format = "jS M, Y h:i A" ){
		echo date( $format, time() );
	}

	function roleToRoleId( $role_name ){
		switch( $role_name ){
			case "admin":
				return 1;
			case "staff":
				return 2;
			case "Registered User":
				return 3;
						
		}
	}
	
	/**
	 *
	 * This is a customized version of in_array() function, developed by Silent Coders Pvt Ltd
	 * to search for an element in a multi dimension array
	 *
	 * @param String $needle The value to be searched
	 * @param Array $haystack The array in which the value is to be searched
	 * @param Boolean $strict [optional] if true, does case comparison
	 *
	 * @return boolean
	 *
	 */
	function in_array_r( $needle, $haystack, $strict = false ) {
		foreach ( $haystack as $item ) {
			if ( ( $strict ? $item === $needle : $item == $needle ) || ( is_array( $item ) && in_array_r( $needle, $item, $strict ) ) ) {
				return true;
			}
		}
		return false;
	}
	/**
	 * 
	 * @param String $file_name The name of the php file in which the function is being called
	 *
	 */
	function checkPrivilegeForPage( $file_name ){
		if( ! havePrivilege( $file_name, false ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "You dont have sufficient privilege to view this page !" );
			exit();
		}
	}
	
	/**
	 *
	 * @param String $function_name The name of the php function in which the function is being called
	 *
	 */
	function checkPrivilegeForFunction( $function_name ){
		if( ! havePrivilege( $function_name, false ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "You dont have sufficient privilege to perform this action !" );
			exit();
		}
	}
	
	/**
	 *
	 * Checks if the user is logged in or not
	 * 
	 * @return boolean true if user is logged in, false otherwise
	 *
	 */
	function isLoggedIn(){
		if( ! @isset( $_SESSION[ SESSION_AUTHORIZATION ] ) ){ // If session variable is not set
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 * Checks if the user is logged in or not
	 * If not logged in, user is redirected to the Login Page
	 * 
	 */
	function checkIfLoggedIn(){
		if( ! isLoggedIn() ){ 
			@redirect( PAGE_LOGIN );
			return;
		}
	}
	
	/**
	 * 
	 * Only administrator can perform this operation. Both the parameters
	 * cannot be false at the same time. At least one parameter is a must.
	 * 
	 * @param String/boolean $user_id User ID of the gonna be user
	 * @param int/boolean $role_id Role ID of the gonne be user
	 * 
	 * @return true If the current user is admin. false If the current user is not the admin
	 * 
	 */
	function onlyAdminCan( $user_id, $role_id ){
		if( ( $role_id == false ) || ( trim( $role_id ) == "" ) ){
			// Get the role_id of the gonna be user
			$sql = "SELECT role_id FROM users WHERE user_id = '$user_id'";
			$result_set = selectQuery( $sql );
			if( mysqli_num_rows( $result_set ) <= 0 ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "User ID does not exist" );
				return true;
			}
			$val = mysqli_fetch_object( $result_set );
			$role_id = $val->role_id;
		}
		
		if( ( $role_id == roleToRoleId( SESSION_ADMIN ) ) &&  // if role to be edited is of admin
				( $_SESSION[ SESSION_AUTHORIZATION ] != roleToRoleId( SESSION_ADMIN ) ) ){  // if change karne wala is not the admin
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "You dont have sufficient privileges to perform this operation !" );
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 * Returns the milliseconds of the current date and time
	 * 
	 */
	function currentTimeMilliseconds(){
		return round( microtime( true ) * 1000 ); 
	}
	
	/**
	 * 
	 * Deletes the directory recursively
	 * 
	 * @param String $dir path to the directory
	 * @return boolean
	 * 
	 */
	function deleteDirectoryRecursive( $dir ) {
		$files = array_diff( scandir( $dir ), array( '.', '..' ) );
		foreach ( $files as $file ) {
			( is_dir( "$dir/$file" ) ) ? deleteDirectoryRecursive( "$dir/$file" ) : unlink( "$dir/$file" );
		}
		return rmdir( $dir );
	}
	
	/**
	 * 
	 * Gets all the site_config data from the database table
	 * 
	 * @return Object array of site_config information
	 * 
	 */
	function getSiteConfig(){
		$sql = "Select * FROM site_config";
		$result_set = selectQuery( $sql );
		return mysqli_fetch_object( $result_set );
	}
	
	/**
	 * Validates the empty string
	 *
	 * @param String $str The input string to validate for emptiness
	 * @param String $err_msg The error message to echo if not validated
	 *
	 * @return JSON array of error if not validated, else returns nothing
	 *
	 */
	function validateEmptyString( $str, $for, $err_msg ){
		if( empty( $str ) || ( trim( $str ) == "" ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, $for, $err_msg );
			exit();
		}
	}
	
	/**
	 * Validates the empty Digits Variable
	 *
	 * @param String $str The input digit string to validate for emptiness
	 * @param String $err_msg The error message to echo if not validated
	 *
	 * @return JSON array of error if not validated, else returns nothing
	 *
	 */
	function validateEmptyDigitString( $str, $for, $err_msg ){
		if( ( $str != 0 ) ){
			if( empty( $str ) || ( trim( $str ) == "" ) ){
				echo createJSONMessage( GENERAL_ERROR_MESSAGE, $for, $err_msg );
				exit();
			}
		}
	}
	
	/**
	 * Validates the string for the supplied regex pattern
	 *
	 * @param String $str The input string to validate for emptiness
	 * @param String $regex The regex pattern to validate the intput string $str
	 * @param String $err_msg The error message to echo if not validated
	 *
	 * @return JSON array of error if not validated, else returns nothing
	 *
	 */
	function validate( $str, $for, $regex, $err_msg ){
		if( !preg_match( $regex, $str ) ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, $for, $err_msg );
			exit();
		}
	}
	
	/**
	 *
	 * Show a javascript alert
	 *
	 */
	function alert( $msg ){
		echo "<script>alert( '$msg' )</script>";
	}
	
	/**
	 *
	 * Checks if the current user has already logged in. If not, then the role for this user is set as Not-Registered
	 *
	 */
	function setNonRegisteredUser(){
		if( ! @isset( $_SESSION[ SESSION_AUTHORIZATION ] ) ){
			$_SESSION[ SESSION_USER_ID ] = "not_registered";
			$_SESSION[ SESSION_AUTHORIZATION ] = roleToRoleId( "Non Registered Users" );
			return;
		}
	}
	
	/**
	 *
	 * Search for a value in the 2D array
	 * http://stackoverflow.com/questions/6661530/php-multi-dimensional-array-search
	 *
	 * @params $id Value to be searched
	 * @params $array The 2D array to search the value in
	 * @params $field The filed inside the 2D array to be searched for the value
	 *
	 * @return index of the 1st dimension of the array if value is found, else null
	 *
	 *
	 */
	function searchForId( $id, $array, $field ) {
		foreach ( $array as $key => $val ) {
			if ( $val[ $field ] == $id ) {
				return $key;
			}
		}
		return null;
	}
	
	/**
	 * 
	 * Retrieves all validation variables and regex expressions
	 * 
	 * @return Array of Validation variables, type and regex expressions
	 * 
	 */
	function getAllValidationConstants(){
		require( dirname( __DIR__ ) . "/library/config.php" );
		
		global $validation_array;
		
		return $validation_array;
	}
	
	/**
	 * 
	 * Check if the registrations are open or not
	 * 
	 * @return Boolean true if the registration is open, false otherwise
	 * 
	 */
	function isRegistrationOpen(){
		$sql = "SELECT is_registration_open FROM site_config";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) == 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "No such field in Database" );
			return;
		}
		$val = mysqli_fetch_object( $result_set );
		
		return ($val->is_registration_open == 0)?false:true;
	}
	
	/**
	 *
	 * Check if the Forgot Password Option is enabled 
	 *
	 * @return Boolean true if the Forgot Password Option is open, false otherwise
	 *
	 */
	function isForgotPasswordOptionEnabled(){
		$sql = "SELECT allow_forgot_password FROM site_config";
		$result_set = selectQuery( $sql );
		if( mysqli_num_rows( $result_set ) == 0 ){
			echo createJSONMessage( GENERAL_ERROR_MESSAGE, __FUNCTION__, "No such field in Database" );
			return;
		}
		$val = mysqli_fetch_object( $result_set );
	
		return ($val->allow_forgot_password == 0)?false:true;
	}
	
	/**
	 * 
	 * Returns the REGEX expression for the supplied Validation Constant
	 * 
	 * @param String Validation Constant
	 * 
	 * @return String REGEX pattern for the supplied Validation Constant
	 * 
	 * 
	 */
	function getValidationRegex( $VLDTN_CONSTANT ){
		$arr = getAllValidationConstants();
		
		return $arr[ $VLDTN_CONSTANT ][ 'REGEX' ];
	}
	
	/**
	 *
	 * Returns the Error Message for the supplied Validation Constant
	 *
	 * @param String Validation Constant
	 *
	 * @return String Error Message for the supplied Validation Constant
	 *
	 *
	 */
	function getValidationErrMsg( $VLDTN_CONSTANT ){
		$arr = getAllValidationConstants();
	
		return $arr[ $VLDTN_CONSTANT ][ 'ERR_MSG' ];
	}
	
	/**
	 * 
	 * Check if the password reset expiry time has been already passed
	 * 
	 * @param Long milliseconds $current_time
	 * @param Long milliseconds $password_reset_expiry_time
	 * 
	 * @return false if the difference between the $current_time and $password_reset_expiry_time is within valid range, true otherwise
	 */
	function isPasswordResetValidityExpired( $current_time, $password_reset_expiry_time ){
		$validity = 24; // Hours
		$difference = ( $current_time - $password_reset_expiry_time ) / ( 1000 * 60 * 60 );
		if( $difference >= $validity ){ // Expired
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 * Generate a Random Alphanumeric String
	 * 
	 * @param Int Number of characters of password, max 32. $max_chars
	 * 
	 * @return String Random alphanumeric string
	 */
	function getRandomString( $max_chars ){
		return substr( md5( rand() ) , 0, $max_chars );
	}
	
	/**
	 * 
	 * Generate the Loading Content HTML
	 * 
	 * @param String $class Class name of the top-level div
	 * 
	 * @param String $loading_text The text to be shown for loading alias
	 * 
	 * @param boolean $is_hidden Whether by default the loading div is hidden
	 * 
	 * @param String $position left, right, center The positioning of the loading animation
	 * 
	 * @param Int $height The height of the loading animation, width will be adjusted automatically
	 * 
	 * @return String HTML for the loading animation
	 * 
	 */
	function getLoadingHTML( $class, $loading_text, $is_hidden, $position, $height ){
		$hidden = ( $is_hidden )?"hidden":"";
		$data = "";
		if( ( $position == "left" ) || ( $position == "right" ) ){
			$data = "<div class=\"$class $hidden\" style=\"float: $position\">";
			$data .= "<img src=\"images/small-loading.gif\" style=\"height: ".$height."px;\" />";
			$data .= "<p>Loading Content...</p>";
			$data .= "</div>";
		}
		else if( ( $position == "center" ) ){
			$data = "<center><div class=\"$class $hidden\">";
			$data .= "<img src=\"images/small-loading.gif\" style=\"height: ".$height."px;\" />";
			$data .= "<p>Loading Content...</p>";
			$data .= "</div>";
			$data .= "</center>";
		}
		echo $data;
	}
?>