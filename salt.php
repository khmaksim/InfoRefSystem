<?php

function generateSalt() {
    $salt = '';
    $length = rand(5,10); // длина соли (от 5 до 10 сомволов)
    for($i=0; $i<$length; $i++) {
         $salt .= chr(rand(33,126)); // символ из ASCII-table
    }
    return $salt;
}       	

?>