<?php

$app = require_once __DIR__.'/bootstrap.php';

$app->mount('/', new Asktea\Provider\Controller\Common());
$app->mount('/question', new Asktea\Provider\Controller\Question());

return $app;
