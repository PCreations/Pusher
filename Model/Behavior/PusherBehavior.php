<?php
require_once App::pluginPath('Pusher') . DS . 'Vendor' . DS . 'lib' . DS . 'Pusher.php';

class PusherBehavior extends ModelBehavior {
	
	public $pusher;

	private $privatePrefix = 'private-';

	private $presencePrefix = 'presence-';

	public function __construct() {
		parent::__construct();
		$this->pusher = new Pusher(
			Configure::read('Pusher.credentials.appKey'),
			Configure::read('Pusher.credentials.appSecret'),
			Configure::read('Pusher.credentials.appId')
		);
	}

	public function triggerPrivate(Model $Model, $channel, $event, $data) {
		$this->pusher->trigger($this->privatePrefix.$channel, $event, $data);
	}

	public function triggerPresence(Model $Model, $channel, $event, $data) {
		$this->pusher->trigger($this->presencePrefix.$channel, $event, $data);
	}

	public function trigger(Model $Model, $channel, $event, $data) {
		$this->pusher->trigger($channel, $event, $data);
	}

}

?>