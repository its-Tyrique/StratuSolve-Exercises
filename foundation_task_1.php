<?php
    function addAll($ArrElements) {
        if(empty($ArrElements)) {
            return 0;
        }
        $TotSum = array_sum($ArrElements);
        array_shift($ArrElements);
        return $TotSum + addAll($ArrElements);
    }

    $ArrInput = [1,1,1,1,1];  //5+4+3+2+1=15
    echo addAll($ArrInput);