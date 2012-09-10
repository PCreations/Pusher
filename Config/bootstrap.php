<?php
App::uses('Router', 'Routing');

Router::parseExtensions('json');

Configure::write(array(
	'Pusher' => array(
		'credentials' => array(
			'appKey' => 'c9eb8e7d6833194323cc',
			'appSecret' => 'a4acb3e917e16b69be1e',
			'appId' => '26484'
		),
		'channelAuthEndpoint' => array(
			'plugin' => 'pusher',
			'controller' => 'pusher',
			'action' => 'auth.json',
		)
	)
));

?>