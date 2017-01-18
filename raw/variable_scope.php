<?php

	$i = -1;
	hey();
	hi();
	$v;
	
	function hey(){
		global $i;
		$i = 0;
	}
	
	function hi(){
		global $i;
		echo $i;
	}
?>