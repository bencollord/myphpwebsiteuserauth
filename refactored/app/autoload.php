<?php

use MyCodeLab\System\ClassLibrary;

require_once '../lib/System/ClassLibrary.php';

$framework = new ClassLibrary('MyCodeLab', 'lib');
$appCode   = new ClassLibrary('MyPhpWebsiteUserAuth', 'app/classes');

$framework->register();
$appCode->register();
