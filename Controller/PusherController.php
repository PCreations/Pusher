<?php

class PusherController extends PusherAppController {
	
	public $components = array('Auth', 'RequestHandler', 'Pusher.Pusher');

	public function auth() {
		if($this->request->is('post') && isset($this->request->data['channel_name']) && isset($this->request->data['socket_id'])) {
			$authData = '';
			switch($this->Pusher->getChannelType($this->request->data['channel_name'])) {
				case 'private':
					$authData = $this->Pusher->privateAuth(
						$this->request->data['channel_name'],
						$this->request->data['socket_id']
					);
					break;
				case 'presence':
					//todo
					break;
				default:
					throw new MethodNotAllowedException();
					break;
			}
			$this->set('auth', $authData);
		}
		else {
			throw new MethodNotAllowedException();
		}
	}

}

?>