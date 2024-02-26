<?php
    function fibonacciSequence($IntNumOfElements, $IntFirstNum = 0, $IntSecondNum = 1) {
        if($IntNumOfElements == 0) {
            return 0;
        }
        echo $IntFirstNum.", ";
        $IntNextNum = $IntFirstNum + $IntSecondNum;
        return (fibonacciSequence($IntNumOfElements -1, $IntSecondNum, $IntNextNum));
    }

    $IntNumOfElements = 10;
    echo "Fibonacci series for ".$IntNumOfElements." elements: ";
    fibonacciSequence($IntNumOfElements);