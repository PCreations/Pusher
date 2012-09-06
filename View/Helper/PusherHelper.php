<?php

class PusherHelper extends Helper {
	
	public $helpers = array('Html');

	private $appKey = '';

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->apiKey = Configure::read('Pusher.credentials.appKey');
	}

	
}

?>