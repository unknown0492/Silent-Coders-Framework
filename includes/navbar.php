<?php 
	checkIfLoggedIn();
?>

<?php 
	// Get the current functionality name in order to make its class Active
	$current = $_SERVER[ 'REQUEST_URI' ];
	$current = explode( "=", $current );
	$isActive = "";
	if( count( $current ) > 1 ){
		$isActive = "current ";
		$current = $current[ 1 ];
	}
	else{
		$current = "";
	}
	
	
	$site_config = getSiteConfig();
    $site_tagline  = $site_config->site_tagline;

	
	
	$sql = "Select * from pages where visible=1";
	$result_set = selectQuery( $sql );
?>
		<!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
        
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
            
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?=WEBSITE_ADMINPANEL_URL ?>">
                        <img src="<?=$site_config->admin_page_logo ?>" alt="logo" class="logo-default" style="height: 77px;" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
					                
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                <?php include 'top-right-menu.php'; ?>
                </div>
                <!-- END PAGE TOP -->
                
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        
        <!-- BEGIN CONTAINER, Ends in adminpanel.php -->
        <div class="page-container">
        
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
            
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item <?=($current=="")?" start active open":""; ?>">
                            <a href="<?=WEBSITE_PROTOCOL ?>://<?=WEBSITE_DOMAIN_NAME . PAGE_NAME_ADMIN . WEBSITE_LINK_ENDS_WITH ?>" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        
                        <li class="heading">
                            <h3 class="uppercase">Features</h3>
                        </li>
                        <?php 
	                    	while( ( $val = mysqli_fetch_object( $result_set ) ) != NULL ){
	                    		//echo "current : $current <br />";
	                    		if( ! havePrivilege( false, $val->functionality_id ) )
	                    			continue;
	                    		
	                    		$sql = "SELECT * FROM page_group";
	                    		$result_set = selectQuery( $sql );
	                    		$page_group_id_arr = array();
	                    		
	                    		while( ( $val = mysqli_fetch_assoc( $result_set ) ) != NULL ){
	                    			array_push( $page_group_id_arr, $val );
	                    		}
	
	                    		//print_r( $page_group_id_arr );
	                    		
	                    		$pages_groups_arr = array();
	                    		for( $i = 0 ; $i < count( $page_group_id_arr ) ; $i++ ){
	                    			$sql = "SELECT * FROM pages_groups WHERE group_id = " . $page_group_id_arr[ $i ][ 'page_group_id' ] . " ORDER BY page_sequence" ;
	                    			$result_set = selectQuery( $sql );
	                    			$temp_arr = array();
	                    			while( ( $val = mysqli_fetch_object( $result_set ) ) != NULL ){
	                    				$sql = "SELECT * FROM pages WHERE page_id = " . $val->page_id . " AND visible = 1";
	                    				$result_set1 = selectQuery( $sql );
	                    				if( mysqli_num_rows( $result_set1 ) == 0 )
	                    					continue;
	                    				$val1 = mysqli_fetch_object( $result_set1 );
	                    				$functionality_id = $val1->functionality_id;
	                    				
	                    				// echo "$functionality_id <br />";
	                    				if( havePrivilege( false, $functionality_id ) ){
	                    					array_push( $temp_arr, array( 'page_sequence' => $val->page_sequence, 'page_id' => $val->page_id, 'page_name' => $val1->page_name, 'page_title' => $val1->page_title ) );
	                    				}
	                    			}
	                    			$temp_arr[ 'page_group_sequence' ] 	= $page_group_id_arr[ $i ][ 'page_group_sequence' ];
	                    			$temp_arr[ 'page_group_name' ] 		= $page_group_id_arr[ $i ][ 'page_group_name' ];
	                    			$temp_arr[ 'icon' ] 				= $page_group_id_arr[ $i ][ 'icon' ];
	                    			//echo 'temp array pritninhg';
	                    			
	                    			//print_r( $temp_arr );
	                    			$pages_groups_arr[ $page_group_id_arr[ $i ][ 'page_group_id' ] ] = $temp_arr;
	                    		}
	                    		
	                    		//print_r( $pages_groups_arr );
	                    		                    		
	                    		/* $set = "";
	                    		if( $val->has_child == 1 ){
	                    			$sql = "Select functionality from privileges WHERE functionality='$current' AND parent_id=" . $val->privilege_id;
	                    			$temp_result_set = selectQuery( $sql );
	                    			if( mysqli_num_rows( $temp_result_set ) > 0 )
	                    				$set = "active current hasSub";
	                    		 }*/
	                    		
	                    ?>
	                    <?php 
	                    	foreach ( $pages_groups_arr as $group_id=>$group_pages ){
	                    		//print_r( $group_id );
	                    		//print_r( $group_pages );
	                    		
	                    		if( count( $group_pages ) == 2 )
	                    			continue;
	                    			
	                    		
	                    		// $flipped_group_pages = array_flip( $group_pages );
	                    ?>
                        <li <?=( in_array_r( $current, $group_pages ) )?"class='nav-item active open'":"class='nav-item '" ?>>
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="<?=$group_pages[ 'icon' ] ?>"></i>
                                <span class="title"><?=$group_pages[ 'page_group_name' ] ?></span>
                                <span class="arrow <?=( in_array_r( $current, $group_pages ) )?"open":"" ?>"></span>
                            </a>
                            <ul class="sub-menu">
                            <?php 
                            	for( $j = 0 ; $j < count( $group_pages ) - 3 ; $j++ ){ ?>
	                            <li <?=($group_pages[ $j ][ 'page_name' ]==$current)?"class='nav-item active open'":"class='nav-item '" ?>>
                                    <a href="<?=WEBSITE_PROTOCOL ?>://<?=WEBSITE_DOMAIN_NAME . PAGE_NAME_ADMIN . WEBSITE_LINK_ENDS_WITH ?>?what_do_you_want=<?=$group_pages[ $j ][ 'page_name' ] ?>" 
                                    	class="nav-link ">
                                        <span class="title"><?=$group_pages[ $j ][ 'page_title' ]?></span>
                                    </a>
                                </li>
                                <?php 
                            	}
                                ?>
                            </ul>
                        </li>
                        <?php 
	                    	} }
	                    ?>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    
                </div>
                <!-- END SIDEBAR -->
                
            </div>
            <!-- END SIDEBAR -->
        
        