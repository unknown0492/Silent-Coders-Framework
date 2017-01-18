<?php
	/* $file = fopen( "../webservice/functions/sub-functions.php", "r+" ) or die( 's' );
	$new = "include( 'aaa.php' );";
	$count = 0;
	$ss = "";
	$arr = array();
	while( ( $s = fgets( $file ) ) != NULL ){
		if( $count == 1 ){
			$arr[ 1 ] = $new;
			$count++;
			continue;
		}
		$arr[ $count++ ] = $s;
		//echo "$s <br />";
	}
	// echo $ss;
	print_r( $arr ); */
	
	$file = fopen( "../webservice/functions/sub-functions.php", "r+" );
	$arr = array();
	$i = 0;
	$files = array( "abc.php", "cyz.php" );
	for( $i = 0 ; $i < count( $files ) ; $i++ ){
		$t = $files[ $i ];
		$f = "\tinclude( '$t' );\n";
		$arr[ $i ] = $f;
	}
	print_r( $arr );
		
	$new_arr = array();
	$count = 0;
	$ss = "";
	while( ( $s = fgets( $file ) ) != NULL ){
		if( $count == 1 ){
			for( $i = 0 ; $i < count( $files ) ; $i++ ){
				$new_arr[ $count++ ] = $arr[ $i ];
			}
			continue;
		}
		$new_arr[ $count++ ] = $s;
		//echo "$s <br />";
	}
	fclose( $file );
	print_r( $new_arr );
	$fi = fopen( "a.php", "w+" );
	for( $i = 0 ; $i < count( $new_arr ) ; $i++ ){
		fprintf( $fi, $new_arr[ $i ] );
	}
?>