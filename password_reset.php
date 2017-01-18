<?php
	include 'library/functions.php';
	include 'library/custom_functions.php';
	
	if( ! isForgotPasswordOptionEnabled() ){
		alert( 'You are not allowed to Reset your password right now. Please contact the Administrator.' );
		//redirect( WEBSITE_PROTOCOL . "://" . WEBSITE_DOMAIN_NAME . PAGE_LOGIN );
		redirect( PAGE_LOGIN );
		exit();
	}
	
	/**
	 * 
	 * 1. if URL parameter `code` is not set, display error -> This page has expired
	 * 2. if URL parameter `code` is set, if password_reset_code does not exist in DB , Display error -> Password reset Link has been expired
	 * 3. if URL parameter `code` is set, if password_reset_expiry >= 24 , Display error -> Password reset Link has been expired
	 * 4. if URL parameter `code` is set, if password_reset_expiry < 24, Display password reset page
	 * 
	 */
	
	// 1.
	if( ! isset( $_REQUEST[ 'code' ] ) ){
		alert( "This page has been expired" );
		redirect( PAGE_LOGIN );
		exit();
	}
	
	// 2.
	$password_reset_code = $_GET[ 'code' ];
	$sql = "SELECT user_id, password_reset_expiry, email FROM users WHERE password_reset_code='$password_reset_code'";
	$result_set = selectQuery( $sql );
	
	if( mysqli_num_rows( $result_set ) == 0 ){
		alert( "Password Reset Link has been expired, please redo the password reset process again on the Login Page" );
		redirect( PAGE_LOGIN );
		exit();
	}
	
	// 3. 
	$val = mysqli_fetch_object( $result_set );
	$password_reset_expiry = $val->password_reset_expiry;
	$current_time = currentTimeMilliseconds();
	
	if( isPasswordResetValidityExpired( $current_time, $password_reset_expiry ) ){
		alert( "Password Reset Link has been expired, please redo the password reset process again on the Login Page" );
		redirect( PAGE_LOGIN );
		exit();
	}
	
	// 4. 
	//
	//..
	//...
	//....
	
	
	
	
?>
<!DOCTYPE html>
<html class="no-js sidebar-large">

	<head>
        <meta charset="utf-8" />
        <title>Password Reset</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content=""
              name="description" />
        <meta content="" name="author" />
        
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/pages/css/login-4.min.css" rel="stylesheet" type="text/css" />
        <link href="css/animate.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        
        <!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon/favicon.ico">
		<link rel="icon" type="image/png" href="images/favicon/favicon.png" sizes="256x256">
		<link rel="apple-touch-icon" sizes="256x256" href="images/favicon/favicon.png">
		<!-- /Favicon -->
	</head>
	
	<?php 
	
	$formPasswordReset = new FormHelper( "form_password_new" );
	
	$password = new FormField( "password", array(
			"class"=>"form-control placeholder-no-fix",
			"id"=>"password_new",
			"name"=>"password_new",
			"ngValidated"=>"true",
			"autocomplete"=>"off",
			"ng-model"=>"password_new",
			"ng-pattern"=>"VLDTN_PASSWORD",
			"required"=>"required",
			"placeholder"=>"New Password",
			"form-name"=>$formPasswordReset->getFormName()
	), NULL );
	
	$passwordRe = new FormField( "password", array(
			"class"=>"form-control placeholder-no-fix",
			"id"=>"password_new_repeat",
			"name"=>"password_new_repeat",
			"ngValidated"=>"true",
			"autocomplete"=>"off",
			"ng-model"=>"password_new_repeat",
			"ng-pattern"=>"VLDTN_PASSWORD",
			"required"=>"required",
			"placeholder"=>"Re Enter Password",
			"form-name"=>$formPasswordReset->getFormName()
	), NULL );
	
	$hiddenWhat = new FormField( "hidden", array(
			"id"=>"what_do_you_want",
			"name"=>"what_do_you_want",
			"form-name"=>$formPasswordReset->getFormName(),
			"value"=>"change_reset_password"
	), NULL );
	
	$hiddenPassResetCode = new FormField( "hidden", array(
			"id"=>"password_reset_code",
			"name"=>"password_reset_code",
			"form-name"=>$formPasswordReset->getFormName(),
			"value"=>$password_reset_code
	), NULL );
	
	$submitPassReset = new FormField( "submit", array(
			"id"=>"btn_" . $formPasswordReset->getFormName(),
			"name"=>"btn_" . $formPasswordReset->getFormName(),
			"class"=>"btn green pull-right",
			"ng-disabled"=>$formPasswordReset->getFormName().'.$invalid || (password_new!=password_new_repeat)',
			"form-name"=>$formPasswordReset->getFormName(),
	), "Submit" );
	
	$resetPassReset = new FormField( "reset", array(
			"id"=>"reset_" . $formPasswordReset->getFormName(),
			"name"=>"reset_" . $formPasswordReset->getFormName(),
			"class"=>"hidden",
			"form-name"=>$formPasswordReset->getFormName(),
	), "Reset" );
	
	
	?>

<body class="login" ng-app="passwordValidation" ng-controller="passwordController" >
	
	<!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="images/logo/horizontal-cms-logo.png" alt="Logo" style="height: 100px;" /> </a>
        </div>
        <!-- END LOGO -->
        
        <!-- BEGIN LOGIN -->
        <div class="content">
            
            <!-- BEGIN LOGIN FORM -->
            <form class="" method="POST" ng-submit="submitForm( <?=$formPasswordReset->getFormName() ?>, $event );"
            	  name="<?=$formPasswordReset->getFormName() ?>" id="<?=$formPasswordReset->getFormName() ?>" ng-model="<?=$formPasswordReset->getFormName() ?>">
            	  <?php 
            	  $f = $formPasswordReset->getFormName();
            	  ?>
            
                <h3 class="form-title">Set New Password</h3>
                <div id="form_password_new_message" class="alert alert-danger hidden">
                    <button class="close" data-close="alert"></button>
                    <span id="reset_message"> Your Password Reset Code has Expired. </span>
                </div>
                
                <div class="form-group">
                    <!-- ie8, ie9 does not support html5 placeholder, so we just show field title for that -->
                    <label class="control-label visible-ie8 visible-ie9">New Password</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <?=$password->generateField() ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Re Enter New Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <?=$passwordRe->generateField() ?>
                        <p class="help-block font-red" ng-show="<?=$f.".".$password->getParam( "id" ) ?>.$touched && <?=$f.".".$passwordRe->getParam( "id" ) ?>.$touched && (<?=$password->getParam( "id" ) ?>!=<?=$passwordRe->getParam( "id" ) ?>)">Both passwords do not match</p>
                    </div>
                </div>
                
                <div class="form-actions">
                	<?=$hiddenWhat->generateField() ?>
                	<?=$hiddenPassResetCode->generateField() ?>
                	
                    <?=$submitPassReset->generateField() ?>
                    <?=$resetPassReset->generateField() ?>
                    <br />
                </div>
                
                
                
            </form>
            <!-- END LOGIN FORM -->
            
            
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright"> 2014 &copy; Metronic - Admin Dashboard Template. </div>
        <!-- END COPYRIGHT -->
	
	
	
	
		
	  <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/login-4.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <script src="js/angular.js"></script>
		<script src="js/custom.js"></script>
		<script src="js/password_reset.js"></script>
</body>





</html>