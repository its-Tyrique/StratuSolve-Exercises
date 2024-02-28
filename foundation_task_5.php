<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['MaxInt'])) {
//if (isset($_POST['MaxInt'])){
    $maxValue = $_POST['MaxInt'];
    echo "Fibonacci generated: ";
    fibonacciSequence($maxValue);
}