<?php

define('HOST_NAME', 'slim-admin.localhost');
define('USE_DATABASE', true);

define('HOME_HTML',
<<<HTML
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    </head>
    <body>
        <input id="csrf" type="hidden" value="%s">
        <div id="app"></div>
        <script src="/static/js/bundle.js"></script>
    </body>
</html>
HTML
);
