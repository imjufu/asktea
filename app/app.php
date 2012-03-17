<?php

$app = require_once __DIR__.'/bootstrap.php';

$app->mount('/', new Asktea\Provider\Controller\Common());
$app->mount('/question', new Asktea\Provider\Controller\Question());
$app->mount('/vote', new Asktea\Provider\Controller\Vote());
$app->mount('/admin', new Asktea\Provider\Controller\Admin());
$app->mount('/comment', new Asktea\Provider\Controller\Comment());
$app->mount('/search', new Asktea\Provider\Controller\Search());

return $app;
