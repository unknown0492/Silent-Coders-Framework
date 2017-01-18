<?php
	
	for( $i = 251; $i <=450 ; $i++ ){
		$user_id = "user";
		$user_id = "$user_id$i";
		$sql = "Insert into users( `user_id`, `role_id` ) VALUES( '$user_id', 1 );";
		//$sql = "UPDATE users SET `role_id` = 2 WHERE user_id = '$user_id';";
		echo "$sql <br />";
	}
?>