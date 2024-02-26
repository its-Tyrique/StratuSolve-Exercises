<?php
function fibonacciSequence($maxValue): void
{
    $IntFirstNum = 0;
    $IntSecondNum = 1;

    echo $IntFirstNum . ", ";

    while ($IntSecondNum <= $maxValue) {
        echo $IntSecondNum . ", ";

        $IntNextNum = $IntFirstNum + $IntSecondNum;
        $IntFirstNum = $IntSecondNum;
        $IntSecondNum = $IntNextNum;
    }
}

$maxValue = 44; // Change this value as needed
echo "Fibonacci series till " . $maxValue . ": ";
fibonacciSequence($maxValue);
