<?php 
$start_time = microtime(true);

for($i=0; $i<10000000;$i++){
    if($i>9999990){
        echo $i;
    }
}
$end_time = microtime(true);
$execution_time = $end_time - $start_time;

// Format the execution time for readability
$execution_time_formatted = number_format($execution_time, 6);
// Echo the compile time
echo "<br>";
echo "Script execution time: {$execution_time_formatted} seconds";

?>