<?php

require 'AsciiTable.php';
require 'AsciiTableHtml.php';

$input = require_once 'data.php';

if('cli' === PHP_SAPI) {
    $table = new AsciiTable($input);
} else {
    $table = new AsciiTableHtml($input);
    echo '<style>* {font-family: monospace}</style>';
}
echo $table->output();