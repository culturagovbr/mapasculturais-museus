<?php

return [
    'app.enabled.projects'          => true,
    'app.enabled.events'            => true,
    'app.enabled.apps'              => false,
    'app.enabled.seals'             => true,
    'museus.ownerAgentId'           => 11348,
    // 'notifications.entities.update' => 1825,
    'notifications.entities.update' => 0,
    'notifications.user.access'     => 182,
    'notifications.seal.toExpire'   => 0,
    'routes' => [
        'readableNames' => [
            'impressao' => \MapasCulturais\i::__('Registro de Museus')
        ]
    ]
];
