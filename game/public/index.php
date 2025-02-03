<?php

require_once __DIR__ . '/../vendor/autoload.php';
echo "ff";
/* application boostrap */
$appli = require_once __DIR__ . '/../config/bootstrap.php';


$appli->run();
