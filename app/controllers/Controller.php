<?php

class Controller {
	
	protected $f3;
    protected $db;
	
	function beforeroute(){
		//in case we need something before the route
	}

	function afterroute(){
		//in case we need something after the route
	}
	
	function renderView($filename){
		echo Template::instance()->render($this->f3->get('VIEWS').$filename);
	}
	
	function __construct() {
		
		$f3=Base::instance();
		$this->f3=$f3;

	    $db=new DB\SQL(
	        $f3->get('devdb'),
	        $f3->get('devdbusername'),
	        $f3->get('devdbpassword'),
	        array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
	    );

	    $this->db=$db;
	}
}
?>