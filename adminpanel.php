<?php 

	checkIfLoggedIn();
	$url_params = getUrlParameters( $_SERVER[ 'REQUEST_URI' ] );
	
?>

<?php 
	/*
	 * Pages belonging to adminpanel.html, retrieve from the Database
	 *
	 */
	$sql 		= "Select page_name from pages";
	$result_set = selectQuery( $sql );
	$admin_pages = array();
	while( ( $val = mysqli_fetch_object( $result_set ) ) != NULL ){
		array_push( $admin_pages, $val->page_name );
	}
	
	$page_name = @$url_params[ 'what_do_you_want' ];
	
	// Get the Plugin-Name from the current_page_name
	$sql 		= "SELECT b.plugin_name FROM pages a, plugins b WHERE a.page_name='$page_name' AND (b.plugin_id=a.plugin_id)";
	$result_set = selectQuery( $sql );
	if( mysqli_num_rows( $result_set ) == 0 ){
		//exit( 'No Such Page !' );
		// redirect( "404error.php" );
	}
	else{
		$val = mysqli_fetch_object( $result_set );
		$plugin_name = $val->plugin_name;
	}
?>

			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				
				<!-- BEGIN CONTENT BODY -->
                <div class="page-content">
						<?php  
							if( $url_params == false ){ ?>
								<h4 class="text-center"><?=$site_tagline ?></h4> <br />
							<?php 
							}
							else if( in_array( $page_name, $admin_pages ) ){ 
								include "plugins/$plugin_name/pages/" . $page_name . '.php'; 
							}
							else{
								echo "Invalid Choice";
							}
						?>
				</div>
				<!-- END CONTENT BODY -->
				
			</div>
			<!-- END CONTENT -->
			
		</div>
        <!-- END CONTAINER, Starts in navbar.php -->
