<?php
//    Non-recursive function for Fibonacci series
    function fibonacciSequence($MaxValueInt): void
    {
        $FirstNumInt = 0;
        $SecondNumInt = 1;

        echo $FirstNumInt . ", ";

        while ($SecondNumInt <= $MaxValueInt) {
            echo $SecondNumInt . ", ";

            $NextNumInt = $FirstNumInt + $SecondNumInt;
            $FirstNumInt = $SecondNumInt;
            $SecondNumInt = $NextNumInt;
        }
    }

    $MaxValueInt = 44; // Change this value as needed
    echo "Fibonacci series till " . $MaxValueInt . ": ";
    fibonacciSequence($MaxValueInt);

//    Recursive function for Fibonacci series
    /*function fibonacciSequence($NumOfElementsInt, $FirstNumInt = 0, $SecondNumInt = 1)
    {
        if ($NumOfElementsInt == 0) {
            return 0;
        }
        echo $FirstNumInt . ", ";
        $NextNumInt = $FirstNumInt + $SecondNumInt;
        return (fibonacciSequence($NumOfElementsInt - 1, $SecondNumInt, $NextNumInt));
    }

    $NumOfElementsInt = 10;
    echo "Fibonacci series for " . $NumOfElementsInt . " elements: ";
    fibonacciSequence($NumOfElementsInt);*/