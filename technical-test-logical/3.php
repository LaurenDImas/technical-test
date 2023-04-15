<?php 
// Buatkan fungsi yang dapat menghasilkan format berikut:
// 1
// 1 2
// 1 2 3
// 1 2 3 4
// 1 2 3 4 5
// 1 2 3 4 5 6
// 1 2 3 4 5 6 7
// 1 2 3 4 5 6 7 8
$from = 1;
$to   = 8;
for ($i = $from; $i <= $to; $i++) {
    for ($j = $from; $j <= $i; $j++) {
        echo $j.' ';
    }

    echo "<br>";
}

?>