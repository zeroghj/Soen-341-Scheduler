<?php
Class Times{
protected $day;
protected $start_time;
protected $end_time;

Function __construct($day, $start, $end){
$this->day=$day;
$this->start_time=$start;
$this->end_time=$end;
}
function getday(){
return $this->day;
}
function getstart(){
return $this->start_time;
}
function getend(){
return $this->end_time;
}
function setday($a){
$this->day=$a;
}
function setstart($a){
$this->start_time=$a;
}
function setend($a){
$this->end_time=$a;
}

}

?>