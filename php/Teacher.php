<?php

//This class is not yet in use in the current prototype version
include_once('Users.php');
include_once('Student.php');
include_once('Session.php');
include_once('Courses.php');
include_once('classes.php');
Class Teacher extends Users{
	protected $Classes;
	
	Function __construct($id, $pass){
	$this->id=$id;
	$this->password=$pass;
	$this->user_type=1;
	$this->update();
	}
		//this function update the teacher information from the database
	function update(){
	$tbl_name="teacher";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE idTeacher='$this->id'");
	if($row = mysqli_fetch_array($result))
	//assign values to current student
	$this->firstname= $row["givenNames"];
	$this->lastname= $row["lastName"];
	$this->updateCourses();
	}
	function updateCourses(){
	unset($this->Classes);
		$tbl_name="class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Teacher_idTeacher='$this->id'");
	mysqli_close($db);
	while($row = mysqli_fetch_array($result)){
	$this->Classes[] = new classes ($row, false);
	}
	}
	function DisplayClasses(){
	if (empty($this->Classes)){
	echo("No classes");
	}else{
	$finaloutput = array();
	foreach ($this->Classes as $value){
	$temp = array(
						'current_classes' => $value->getcode(),
						'course_name'=>$value->getCourses(),
						//'class_teacher'=>$value->getteacher()->getname(),
						'class_day'=>$value->getTime()->getday(),
						'class_start'=>$value->getTime()->getstart(),
						'class_end'=>$value->getTime()->getend(),
						'class_room'=>$value->getroom(),
						'class_building'=>$value->getbuilding(),
						'class_tutorial_code'=>$value->getTutorial()->getcode(),
						'class_tutorial_day'=>$value->getTutorial()->getTime()->getday(),
						'class_tutorial_start'=>$value->getTutorial()->getTime()->getstart(),
						'class_tutorial_end'=>$value->getTutorial()->getTime()->getend(),
						'class_tutorial_room'=>$value->getTutorial()->getroom(),
						'class_tutorial_building'=>$value->getTutorial()->getbuilding(),
						'class_lab_code'=>$value->getLab()->getcode(),
						'class_lab_day'=>$value->getLab()->getTime()->getday(),
						'class_lab_start'=>$value->getLab()->getTime()->getstart(),
						'class_lab_end'=>$value->getLab()->getTime()->getend(),
						'class_lab_room'=>$value->getLab()->getroom(),
						'class_lab_building'=>$value->getLab()->getbuilding()
						);
	array_push($finaloutput, $temp);
	}}
	$jsonoutput=json_encode($finaloutput);
	echo($jsonoutput);
	}

}


?>