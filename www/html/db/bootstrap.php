<?php

ActiveRecord\Config::initialize(function($cfg) {
   $env = DB['environments'];
   $cfg->set_model_directory(DB['paths']['models']);
   $cfg->set_connections([
      'local' => "{$env['local']['adapter']}://{$env['local']['user']}:{$env['local']['pass']}@{$env['local']['host']}:{$env['local']['port']}/{$env['local']['name']}",
      'development' => "{$env['development']['adapter']}://{$env['development']['user']}:{$env['development']['pass']}@{$env['development']['host']}:{$env['development']['port']}/{$env['development']['name']}",
      'production' => "{$env['production']['adapter']}://{$env['production']['user']}:{$env['production']['pass']}@{$env['production']['host']}:{$env['production']['port']}/{$env['production']['name']}"
   ]);
   $cfg->set_default_connection($env['default_database']);
});
