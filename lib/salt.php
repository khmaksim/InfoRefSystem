<?php

function generateSalt() {
    $salt = '';
    $length = rand(5,10); // ����� ���� (�� 5 �� 10 ��������)
    for($i=0; $i<$length; $i++) {
         $salt .= chr(rand(33,126)); // ������ �� ASCII-table
    }
    return $salt;
}       	

?>