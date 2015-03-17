<?php
include_once('Users.php');
include_once('Student.php');
include_once('Teacher.php');
include_once('Courses.php');
include_once('classes.php');
Class Admin extends Users{
	protected $Users;
	
	Function __construct($id, $pass){
	$this->id=$id;
	$this->password=$pass;
	$this->user_type=0;
	$this->update();
	}
	
	function update(){
	$tbl_name="administrator";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE idAdministrator='$this->id'");
	if($row = mysqli_fetch_array($result))
	//assign values to current admin
	$this->firstname= $row["givenNames"];
	$this->lastname= $row["lastName"];
	}
	
	function getUsers(){
	unset($this->Users);
	$tbl_name="student";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name");
	mysqli_close($db);
	while($row = mysqli_fetch_array($result)){
	$this->Users[] = new Student ($row['idStudent'], $row['password']);
	}
	$tbl_name="teacher";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name");
	mysqli_close($db);
	while($row = mysqli_fetch_array($result)){
	$this->Users[] = new Teacher ($row['idTeacher'], $row['password']);
	}
		$tbl_name="administrator";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"SELECT * FROM $tbl_name");
	mysqli_close($db);
	while($row = mysqli_fetch_array($result)){
	$this->Users[] = new Admin ($row['idAdministrator'], $row['password']);
	}
	}
	
	function DisplayUsers(){
	$this->getUsers();
	$finaloutput = array();
	foreach ($this->Users as $value){
	$temp = array(
						'id' => $value->getid(),
						'first_name'=>$value->getfname(),
						'last_name'=>$value->getlname(),
						'User_type'=>$value->getusertype(),
						);
	array_push($finaloutput, $temp);
	}
	$jsonoutput=json_encode($finaloutput);
	echo($jsonoutput);
	}
	
	function AddStudent($firstname2, $lastname2, $id2, $password2, $Option2){
	$tbl_name="student";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"INSERT INTO $tbl_name (idStudent, lastName, givenNames, Option_idOption, password, usertype)
	VALUES ('$id2', '$lastname2', '$firstname2', '$Option2', '$password2', 2)");
	mysqli_close($db);
	}
	function removeStudent($id){
	$tbl_name="student_has_class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE Student_idStudent='$id'");
	mysqli_close($db);
	$tbl_name="student_has_course";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE Student_idStudent='$id'");
	mysqli_close($db);
	$tbl_name="student";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE idStudent='$id'");
	mysqli_close($db);
	$this->DisplayUsers();
	}
	
	function AddTeacher($firstname2, $lastname2, $id2, $password2){
	$tbl_name="teacher";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"INSERT INTO $tbl_name (idTeacher, lastName, givenNames, password, usertype)
	VALUES ('$id2', '$lastname2', '$firstname2', '$password2', 1)");
	mysqli_close($db);
	}
	function removeTeacher($id){
	$tbl_name="teacher";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE idTeacher='$id'");
	mysqli_close($db);
	$tbl_name="class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE Teacher_idTeacher='$id'");
	mysqli_close($db);
	$this->DisplayUsers();
	}
	function AddClasses($code, $course, $days, $sTime, $eTime, $teacherid, $room, $building, $tutcode, $tutdays, $tutstart, $tutend,$tutroom, $tutbuilding, $labcode, $labdays, $labstart, $labend, $labroom, $labbuilding){
	$tbl_name="class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"INSERT INTO $tbl_name (codeClass, days, startTime, endTime, Course_codeCourse, Teacher_idTeacher, Room_numRoom, Room_Building_codeBuilding)
	VALUES ('$code', '$days', '$startTime', '$endTime', '$course', '$room', '$building')");
	mysqli_close($db);
	$tbl_name="tutorial";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"INSERT INTO $tbl_name (codeTutorial, days, startTime, endTime, Class_codeClass,Class_Course_codeCourse,  Room_numRoom, Room_Building_codeBuilding)
	VALUES ('$tutcode', '$tutdays', '$tutstart', '$tutend', '$code', '$course', '$tutroom', '$tutbuilding')");
	mysqli_close($db);
	$tbl_name="Lab";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"INSERT INTO $tbl_name (codeLab, days, startTime, endTime, Tutorial_codeTutorial, Tutorial_Class_codeClass,Tutorial_Class_Course_codeCourse,  Room_numRoom, Room_Building_codeBuilding)
	VALUES ('$labcode', '$labdays', '$labstart', '$labend', '$tutcode','$code', '$course', '$labroom', '$labbuilding')");
	mysqli_close($db);
	$this->DisplayUsers();
	}
	function removeClasses($code, $course){
	$tbl_name="class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE codeClass='$code' Course_codeCourse='$course'");
	mysqli_close($db);
	$tbl_name="student_has_class";
	$db = call_user_func('database_info', $tbl_name, true);
	$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE Class_codeClass='$code' Class_Course_codeCourse='$course' ");
	mysqli_close($db);
	$this->DisplayUsers();
	}
}
?>