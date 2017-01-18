<?php 
	include 'library/functions.php';
	include 'library/custom_functions.php';
	
	if( isLoggedIn() ){
		redirect( PAGE_NAME_ADMIN . WEBSITE_LINK_ENDS_WITH );
	}
	
	if( ! isRegistrationOpen() ){ 
		redirect( PAGE_NAME_ADMIN . WEBSITE_LINK_ENDS_WITH );
	}
	
?>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
    <!-- BEGIN HEAD -->

	<head>
        <meta charset="utf-8" />
        <title>Register</title>
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
	$formRegister = new FormHelper( "form_register" );
	
	$userIDText = new FormField( "text", array( 
			"class"=>"form-control placeholder-no-fix",
			"id"=>"user_id",
			"name"=>"user_id",
			"ngValidated"=>"true",
			"ng-model"=>"user_id",
			"ng-pattern"=>"VLDTN_USER_ID",
			"required"=>"required",
			"placeholder"=>"Username*",
			"ng-blur"=>"isUserIdAvailable()",
			"ng-change"=>"userIdChanged()",
			"form-name"=>$formRegister->getFormName()
	), NULL );
	
	$password = new FormField( "password", array(
			"class"=>"form-control placeholder-no-fix",
			"id"=>"password",
			"name"=>"password",
			"ngValidated"=>"true",
			"autocomplete"=>"off",
			"ng-model"=>"password",
			"ng-pattern"=>"VLDTN_PASSWORD",
			"required"=>"required",
			"placeholder"=>"Password*",
			"form-name"=>$formRegister->getFormName()
	), NULL );
	
	$passwordRe = new FormField( "password", array(
			"class"=>"form-control placeholder-no-fix",
			"id"=>"password_confirm",
			"name"=>"password_confirm",
			"ngValidated"=>"true",
			"autocomplete"=>"off",
			"ng-model"=>"password_confirm",
			"ng-pattern"=>"VLDTN_PASSWORD",
			"required"=>"required",
			"placeholder"=>"Confirm Password*",
			"form-name"=>$formRegister->getFormName()
	), NULL );
	
	
	
	$emailText = new FormField( "text", array(
			"class"=>"form-control",
			"name"=>"email",
			"id"=>"email", 
			"ngValidated"=>"true",
			"ng-model"=>"email", 
			"placeholder"=>"Your Email*",
			"ng-pattern"=>"VLDTN_EMAIL", 
			"required"=>"required",
			"form-name"=>$formRegister->getFormName()
	), NULL );
	
	$textFName	= new FormField( "text", array(
			"class"=>"form-control",
			"id"=>"fname",
			"name"=>"fname",
			"ngValidated"=>"true",
			"ng-model"=>"fname",
			"ng-pattern"=>"VLDTN_FIRST_NAME",
			"placeholder"=>"First Name",
			"form-name"=>$formRegister->getFormName()
	), NULL );
	
	$textLName	= new FormField( "text", array(
			"class"=>"form-control",
			"id"=>"lname",
			"name"=>"lname",
			"ngValidated"=>"true",
			"ng-model"=>"lname",
			"ng-pattern"=>"VLDTN_LAST_NAME",
			"placeholder"=>"Last Name",
			"form-name"=>$formRegister->getFormName()
	), NULL );
	
	
	
	$hiddenRegister = new FormField( "hidden", array(
			"name"=>"what_do_you_want",
			"id"=>"what_do_you_want",
			"value"=>"register_user"
	), NULL );
	
	$submitRegister = new FormField( "submit", array(
			"id"=>"submit_" . $formRegister->getFormName(),
			"name"=>"submit_" . $formRegister->getFormName(),
			"class"=>"btn blue pull-right",
			"form-name"=>$formRegister->getFormName(),
			"ng-disabled"=>$formRegister->getFormName() . '.$invalid'
	), "Register" );
	
	
	?>

	<body class="login" ng-app="registerApp" ng-controller="registerCtrl">
	
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="images/logo/horizontal-cms-logo.png" alt="Logo" style="height: 100px;" /> </a>
        </div>
        <!-- END LOGO -->
        
        <!-- BEGIN Registration -->
        <div class="content">
            
            <!-- BEGIN Registration FORM -->
            <form class="" method="POST" id="<?=$formRegister->getFormName() ?>" name="<?=$formRegister->getFormName() ?>" ng-submit="submitForm( <?=$formRegister->getFormName() ?>, $event );">
            	<?php $f = $formRegister->getFormName() ?>
                <h3 class="form-title">Create new account</h3>
                
                <div class="form-group">
                    <!-- ie8, ie9 does not support html5 placeholder, so we just show field title for that -->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <?=$userIDText->generateField() ?>
                        <span id="user_id_message" class="help-block hidden font-green"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <?=$password->generateField() ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <?=$passwordRe->generateField() ?>
                        <p class="help-block font-red" ng-show="<?=$f.".".$password->getParam( "id" ) ?>.$touched && <?=$f.".".$passwordRe->getParam( "id" ) ?>.$touched && (<?=$password->getParam( "id" ) ?>!=<?=$passwordRe->getParam( "id" ) ?>)">Both passwords do not match</p>
                    </div>
                </div>
                
                <div class="form-group">
                	<label class="control-label visible-ie8 visible-ie9">Email</label>
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <?=$emailText->generateField() ?>
                    </div>
                </div>
                
                <div class="form-group">
                	<label class="control-label visible-ie8 visible-ie9">First Name</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <?=$textFName->generateField() ?>
                    </div>
                </div>
                
                <div class="form-group">
                	<label class="control-label visible-ie8 visible-ie9">Last Name</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <?=$textLName->generateField() ?>
                    </div>
                </div>
                
                <div class="form-actions">
                	<?=$hiddenRegister->generateField() ?>
                	<a href="login.php" class="btn red">Back</a>
                    <?=$submitRegister->generateField() ?>
                </div>
                
                
            </form>
            <!-- END Registration FORM -->
            
            
        </div>
        <!-- END Registration -->
        
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
		<script src="js/register.js"></script>
    </body>





</html>
