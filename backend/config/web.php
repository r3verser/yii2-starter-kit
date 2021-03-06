<?php
$config = [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'=>'system-information/index',
    'controllerMap'=>[
        'file-manager-elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['manager'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => '@storageUrl',
                    'basePath' => '@storage',
                    'path'   => '/uploads',
                    'name'   => ['category' => 'app','message' => 'Uploads'], // Yii::t($category, $message)
                    'access' => ['read' => 'manager', 'write' => 'manager'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
                ]
            ]
        ]
    ],
    'components' => [
        'authManager' => [
            'defaultRoles' => ['administrator', 'manager', 'user'],
        ],

        'urlManager'=>[
            'rules'=> require('_urlRules.php')
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'request'=>[
            'cookieValidationKey'=>'yii2-starter-kit.backend',
        ],
    ],
    'as globalAccess'=>[
        'class'=>'\common\components\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['error']
            ],
            [
                'controllers'=>['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => ['manager'],
            ],

        ]
    ]
];

$config = yii\helpers\ArrayHelper::merge($base, $config);

return $config;
