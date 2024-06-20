<?php

// fibonacci
function fibonacciSeq($n)
{
    $trace = '';

    if ($n<0) return '';
    $trace .= __FUNCTION__.': '.PHP_EOL;

    $res = [];
    $a = 0;
    for ($i=0; $i<$n; $i++) {
        // working around the limits
        if (($res[$i-1]??0) >= PHP_INT_MAX) { return 'Error max int: '.PHP_INT_MAX.''; }

        $trace .= 'i['.$i.']';

        if ($i == 0) { $res[$i] = 0;}
        else if ($i == 1) { $res[$i] = 1;}
        else $res[$i] = $res[$i-1] + $res[$i-2];

        $trace .= '='.$res[$i];
        if ($i > 1) {
            $trace .= " :: ($i-1)=" . $res[$i - 1] . " + ($i-2)=" . $res[$i - 2] . PHP_EOL;
        } else{
            $trace .= PHP_EOL;
        }

    }
    $trace .= PHP_EOL;

//        echo $trace;

    return array_pop($res);
}


echo 'Result:' . fibonacciSeq(94);