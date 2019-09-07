<?php

define('DATABASE', [
    'model_drectory' => __DIR__ . '/model',
    'connections' => [
        'local' => 'mysql://root:root@db/slime_admin',
        'development' => 'mysql://username:password@localhost/development_slime_admin',
        'production' => 'mysql://username:password@localhost/production_slime_admin'
    ],
    'default' => 'local'
]);
