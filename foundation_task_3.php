<?php
//  Palindrome class with static method
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

//    Palindrome class with non-static method
    /*class Palindrome {
        public function isPalindrome($word) {
            $word = preg_replace('/[^a-z0-9]/', '', strtolower($word));

            if ($word == strrev($word)) {
                return true;
            } else {
                return false;
            }
        }
    }

    $palindromeChecker = new Palindrome();

    if ($palindromeChecker->isPalindrome('Never Odd Or Even')) {
        echo 'Palindrome';
    } else {
        echo 'Not palindrome';
    }*/
