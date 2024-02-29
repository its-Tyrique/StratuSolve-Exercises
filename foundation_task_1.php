<?php
    function addAll($ElementsArr) {
        if(empty($ElementsArr)) {
            return 0;
        }
        $TotSumInt = array_sum($ElementsArr);
        array_shift($ElementsArr);
        return $TotSumInt + addAll($ElementsArr);
    }

    $InputArr = [1,1,1,1,1];
    echo addAll($InputArr);