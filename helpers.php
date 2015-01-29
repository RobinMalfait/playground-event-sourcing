<?php

function dd() {
    array_map(function($var) { var_dump($var); }, func_get_args());
}

/* Test Framework In A Tweet! */
function it($m, $p) {
    echo ($p ? "\033[32m✔" : "\033[31m✘") . " It $m\033[0m\n";
}

function throws($exp, Closure $cb) {
    try{
        $cb();
    } catch(Exception $e) {
        return $e instanceof $exp;
    }

    return false;
}