<?php
/**
 * Libs default config
 *
 * @category  Libs
 * @package   Libs\config
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

return [
    'service_manager' => [
        'abstract_factories' => [
            'Rest\Factory\ClientFactoryAbstract',
            'General\Factory\FormFactoryAbstract',
            'General\Service\ServiceAbstract',
            'General\Mapper\MapperAbstract',
            'General\Hydrator\HydratorAbstract',
            'General\Email'
        ],
        'factories' => [
            'Zend\Log\Logger' =>  'General\Log\Factory\LoggerFactory',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'FormElementErrors' => 'General\View\Helper\Form\FormElementErrors',
            'form' => 'General\View\Helper\Form',
            'FootScript' => 'General\View\Helper\FootScript',
            '_' => 'General\View\Helper\_'
        ],
    ],
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'numeric_functions' => [
                    'IF' => 'General\Doctrine\DQL\IFFunction'
                ],
            ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../resources/languages',
                'pattern' => '%s/Zend_Validate.php',
            ],
            [
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../resources/languages',
                'pattern' => '%s/Zend_Captcha.php',
            ],
        ],
    ],
    'cache_manager' => [
        'caches' => [
            [
                'type' => 'Filesystem',
                'path' => __DIR__ . '/../' . 'cache'
            ],
        ],
    ],
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul class="list-unstyled"><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        ],
    ],
    'email' => [
        'templates' => [
            'path' => '',
            'layout' => '',
        ],
        'smtp' => [
            'name' => '',
            'host' => '',
            'port' => '',
            'connection_class' => '',
            'connection_config' => [
                'username' => '',
                'password' => '',
//                'ssl' => 'tls',
            ],
        ],
    ],
    'rest' => [
        //The base URL of the REST API
        'api_url' => '',
        // If a static access token exists (token that does not expire)
        'access_token' => '',
        //Enable or disable the cache
        'cache_enable' => false,
        'cache_dir' => __DIR__ . '/../' . 'cache',
        // Else will retrieve a token through authentication method
        'authentication' => [
            'username' => '',
            'password' => ''
        ],
        //Zend\Http\Client Config overwrite
        'http_config' => []
    ],
];
