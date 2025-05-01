<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Hello;

$hello = new Hello();

echo $hello->greet();

