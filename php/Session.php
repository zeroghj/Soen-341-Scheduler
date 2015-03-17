<?php
include_once('general.php');
Class Session extends general{


function __construct($aid){
$this->code = $aid;
switch ($aid){
case 1: 
$this->name = "Summer";
break;
case 2: 
$this->name = "Fall";
break;
case 3: 
$this->name = "Fall and Winter";
break;
case 4: 
$this->name = "Winter";
break;
case 5: 
$this->name = "Summer and Winter";
break;
case 6: 
$this->name = "Summer and Fall";
break;
}
}
}

?>