<?php 
	session_start();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        
	<?php
		include( "./includes/header.php" );			
	?>
	
	<!-- Link tags starts here -->
	<?php
		include( './includes/css.php' );
	?>
	<!-- Link tags ends here  -->
	
	
	<?php include './includes/header-scripts.php'; ?>
    </head>

	<body class="page-container-bg-solid page-header-fixed page-sidebar-fixed page-md">
		<!-- Hook : <?=HOOK_AFTER_BODY_STARTS ?> -->
		<?php 
			echo getHookContent( HOOK_AFTER_BODY_STARTS );
		?>
		<!-- /Hook : <?=HOOK_AFTER_BODY_STARTS ?> -->
		
        <?php
			include( './includes/navbar.php' );
		?>

		<?php
			include( $current_page_name . '.php' );
		?>
	
		<?php
			include( './includes/footer.php' );
		?>
		<!-- Hook : <?=HOOK_AFTER_FOOTER ?> -->
		<?php 
			echo getHookContent( HOOK_AFTER_FOOTER );
		?>
		<!-- /Hook : <?=HOOK_AFTER_FOOTER ?> -->
		
        <?php include( 'includes/modals.php' ); ?>
        
        <!-- Hook : <?=HOOK_BEFORE_BODY_ENDS ?> -->
		<?php 
			echo getHookContent( HOOK_BEFORE_BODY_ENDS );
		?>
	    <!-- /Hook : <?=HOOK_BEFORE_BODY_ENDS ?> -->
	    
    </body>
</html>