<?php 
// Buatkan fungsi untuk menentukan bilangan terbesar dari sederet bilangan dalam array berikut: 
// $bilangan = array(11, 6, 31, 201, 99, 861, 1, 7, 14, 79). Tanpa menggunakan built in fungsi array PHP;

$bilangan = [11, 6, 31, 201, 99, 861, 1, 7, 14, 79];

// Mencari jumlah total data dalam array (count($bilangan))
$totalBilangan = 0;
foreach ($bilangan as $value) {
    $totalBilangan += 1;
} 

$max = 0; 
for ($i = 1; $i < $totalBilangan; $i++){
    if ($max < $bilangan[$i]){
        $max = $bilangan[$i]; 
    }
}

echo $max;  
?>