<?php
function addAll($array) {
    if(count($array) == 0) {
        return 0;
    }
    $total = array_sum($array);
    array_shift($array);
    return $total + addAll($array);
}

$array = [1,1,1,1,1];  //5+4+3+2+1=15
echo addAll($array);
?>