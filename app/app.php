<?php

$app = require_once __DIR__.'/bootstrap.php';

$app->mount('/', new Asktea\Provider\Controller\Common());
$app->mount('/question', new Asktea\Provider\Controller\Question());
$app->mount('/vote', new Asktea\Provider\Controller\Vote());

return $app;
