<?php

require_once __DIR__ . '/config.php';

ActiveRecord\Config::initialize(function($cfg) {
   $cfg->set_model_directory(DATABASE['model_directory']);
   $cfg->set_connections(DATABASE['connections']);
   $cfg->set_default_connection(DATABASE['default']);
});
