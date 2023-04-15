<?php 
// Dengan menggunakan teknik bubble sorting, urutkan bilangan-bilangan berikut:

$bilangan = [99, 2, 64, 8, 111, 33, 65, 11, 102, 50];

// Mencari jumlah total data dalam array (count($bilangan))
$totalBilangan = 0;
foreach ($bilangan as $value) {
    $totalBilangan += 1;
}

// DESC Array
for($i=0; $i<$totalBilangan; $i++){
    for($j=$i+1; $j<$totalBilangan; $j++)
    {
        if($bilangan[$i] > $bilangan[$j])
        {
            $temp     = $bilangan[$i];
            $bilangan[$i] = $bilangan[$j];
            $bilangan[$j] = $temp;
        }
    }
}

print_r($bilangan);
?>