<?php

return array(
	'service_manager' => array(
		'abstract_factories' => array(
			'Rest\Factory\ClientFactoryAbstract',
			'General\Factory\FormFactoryAbstract',
			'General\Service\ServiceAbstract',
			'General\Mapper\MapperAbstract',
			'General\Hydrator\HydratorAbstract',
			'General\Email'
		),
	),
	'view_helpers' => array(
		'invokables' => array(
			'FormElementErrors' => 'General\View\Helper\Form\FormElementErrors',
			'form' => 'General\View\Helper\Form',
			'FootScript' => 'General\View\Helper\FootScript',
			'_' => 'General\View\Helper\_'
		)
	),
	'doctrine' => array(
		'configuration' => array(
			'orm_default' => array(
				'numeric_functions' => array(
					'IF' => 'General\Doctrine\DQL\IFFunction'
				),
			),
		),
	),
	'translator' => array(
		'translation_file_patterns' => array(
			array(
				'type' => 'phpArray',
				'base_dir' => __DIR__ . '/../resources/languages',
				'pattern' => '%s/Zend_Validate.php',
			),
			array(
				'type' => 'phpArray',
				'base_dir' => __DIR__ . '/../resources/languages',
				'pattern' => '%s/Zend_Captcha.php',
			),
		),
	),
	'cache_manager' => array(
		'caches' => array(
			array(
				'type' => 'Filesystem',
				'path' => __DIR__ . '/../' . 'cache'
			)
		),
	),
	'view_helper_config' => array(
		'flashmessenger' => array(
			'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul class="list-unstyled"><li>',
			'message_close_string'     => '</li></ul></div>',
			'message_separator_string' => '</li><li>'
		)
	),
	'email' => array(
		'templates' => array(
			'path' => '',
			'layout' => '',
		),
		'smtp' => array(
			'name' => '',
			'host' => '',
			'port' => '',
			'connection_class' => '',
			'connection_config' => array(
				'username' => '',
				'password' => '',
//				'ssl' => 'tls',
			),

		)
	),
	'rest' => array(
		//The base URL of the REST API
		'api_url' => '',
		// If a static access token exists (token that does not expire)
		'access_token' => '',
		//Enable or disable the cache
		'cache_enable' => false,
		'cache_dir' => __DIR__ . '/../' . 'cache',
		// Else will retrieve a token through authentication method
		'authentication' => array(
			'username' => '',
			'password' => ''
		),
		//Zend\Http\Client Config overwrite
		'http_config' => array()
	),
);
