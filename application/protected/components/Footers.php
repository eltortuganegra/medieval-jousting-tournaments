<?php
/**
 * Headers show the header for guest o logged user.
 */
class Footers extends CWidget{
	
	/**
	 * Load data for widget template
	 */
	public function init(){
		
	}
	
	/**
	 * This method is called by CController::endWidget()
	 */
	public function run(){
		$this->render( 'footers' );
	}
	
	
	
}