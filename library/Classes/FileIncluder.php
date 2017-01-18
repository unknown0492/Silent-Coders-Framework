<?php
	
	class FileIncluder{
		
		public $jqueryMin = "s";
		public $jqueryFull = "s";
		public $angularMin = "s";
		public $angularFull = "s";
		
		/* function __construct(){
			
		}
		 */
		function setJqueryMin( $jqueryMin ){
			$this->jqueryMin = $jqueryMin;
		}
		
		function getJqueryMin(){
			return $this->jqueryMin;
		}
		
		function setJqueryFull( $jqueryFull ){
			$this->jqueryFull = $jqueryFull;
		}
		
		function getJqueryFull(){
			echo '<script src="' . $this->jqueryFull . '" type="text/javascript"></script>';
		}
		
		function setAngularMin( $angularMin ){
			$this->angularMin = $angularMin;
		}
		
		function getAngularMin(){
			return $this->angularMin;
		}
		
		function setAngularFull( $angularMin ){
			$this->angularMin = $angularMin;
		}
		
		function getAngularFull(){
			return $this->angularMin;
		}
		
	}
	
	$fileIncluder = new FileIncluder;
	$fileIncluder->setJqueryMin( "js/jquery-3.1.0.min.js" );
	$fileIncluder->setJqueryFull( "js/jquery-3.1.0.js" );
	$fileIncluder->setAngularMin( "js/angular.min.js" );
	$fileIncluder->setAngularFull( "js/angular.js" );
	
?>