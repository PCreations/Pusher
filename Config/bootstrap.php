<?php
App::uses('Router', 'Routing');

Router::parseExtensions('json');

Configure::write(array(
	'Pusher' => array(
		'credentials' => array(
			'appKey' => 'YOUR_APP_KEY',
			'appSecret' => 'YOUR_APP_SECRET',
			'appId' => 'YOUR_APP_ID'
		),
		'channelAuthEndpoint' => array(
			'plugin' => 'pusher',
			'controller' => 'pusher',
			'action' => 'auth.json',
		)
	)
));

?>