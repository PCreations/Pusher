<?php

App::uses('String', 'Utility');

class PusherHelper extends Helper {
	
	public $helpers = array('Html', 'Js');

	private $appKey = '';

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->appKey = Configure::read('Pusher.credentials.appKey');
		$this->Js->buffer('var pusher = new Pusher(\'' . $this->appKey . '\');');
		$this->Js->buffer('Pusher.channel_auth_endpoint = \''. $this->url(Configure::read('Pusher.channelAuthEndpoint')) .'\'');
	}

	public function afterRender($layout) {
		echo $this->Html->script('http://js.pusher.com/1.12/pusher.min.js', array('inline' => false));
		echo $this->Js->writeBuffer(array('inline' => false));
	}

	public function subscribe($channelName, $type = 'public') {
		$channelName = strtolower($channelName);
		$channelName = ($type == 'private' || $type == 'presence') ? $type . '-' . $channelName : $channelName;
		$this->Js->buffer('pusher.subscribe(\'' . $channelName . '\')');
	}

	public function bindChannelEvent($channelName, $event, $script) {
		$this->Js->buffer(
			$this->getChannel($channelName) . '.bind("' . $event . '", function(data) {
				' . $script . '
			});'
		);
	}

	public function bindChannel($channelName, $script) {
		$this->Js->buffer(
			$this->getChannel($channelName) . '.bind_all(function(data) {
				' . $script . '
			});'
		);
	}

	public function bindEvent($event, $script) {
		$this->Js->buffer(
			'pusher.bind("' . $event . '", function(data) {
				' . $script . '
			});'
		);
	}

	public function bindAll($script) {
		$this->Js->buffer(
			'pusher.bind_all(function(data) {
				' . $script . '
			});'
		);
	}

	private function getChannel($channelName) {
		return 'pusher.channel(\'' . $channelName . '\')';
	}
}

?>