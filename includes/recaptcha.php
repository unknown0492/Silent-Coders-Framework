<?php 
	require_once('recaptchalib.php');
	$publickey = "6LcxTPYSAAAAAMcRyf7H5kFRA7HR_tA11nO4zJC3"; // you got this from the signup page
	echo recaptcha_get_html($publickey);
?>


    