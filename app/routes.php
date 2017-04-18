<?php

$app->get('/version', function () {
    echo 'HXPHP Version ' . HXPHP_VERSION;
});

$app->get('/', 'Controllers\IndexController@index');
