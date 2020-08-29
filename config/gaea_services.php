<?php

return [
    'uac-simple-api' => [
        /**
         * 是否开启服务端
         */
        'service' => 1,

        /**
         * 接口映射列表
         */
        'implements' => [
            \Com\Clay\UacSimpleApi\Service\UserInterface::class => \App\Services\UserService::class,
            \Com\Clay\UacSimpleApi\Service\DepartmentInterface::class => \App\Services\DepartmentService::class,
            \Com\Clay\UacSimpleApi\Service\ResourceInterface::class => \App\Services\ResourceService::class,
            \Com\Clay\UacSimpleApi\Service\RelationInterface::class => \App\Services\RelationService::class,
        ],

        /**
         * 开启认证
         */
        'auth' => 1,

        /**
         * 服务端地址
         */
        'host' => 'http://uac.test',
    ]
];
