<?php
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

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['MaxInt'])) {
    //if (isset($_POST['MaxInt'])){
        $MaxValueInt = $_POST['MaxInt'];
        echo "Fibonacci generated: ";
        fibonacciSequence($MaxValueInt);
    }