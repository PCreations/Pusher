<?php

require_once App::pluginPath('Pusher') . DS . 'Vendor' . DS . 'lib' . DS . 'Pusher.php';

class PusherComponent extends Component {

	public $pusher;

	public $controller;

	private $cakeEventPrefix = 'Pusher';

	private $privatePrefix = 'private-';

	private $presencePrefix = 'presence-';

	public function __construct(ComponentCollection $collection, $settings) {
		$this->pusher = new Pusher(
			Configure::read('Pusher.credentials.appKey'),
			Configure::read('Pusher.credentials.appSecret'),
			Configure::read('Pusher.credentials.appId')
		);
	}

	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

	public function privateAuth($channel, $socketID) {
		return $this->pusher->socket_auth($channel, $socketID);
	}

	public function getChannelType($channel) {
		if(strpos($channel, $this->privatePrefix) !== false)
			return 'private';
		if(strpos($channel, $this->presencePrefix) !== false)
			return 'presence';
		return 'public';
	}
}

?>