<?php 
	
$array = array("Ankesh","Saurabh","Ashish","Ashu", "Anuj", "Ajinkya"); 

$array2 = array("Saurabh","Ashish","Ashu", "Anuj", "Ajinkya"); 

//Array before reset 
print_r ($array); 

// Clear the whole values of array 
$array = array_diff( $array, $array2); 

// Array after reset 
print_r ($array); 
    // echo $_SERVER['SERVER_PROTOCOL'];
    echo var_dump(str_split($_SERVER['SERVER_PROTOCOL'],4));
    // header("Location: localhost ");
?>
