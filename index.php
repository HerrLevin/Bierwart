<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use Bierwart\Bierwart;    

$entry = new Bierwart();
echo($entry->printHelloWorld());

