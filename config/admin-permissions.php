<?php

use Admin\Http\Controllers\DomainCrudController;

return [
    DomainCrudController::class => [
        'domain-list' => [
            'only' => [
                'index'
            ]
        ],
        'domain-show' => [
            'only' => [
                'show'
            ]
        ],
        'domain-create' => [
            'only' => [
                'create',
                'store'
            ]
        ],
        'domain-update' => [
            'only' => [
                'edit',
                'update'
            ]
        ],
        'domain-delete' => [
            'only' => [
                'destroy'
            ]
        ],
    ],
];
