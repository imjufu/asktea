<?php

$app = require_once __DIR__.'/bootstrap.php';

$app->mount('/', new Asktea\Provider\Controller\Common());

return $app;
