<?php
include_once('general.php');
include_once('Teacher.php');
include_once('Times.php');
include_once('Tutorial.php');
include_once('Lab.php');
include_once('Courses.php');
Class classes extends general{
	protected $Courses;
	protected $Tutorial;
	protected $Lab;
	protected $aTime;
	protected $teacher;
	protected $Students;
	protected $room;
	protected $building;

	Function __construct($baseinfo, $isnotteacher){
	$this->code=$baseinfo["codeClass"];
	$this->Courses=$baseinfo["Course_codeCourse"];
	if ($isnotteacher){
	$this->teacher = new Teacher($baseinfo["Teacher_idTeacher"], NULL);}
	$this->aTime= new Times($baseinfo["days"],$baseinfo["startTime"],$baseinfo["endTime"]);
	$this->room=$baseinfo["Room_numRoom"];
	$this->building=$baseinfo["Room_Building_codeBuilding"];
	$this->settutoriallab();
	$this->setStudents();
	}
	Function getteacher(){
	return $this->teacher;
	}
	Function getroom(){
	return $this->room;
	}
	Function getbuilding(){
	return $this->building;
	}
	Function gettime(){
	return $this->aTime;
	}
	Function getname(){
	return $this->Courses;
	}
	Function getCourses(){
	return $this->Courses;
	}
	Function gettutorial(){
	return $this->Tutorial;
	}
	Function getLab(){
	return $this->Lab;
	}
	Function settutoriallab(){
	$tbl_name="tutorial";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Class_codeClass='$this->code' AND Class_Course_codeCourse='$this->Courses'");
	$row = mysqli_fetch_array($result);	
				$this->Tutorial = new Tutorial($row);
	mysqli_close($db);
	$tbl_name="lab";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Tutorial_Class_codeClass='$this->code' AND Tutorial_Class_Course_codeCourse='$this->Courses'");
	$row = mysqli_fetch_array($result);		
				$this->Lab = new Lab($row);
	mysqli_close($db);
	}
	Function compare($otherclass){
		foreach ($otherclass as $value){
		
			if($this->getname()==$value->getcode()){
				foreach ($value->getclasses() as $value2){
					if ($this->getcode()==$value2->getcode())
					{
						return true;
					}
				}
			}
		}	
		return false;
	}
	Function setStudents(){
	unset($this->Students);
		$tbl_name="student_has_class";
	$db = call_user_func('database_info', $tbl_name, true);
	$code = $this->code;
	$Courses = $this->Courses;
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Class_codeClass='$code' AND Class_Course_codeCourse='$Courses'");
	while($row = mysqli_fetch_array($result)){
				$this->Students = new Student($row["Student_idStudent"], NULL);}
	mysqli_close($db);
	}

}
?>