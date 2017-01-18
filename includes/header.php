<?php
	include( './library/functions.php' );
	include( './library/custom_functions.php' );
	
	$hooks_array = initHooks();
	
	$current_page_name = getPageName( WEBSITE_URL_TYPE ); // home
	
	$sql 		= "Select page_name from pages";
	$result_set = selectQuery( $sql );
	$pages = array();
	while( ( $val = mysqli_fetch_object( $result_set ) ) != NULL ){
		array_push( $pages, $val->page_name );
	}
	
	if( $current_page_name == "" )
		$current_page_name = PAGE_NAME_ADMIN;
	else if( ! in_array( $current_page_name, $pages ) )
		$current_page_name = PAGE_NAME_404;
	
?>

<!-- Meta Tags for SEO begins -->
<?php
	// here generate tags relevant to pages from the database
	
	$sql = "Select title, description, tags, image, content from pages WHERE page_name = '$current_page_name'";
	$result_set = selectQuery( $sql );
	if( mysqli_num_rows( $result_set ) > 0 ){
		$value = mysqli_fetch_object( $result_set );
		
		$title 		 = $value->title;
		$description = $value->description;
		$tags 		 = $value->tags;
		$image 		 = $value->image;
		$content 	 = $value->content;
	}
	else{
		$title = "Page Not Found";
	}
	$url = WEBSITE_DOMAIN_NAME . $current_page_name . WEBSITE_LINK_ENDS_WITH;
				
	include( './includes/meta-tags.php' );
	
?>
<!-- Meta Tags for SEO ends -->
