<?php
	
	// Databse Configurations
	$host = "localhost";
	$database_username = "root"; 
	$database_password = ""; 
	$database_name = "sc_framework";
	
	
	// Email Server Configurations
	// $noreply_email = "noreply@silentcoders.net";
	// $noreply_password = "Bvc6s#;494#";
	// $email_server_host = "so1.infinitysrv.com";
	
	$noreply_email = "noreply@risewithislam.com";
	$noreply_password = "AH@ncke);N}G";
	$email_server_host = "md-in-18.webhostbox.net";
	
	
	// Validation Configurations
	$validation_array = array(
		/* Generic Validations */
		"VLDTN_DIGITS" => array( "TYPE" => "text", "REGEX" => "/^[0-9]*$/" , "ERR_MSG" => "Should be a Digit from 0 to 9" ),
		"VLDTN_ICON" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-]*$/" , "ERR_MSG" => "Compliant with only fontawesome.io icon names" ),
		//"VLDTN_URL" => array( "TYPE" => "text", "REGEX" => '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS', "ERR_MSG" => "URL entered is invalid" ),
			
		/* User Management Related Validations */
		"VLDTN_USER_ID" => array( "TYPE" => "text", "REGEX" => "/^[a-z0-9\_]{3,25}$/" , "ERR_MSG" => "User ID can contain lowercase alphabets a to z, digits 0 to 9 and an underscore _ and min. 3, max. 20 characters" ),
		"VLDTN_PASSWORD" => array( "TYPE" => "password", "REGEX" => "/^[a-zA-Z0-9 \_]{3,20}$/", "ERR_MSG" => "Password should be minimum 3 char, maximum 20 char, can contain lowercase and uppercase alphabets and digits 0 to 9" ),
		"VLDTN_EMAIL" => array( "TYPE" => "email", "REGEX" => "/^[a-z]+[a-z0-9._\-]+@[a-z\-]+\.[a-z.]{2,10}$/", "ERR_MSG" => "Email ID is Invalid" ),
			
		/* Privilege Management Related Validations */
		"VLDTN_PRIVILEGE_GROUP_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, digits 0 to 9, white spaces and characters ( ) [ ] - _ . are allowed" ),
		"VLDTN_PRIVILEGE_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-z0-9\-\_]*$/", "ERR_MSG" => "Only lowercase alphabets, digits 0 to 9 and characters - _ are allowed" ),
		"VLDTN_FUNCTIONALITY_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-z0-9\-\_]*$/", "ERR_MSG" => "Only lowercase alphabets, digits 0 to 9 and characters - _ are allowed" ),
		"VLDTN_PRIVILEGE_DESCRIPTION" => array( "TYPE" => "textarea", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]\'\:\/\?\,\<\>\*\&\%\$\#\@\!\`]*$/", "ERR_MSG" => "Some special characters are not allowed" ),
		"VLDTN_FUNCTIONALITY_DESCRIPTION" => array( "TYPE" => "textarea", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]\'\:\/\?\,\<\>\*\&\%\$\#\@\!\`]*$/", "ERR_MSG" => "Some special characters are not allowed" ),
		
		/* Role Related Validations */
		"VLDTN_ROLE_ID" => array( "TYPE" => "text", "REGEX" => "/^[0-9]*$/", "ERR_MSG" => "Only digits are allowed" ),
		"VLDTN_ROLE_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z\s]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, white spaces are allowed" ),
			
		/* User Related Validations */
		"VLDTN_FIRST_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z\'\s]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, white spaces are allowed" ),
		"VLDTN_LAST_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z\'\s]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, white spaces are allowed" ),
		"VLDTN_NICK_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9\s]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, white spaces are allowed" ),
			
		/* Page Management Related Validations */
		"VLDTN_PAGE_GROUP_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, digits 0 to 9, white spaces and characters ( ) [ ] - _ . are allowed" ),
		"VLDTN_PAGE_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-z0-9\-\_]*$/", "ERR_MSG" => "Only lowercase alphabets, digits 0 to 9 and characters - _ are allowed" ),
		"VLDTN_PAGE_TITLE" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]\'\:\/\?\,\<\>\*\&\%\$\#\@\!\`]*$/", "ERR_MSG" => "Some special characters are not allowed" ),
		"VLDTN_PAGE_DESCRIPTION" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]\'\:\/\?\,\<\>\*\&\%\$\#\@\!\`]*$/", "ERR_MSG" => "Some special characters are not allowed" ),
		"VLDTN_PAGE_TAGS" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 ,\-\_]*$/", "ERR_MSG" => "Only lowercase alphabets, digits 0 to 9 and characters - _ , are allowed" ),
		"VLDTN_PAGE_CONTENT" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]\'\:\/\?\,\<\>\*\&\%\$\#\@\!\`]*$/", "ERR_MSG" => "Some special characters are not allowed" ),
		
		/* Site Config Related Validation */
		"VLDTN_SITE_NAME" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, digits 0 to 9, white spaces and characters ( ) [ ] - _ . are allowed" ),
		"VLDTN_SITE_TAGLINE" => array( "TYPE" => "text", "REGEX" => "/^[a-zA-Z0-9 \-\_\.\(\)\[\]]*$/", "ERR_MSG" => "Only lowercase, uppercase alphabets, digits 0 to 9, white spaces and characters ( ) [ ] - _ . are allowed" ),
			
	);
	
?>