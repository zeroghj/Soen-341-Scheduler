<?php
include_once('General.php');
Class Option extends General{
	protected $aCourses;
	protected $idOption;
	protected $Sequence;
	
	Function __construct($o){
	$this->idOption = $o;
	}
	
	function getOption(){
	return $this->idOption;
	}
	
	function SetCourses($cours){
	$tbl_name="course"; // Table name
		$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE codeCourse='$cours'");
		$row = mysqli_fetch_array($result);
		$this->aCourses[] = new Courses($row);
	
	}
	function getCourses(){
	return $this->aCourses;
	}
}
?>