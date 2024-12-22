<?php

use ChocoDNA\CRISPR;

require __DIR__ . '/vendor/autoload.php';

try {
    $input = fopen('php://stdin', 'r');

    if (!$input) {
        throw new Exception('Usage: php index.php < "path/to/input.txt" > "path/to/output.txt"');
    }

    CRISPR::parseFile($input);
    CRISPR::executeChanges();
} catch (Throwable $Throwable) {
    echo $Throwable::class . ': ' . $Throwable->getMessage();
}