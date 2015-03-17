<?php
//This class is not yet implemented in the current version of the prototype
Class Tutorial extends classes {

	Function __construct($baseinfo){
	$this->code=$baseinfo["codeTutorial"];
	$this->aTime= new times($baseinfo["days"],$baseinfo["startTime"],$baseinfo["endTime"]);
	$this->room=$baseinfo["Room_numRoom"];
	$this->building=$baseinfo["Room_Building_codeBuilding"];
	}
}
?>