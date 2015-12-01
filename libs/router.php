<?php

/**
 * Routing
 *
 * @author t.jancik
 */
class router {
    private $controller;
    private $method;
    
    private $get = array();
    private $post = array();
    
    /**
     * Constructor - only call routein if required
     * @param string $uri
     */
    public function __construct($uri) {
	if(!empty($uri)) {
	    $this->routein($uri);
	}
    }
    
    /**
     * Translate URI to controller / method and GET params
     * @param type $uri
     */
    public function routein($uri) {
		// get GET params
		$uri = ltrim($uri, '/');
		$idx = strpos($uri, '?');
		
		if($idx) {
			$get = explode('&', substr($uri, $idx+1));
			$uri = substr($uri, 0, $idx);
		
			foreach($get as $param) {
				$idx = strpos($param, '=');
				$this->get[substr($param, 0, $idx)] = substr($param, $idx+1);
			}
		}
		
		$uri = explode('/', $uri);
		$this->controller = $uri[0] ?: 'home';
		$this->method = $uri[1] ?: 'index';
		$ex = array_slice($uri, 2);
    }
    
    public function routeout($controller, $method, $get = array(), $post = array()) {
	
    }
    
    /**
     * Return the controller name
     * @return string
     */
    public function getController() {
	return $this->controller;
    }
    
    /**
     * Return the method / action name
     * @return string
     */
    public function getMethod() {
	return $this->method;
    }
}
