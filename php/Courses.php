<?php
include_once('Session.php');
include_once('classes.php');
include_once('general.php');
Class Courses extends general{
protected $credit;
protected $Prerequisite;
protected $Classes;
protected $aSession;

	function __construct($baseinfo){
	$this->code=$baseinfo["codeCourse"];
	$this->name=$baseinfo["name"];
	$this->credit=$baseinfo["credit"];
	$this->Prerequisite[1]=$baseinfo["prereq1"];
	$this->Prerequisite[2]=$baseinfo["prereq2"];
	$this->Prerequisite[3]=$baseinfo["prereq3"];
	$this->Prerequisite[4]=$baseinfo["prereq4"];
	$this->Prerequisite[5]=$baseinfo["prereq5"];
	$this->setclasses();
	$this->setSession();
	}
	function setclasses(){
	$this->Classes=null;
	$tbl_name="class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Course_codeCourse='$this->code'");
		while($row = mysqli_fetch_array($result)){		
				$this->Classes[]= new classes($row, true);
	}
	}
	function setSession(){
	$tbl_name="session_has_course";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Course_codeCourse='$this->code'");
	$row = mysqli_fetch_array($result)	;
	$this->aSession= new Session($row["Session_idSession"]);
	mysqli_close($db);
	}
	function setstudentclasses($id, $code){
	$this->Classes=null;
	$tbl_name="student_has_class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Student_idStudent='$id' AND Class_Course_codeCourse = '$code'");
	mysqli_close($db);
	$row = mysqli_fetch_array($result);
	$code2 = $row["Class_codeClass"];
	$tbl_name="class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Course_codeCourse='$code' AND codeClass='$code2'");
	$row = mysqli_fetch_array($result);
	$this->Classes[] = new classes($row, true);
	mysqli_close($db);
	}
	function getclasses(){
	return $this->Classes;
	}
	function getcredit(){
	return $this->credit;
	}
	function getPrerequisite($a){
	return $this->Prerequisite[$a];
	}
	function getSession(){
	return $this->aSession;
	}
}
?>