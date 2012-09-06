<?php

require_once App::pluginPath('Pusher') . DS . 'Vendor' . DS . 'lib' . DS . 'Pusher.php';

App::uses('CakeEventManager', 'Event');
App::uses('CakeEvent', 'Event');

class PusherComponent extends Component {

	public $pusher;

	public $controller;

	private $cakeEventPrefix = 'Pusher';

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

	public function trigger($channel, $event, $data) {
		$this->controller->getEventManager()->dispatch(
			new CakeEvent(
				$this->buildCakeEventName($channel, $event),
				$this->controller,
				$data
			)
		);
		$this->pusher->trigger($channel, $event, $data);
	}

	private function buildCakeEventName($channel, $event) {
		return $this->cakeEventPrefix . '.' . Inflector::camelize($channel) . '.' . Inflector::camelize($event);
	}



}

?>