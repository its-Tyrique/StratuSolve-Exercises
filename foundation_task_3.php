<?php
    class Palindrome {
        public static function isPalindrome($word) {

            $word = preg_replace('/[^a-z0-9]/','',strtolower($word));

            if ($word == strrev($word)) {
                return true;
            } else{
                return false;
            }
        }
    }

    if (Palindrome::isPalindrome('Never Odd Or Even')){
        echo 'Palindrome';
    } else {
        echo 'Not palindrome';
    }