<?php 
	include 'library/functions.php';
	include 'library/custom_functions.php';
	
	if( isLoggedIn() ){
		redirect( PAGE_NAME_ADMIN . WEBSITE_LINK_ENDS_WITH );
	}
	
	$site_config = getSiteConfig();
	
?>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
    <!-- BEGIN HEAD -->

	<head>
        <meta charset="utf-8" />
        <title>Login</title>
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
	$formLogin = new FormHelper( "form_login" );
	
	$userIDText = new FormField( "text", array( 
			"class"=>"form-control placeholder-no-fix",
			"id"=>"user_id",
			"name"=>"user_id",
			"ngValidated"=>"false",
			/* "ng-model"=>"user_id",
			"ng-pattern"=>"VLDTN_USER_ID", */
			"required"=>"required",
			"placeholder"=>"Username",
			"form-name"=>$formLogin->getFormName()
	), NULL );
	
	$password = new FormField( "password", array(
			"class"=>"form-control placeholder-no-fix",
			"id"=>"password",
			"name"=>"password",
			"ngValidated"=>"false",
			"autocomplete"=>"off",
			/* "ng-model"=>"password",
			"ng-pattern"=>"VLDTN_PASSWORD", */
			"required"=>"required",
			"placeholder"=>"Password",
			"form-name"=>$formLogin->getFormName()
	), NULL );
	
	
	$formForgotPassword = new FormHelper( "form_forgot_password" );
	
	$emailText = new FormField( "text", array(
			"class"=>"form-control",
			"name"=>"email",
			"id"=>"email", 
			"ngValidated"=>"true",
			"ng-model"=>"email", 
			"placeholder"=>"Your Registered Email",
			"ng-pattern"=>"VLDTN_EMAIL", 
			"required"=>"required",
			"form-name"=>$formForgotPassword->getFormName()
	), NULL );
	
	$hiddenForgotPassword = new FormField( "hidden", array(
			"name"=>"what_do_you_want",
			"id"=>"what_do_you_want",
			"value"=>"reset_own_password"
	), NULL );
	
	$buttonForgotPassword = new FormField( "button", array(
			"id"=>"btn_" . $formForgotPassword->getFormName(),
			"class"=>"btn blue",
			"ng-click"=>"resetPassword( ". $formForgotPassword->getFormName()." );",
			"form-name"=>$formForgotPassword->getFormName(),
			"ng-disabled"=>$formForgotPassword->getFormName() . '.$invalid'
	), "Reset Password" );
	
	
	?>

	<body class="login" ng-app="loginApp" ng-controller="loginCtrl">
	
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="<?=$site_config->login_page_logo ?>" alt="Logo" style="height: 100px;" /> </a>
        </div>
        <!-- END LOGO -->
        
        <!-- BEGIN LOGIN -->
        <div class="content">
            
            <!-- BEGIN LOGIN FORM -->
            <form class="" method="POST" ng-submit="submitForm( $event );">
            
                <h3 class="form-title">Login to your account</h3>
                <div id="form_login_message" class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                
                <div class="form-group">
                    <!-- ie8, ie9 does not support html5 placeholder, so we just show field title for that -->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <?=$userIDText->generateField() ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <?=$password->generateField() ?>
                    </div>
                </div>
                
                <div class="form-actions">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" /> Remember me
                        <span></span>
                    </label>
                    <button type="submit" class="btn green pull-right" name="button_login" id="button_login"> Login </button>
                </div>
                
                <?php if( isForgotPasswordOptionEnabled() ){ ?>
                <div class="forget-password">
                	<h4>Forgot your password ?</h4>
                    <p> no worries, click
                        <a href="#modal-forgot-password" data-toggle="modal" style="" ng-click="openForgotPasswordModal();"> here </a> to reset your password. </p>
                </div>
                <?php } ?>
                
                <?php if( isRegistrationOpen() ){ ?>
                <div class="create-account">
                    <p> Don't have an account yet ?&nbsp;
                        <a href="register.php" style=""> Create an account </a>
                    </p>
                </div>
                <?php } ?>
                
            </form>
            <!-- END LOGIN FORM -->
            
            
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright"> 2014 &copy; Metronic - Admin Dashboard Template. </div>
        <!-- END COPYRIGHT -->


		<div class="modal fade bs-modal-sm" id="modal-forgot-password" tabindex="-1" role="basic"
			aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header  bg-blue bg-font-blue">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true"></button>
						<h4 class="modal-title">Forgot Password</h4>
					</div>
					<div class="modal-body">
						<form id="<?=$formForgotPassword->getFormName() ?>" name="<?=$formForgotPassword->getFormName() ?>" 
							  ng-model="<?=$formForgotPassword->getFormName() ?>" method="POST">
		                	<div class="row">
		                    	<div class="col-lg-12">
		                        	<div class="form-group password_reset_form">
		                        		<p class="help-block" style="font-size: 13px; text-align: center; color: rgb(102,102,102);">If the email exists with us, a password reset link will be sent to the email !</p>
		                            	<label style="color: #777;">Email*</label>
		                                <?=$emailText->generateField() ?>
		                                	
		                                <?=$hiddenForgotPassword->generateField() ?>
		                                
		                                
		                            </div>
		                            <div class="form-group password_reset_success_message hidden">
		                            	<p class="help-block" style="color: green; color: green; text-align: center; font-size: 17px;">Please check your email for password reset link</p>
		                            </div>
		                        </div>
		                    </div>
	                    </form>
					</div>
					<div class="modal-footer text-center password_reset_form">
	                	<?=$buttonForgotPassword->generateField() ?>
	                </div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
										
    <div class="quick-nav-overlay"></div> <!-- Overlay Element. Important: place just after last modal -->
        

        
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
		<script src="js/login.js"></script>
    </body>





</html>
