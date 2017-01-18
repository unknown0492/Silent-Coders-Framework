					<!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile"><?=$_SESSION[ 'fname' ] . " " . $_SESSION[ 'lname' ] ?></span>
                                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                    <img alt="" class="img-circle" src="images/avatar/no-avatar.png" /> </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                <?php 
		                            if( havePrivilege( "update_profile", false ) ){
		                        ?>
			                    	<li>
		                            	<a href="<?=WEBSITE_PROTOCOL ?>://<?=WEBSITE_DOMAIN_NAME . PAGE_NAME_ADMIN . WEBSITE_LINK_ENDS_WITH ?>?what_do_you_want=profile">
		                                	<i class="icon-user"></i> My Profile </a>
		                            </li>
	                            <?php 
	                            	}
	                            ?>
                                    <li>
                                        <a href="webservice.php?what_do_you_want=logout">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
