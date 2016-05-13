<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',  //移动common\main.php到这
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    "modules" => [
        "admin" => [
            "class" => "mdm\admin\Module",
            //'layout' => 'left-menu',         //yii2-admin的导航菜单
        ],
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*',
//            'admin/*',
//            'some-controller/some-action',
//            //此处的action列表，允许任何人（包括游客）访问
//            //所以如果是正式环境（线上环境），不应该在这里配置任何东西，为空即可
//            //但是为了在开发环境更简单的使用，可以在此处配置你所需要的任何权限
//            //在开发完成之后，需要清空这里的配置，转而在系统里面通过RBAC配置权限
//        ]
//    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[
            ],
        ],
        "authManager" => [
            'class' => 'yii\rbac\DbManager',
            "defaultRoles" => ["guest"],
        ],
    ],
    'params' => $params,
];
