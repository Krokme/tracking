<?php
require_once __DIR__ . '/../conf/conf.inc.php';
require_once __DIR__.'/../bootstrap/autoload.php';

require_once __DIR__ . '/../core/App.php';

$app = new \Core\App();

$app->run();
