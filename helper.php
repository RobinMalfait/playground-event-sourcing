<?php

function dd() {
    array_map(function($var) { var_dump($var); }, func_get_args());
}

/* Test Framework In A Tweet! */
function it($m, $p){
    echo ($p ? "\033[32m✔" : "\033[31m✘") . " It $m\n";
}
