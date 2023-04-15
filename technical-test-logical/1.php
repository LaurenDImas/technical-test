<?php
    // 1. Buatkan fungsi untuk memeriksa apakah sebuah bilangan adalah bilangan prima.
    
    // Bilangan Prima
    $from = 1;
    $to   = 10;
    for ($i=1; $i <= 50 ; $i++) { 
        $a = 0;
        for ($b=1; $b <= $i ; $b++) { 
            if($i % $b == 0){
                $a++;
            }
        }

        if($a == 2){
            echo $i.'<br>';
        }
    }
?>