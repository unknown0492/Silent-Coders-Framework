<?php
	
	$options = array(
		"PLUGIN_NAME" => "abc",														// The name of the plugin, without any keywords like "config", "plugin", etc
		"PLUGIN_TYPE" => "page",												// The type of the plugin, if it is a standalone plugin, then type = "root". If the plugin is listed under adminpanel, then type = "page"
		"PLUGIN_DESCRIPTION" => "Description of the plugin",
		"PLUGIN_DATE" => "11 Feb, 2016",
		"PLUGIN_AUTHOR" => "Sohail Shaikh",
		"PLUGIN_VERSION" => "1.0",
	);
	
	/* if( PLUGIN_TYPE === "page" ){ 														// Use these configuration parameters for the PLUGIN_TYPE = "page"
		
	} */
	
	$config_queries = array( "create table test( `aaa` varchar(100) )",
							 "create table test( `bbb` int(11) )"
							);
	
	$config_privileges = array( array( "privilege_group_name" => "Sample Privilege Group A",
										"privilege_group_privileges" => array( array( "privilege_name" => "sample_privilege_a",
																					  "privilege_description" => "Sample Privilege Description for A",
																					  "functionality_name" => "sample_privilege_a",
																					  "functionality_description" => "Sample Functionality Description for A"
																					 ),
																			   array( "privilege_name" => "sample_privilege_page_b",
																					  "privilege_description" => "Sample Privilege Description for B",
																					  "functionality_name" => "sample_privilege_page_b",
																					  "functionality_description" => "Sample Functionality Description for B"
																					 ),
																			  )
									  ),
								array( "privilege_group_name" => "Sample Privilege Group C",
										"privilege_group_privileges" => array( array( "privilege_name" => "sample_privilege_page_c",
																						"privilege_description" => "Sample Privilege Description for C",
																						"functionality_name" => "sample_privilege_page_c",
																						"functionality_description" => "Sample Functionality Description for C"
																					),
																				array( "privilege_name" => "sample_privilege_d",
																						"privilege_description" => "Sample Privilege Description for D",
																						"functionality_name" => "sample_privilege_d",
																						"functionality_description" => "Sample Functionality Description for D"
																					  ),
																			  )
									  ),
							   );
	
	
	$config_pages = array( array( "page_group_name" => "Sample Page Group A",
								  "icon" => "fa fa-smile",
								  "page_group_pages" => array( array( "page_name" => "sample_page_a",
								  									  "icon" => "fa fa-trash-o",
								  									  "visible" => "1",
								  									  "page_title" => "Sample Page Title A",
								  									  "functionality_name" => "sample_privilege_page_c",
								  									  "title" => "Sample Page Title Title A",
								  									  "description" => "Sample Page Description A",
								  									  "tags" => "Sample Page tags A",
								  									  "image" => "http://flopsite.com/logo.png",
								  									  "content" => "Sample Page content A"
								  							  		 ),
								  								array( "page_name" => "sample_page_b",
								  									  "icon" => "fa fa-letter",
								  									  "visible" => "1",
								  									  "page_title" => "Sample Page Title B",
								  									  "functionality_name" => "sample_privilege_page_b",
								  									  "title" => "Sample Page Title Title B",
								  									  "description" => "Sample Page Description B",
								  									  "tags" => "Sample Page tags B",
								  									  "image" => "http://flopsite.com/logos.png",
								  									  "content" => "Sample Page content B"
								  							  		 ),
								  							  )
							 	 ) 
						  );
	
	$config_js = array( 															// Include all the js file names without the extension
			"sample_page_a",
			"sample_page_b"
	);
	
	$config_css = array( 															// Include all the css file names without the extension
			"sample_page_a",
			"sample_page_b"
	);
	
	
?>