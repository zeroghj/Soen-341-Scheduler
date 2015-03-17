<?php
//This class is not yet implemented in the current version of the prototype
Class Lab extends Tutorial{
	Function __construct($baseinfo){
	$this->code=$baseinfo["codeLab"];
	$this->aTime= new times($baseinfo["days"],$baseinfo["startTime"],$baseinfo["endTIme"]);
	$this->room=$baseinfo["Room_numRoom"];
	$this->building=$baseinfo["Room_Building_codeBuilding"];
	}
}

?>