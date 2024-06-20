<?php


/// сложить 2 бесконечно больших числа
///

function runSum(string $a, string $b): int
{
    $lengthA = strlen($a);
    $lengthB = strlen($b);

    $sum = 0;
    $maxLength = max($lengthA, $lengthB);

    // echo 'max='.$maxLength . "".PHP_EOL;

    $a = str_pad($a, $maxLength, "0", STR_PAD_LEFT);
    $b = str_pad($b, $maxLength, "0", STR_PAD_LEFT);

    // echo 'a='.$a . ' b=' . $b . "".PHP_EOL;

    $result = '';
    $division = 0;
    for ($i = $maxLength - 1; $i >= 0; $i--) {

        $sum = $division + intval($a[$i]) + intval($b[$i]);
        $division = intdiv($sum, 10);
        $result = ($sum % 10) . $result;
    }

    return $result;
}

function sumInfinites($a, $b): string
{

    $a = (string)$a;
    $b = (string)$b;

    $sum = runSum($a, $b);

    return 'SUM ' . $a . ' + ' . $b . ' = ' . $sum;

}

$a = 6789;
$b = 34;

echo sumInfinites($a, $b) . PHP_EOL;

