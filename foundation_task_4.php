<?php
    class ItemOwners {
        public static function groupByOwners($ItemsArr): array
        {
            $OwnersArr = [];
            foreach ($ItemsArr as $ItemStr => $OwnerStr) {
                $OwnersArr[$OwnerStr][] = $ItemStr;
            }
            return $OwnersArr;
        }
    }

    $ItemsArr = array(
        "Baseball Bat" => "John",
        "Golf ball" => "Stan",
        "Tennis Racket" => "John"
    );

    echo json_encode(ItemOwners::groupByOwners($ItemsArr));