<?php

class LastEvents extends CWidget{
	
	private $_events;
	public $knights_id = null;
	
	
	public function init(){
		$this->_events = KnightsEventsLast::findKnightEventLast($this->knights_id);
	}
	
	public function getLastEvents(){
		return $this->_events;
	}
	
	public function run(){
		$this->render( 'lastEvents' );
	}
	
}