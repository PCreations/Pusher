# Pusher plugin for CakePHP 2.x

This plugin provides a simple access to [Pusher API] (http://pusher.com/) via [the generic PHP Pusher library] (https://github.com/pusher/pusher-php-server).
This plugin also provides a way to generate all the javascript stuff with the Helper

Installation
------------

Copy to your application plugins folder and load it in your bootstrap file :

	CakePlugin::load('Pusher', array('
		'bootstrap' => true
	'));

Add the Pusher component and the Pusher helper in your components/helpers list :
	
	public $components = array('Pusher.Pusher');

	public $helpers = array('Pusher.Pusher');

Your application needs to be register on [Pusher website] (http://pusher.com/). Open the Pusher/Config/bootstrap.php file and set your credentials.

How to use it
-------------

### Trigger Event

Subscribing to a channel is very simple. It's a server-side flow. In your controller just do the following :

	//Some event information
	$data = array('message' => 'Something happened');

	//Trigger an event named EVENT_NAME on the CHANNEL_NAME channel. You can use private and presence channel by prefixing the name by private- or presence-. See pusher docs (http://pusher.com/docs/client_api_guide/client_channels) for details
	$this->Pusher->trigger(CHANNEL_NAME, EVENT_NAME, $data);

### Subscribe to a channel

"Receiving" a pushed event is a client-side flow, enjoy the realtime functionnality using Pusher Helper for generating javascript stuff :

	$this->Pusher->subscribe(CHANNEL_NAME);
	//The third argument receive string will be parsed as javascript.
	$this->Pusher->bindEvent(CHANNEL_NAME, EVENT_NAME, "console.log('An event was triggered with message '+data.message+');");

### Authentication with private channels

When using private channel, authentication is handled by the Pusher Controller. Your app need to be an authenticate app to use this functionnality.

Example
-------

A very simple example could be this :

	//Controller/FooController.php
	public $components = array('Auth', 'Pusher.Pusher');

	public $helpers = array('Pusher.Pusher');

	public function push() {
		$data = array(
			'message' => 'Something happened !',
			'triggerBy' => $this->Auth->user('username')
		);
		$this->Pusher->trigger('private-my-great-channel', 'foo_bar', $data);
	}

	public function receive() {

	}

	//View/Foo/receive.ctp
	$this->Pusher->subscribe('private-my-great-channel');
	$this->Pusher->bindEvent('private-my-great-channel', 'foo_bar', 'console.log("An event was triggered by "+data.triggeredBy+" with message "+data.message+);');

Open your browser and open in one widget yourapp/foo/receive and in an another widget yourapp/foo/push. When you'll push the event you shoul see the message in your javascript console. If not, checks the ajax request to auth/ because you need to be authenticate since you're subscribing to a private channel.

Functionnalities not include yet
------------------------------

The auth for presence channel is not handled yet

