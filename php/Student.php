<?php
include_once('Users.php');
include_once('Option.php');
include_once('Session.php');
include_once('Courses.php');
include_once('database_info.php');
//Student class represent the students
Class Student extends Users{
	protected $SOption;//the student option he is enrolled in
	protected $Scourses;//An array that contains the classes a student is registered to
	protected $sday= array ('M','T','W','J','F','S'); //the days selected for display of courses
	protected $sstart=0; //the start time selected for display of courses
	protected $send=240000; // the end time selected for display of courses
	protected $ssemester=0; //the semesters selected for display of courses
	
	//Constructor
	function __construct($anid, $apassword){
		$this->id = $anid;
		$this->password = $apassword;
		$this->user_type=2;
		$this->updatename();
	}
	//this function update the student information from the database
	function update(){
		$tbl_name="Student";
		$db = call_user_func('database_info', $tbl_name, true);
		$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE idStudent='$this->id'");
		if($row = mysqli_fetch_array($result))
		mysqli_close($db);
		//assign values to current student
		$this->firstname= $row["givenNames"];
		$this->lastname= $row["lastName"];
		$this->SOption= new Option($row["Option_idOption"]);
		$this->GetCourseinfo();
		$this->resetCourses();
	}
	function updatename(){
		$tbl_name="Student";
		$db = call_user_func('database_info', $tbl_name, true);
		$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE idStudent='$this->id'");
		if($row = mysqli_fetch_array($result))
		mysqli_close($db);
		//assign values to current student
		$this->firstname= $row["givenNames"];
		$this->lastname= $row["lastName"];
	}
	//Get every course from the student's option
	function GetCourseinfo(){
		$tbl_name="option_has_course";
		$db = call_user_func('database_info', $tbl_name, true);	
		$onum=($this->SOption->getOption());
		$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Option_idOption='$onum'");
		while($row = mysqli_fetch_array($result)){	
			$this->SOption->SetCourses($row["Course_codeCourse"]);//The courses are all added to the option, not to the student himself
		}
		mysqli_close($db);
	}
	//Display the option courses according to the selector
	function DisplayAvailableCourses(){
		$finaloutput= array();
		foreach ($this->SOption->getcourses() as $value){
			if ($this->sessionSelector($value)){
				$temp = array(
						'current_courses'=>$value->getcode(), 
						'course_name'=>$value->getname(),
						'course_credit'=>$value->getcredit(),
						'course_Session'=>$value->getSession()->getname(),
						'course_Prerequisite1'=>$value->getPrerequisite(1),
						'course_Prerequisite2'=>$value->getPrerequisite(2),
						'course_Prerequisite3'=>$value->getPrerequisite(3),
						'course_Prerequisite4'=>$value->getPrerequisite(4),
						'course_Prerequisite5'=>$value->getPrerequisite(5)
						);
				array_push($finaloutput, $temp);
			}else{/*do nothing*/}
		}
		$jsonoutput=json_encode($finaloutput);
		echo($jsonoutput);
	}
	//Accessor
	function getfname(){
		return $this->firstname;
	}
	function getlname(){
		return $this->lastname;
	}
	function getoption(){
		return $this->SOption;
	}
	//this function is not implemented in the current version
	function GetSequence(){
		echo("Your courses sequence is ");//placeholder string
	}
	function getCourses(){
		return $this->Scourses;
	}
	
	function addClasses($classid, $courseid){
		if ($this->courselookup($courseid)){//This makes sure all course are available if no course were taken previous
			$tbl_name="Student_has_class";
			$db = call_user_func('database_info', $tbl_name, true);
			$anid = $this->id;
			$result=mysqli_query($db,"INSERT INTO $tbl_name (Student_idStudent, Class_codeClass, Class_Course_codeCourse)
			VALUES ('$anid', '$classid', '$courseid')");
			mysqli_close($db);
			$tbl_name="Student_has_course";
			$db = call_user_func('database_info', $tbl_name, true);
			$result=mysqli_query($db,"INSERT INTO $tbl_name (Student_idStudent, Course_codeCourse) VALUES ('$anid', '$courseid')");
			mysqli_close($db);
			$this->updateCourses($courseid);
		
			echo("This Class has been succesfully added to your current schedule, click here to close this pop-up or wait.");
		}else{
			echo("You already have a section of this course, please remove it before adding a new section");
		}
	}
	
	function removeClasses($classid, $courseid){
		$tbl_name="Student_has_class";
		$db = call_user_func('database_info', $tbl_name, true);
		$anid = $this->id;
		$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE Student_idStudent='$anid' AND Class_codeClass = '$classid' AND Class_Course_codeCourse='$courseid'");
		mysqli_close($db);
		$tbl_name="Student_has_course";
		$db = call_user_func('database_info', $tbl_name, true);
		$result=mysqli_query($db,"DELETE FROM $tbl_name WHERE Student_idStudent='$anid' AND Course_codeCourse='$courseid'");
		mysqli_close($db);
		$saved = $this->Scourses;
		unset($this->Scourses);
		foreach ($saved as $value){
		if ($value->getcode() != $courseid){
		$this->Scourses[] = $value;
		}
		}
		$this->DisplayClasses();
	}
	
	function resetCourses(){
		unset($this->Scourses);
		$tbl_name="student_has_course";
		$db = call_user_func('database_info', $tbl_name, true);
		$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE Student_idStudent='$this->id'");
		mysqli_close($db);
		while($row = mysqli_fetch_array($result)){
			$code = $row["Course_codeCourse"];
			$tbl_name="course";
			$db = call_user_func('database_info', $tbl_name, true);
			$result2=mysqli_query($db,"SELECT * FROM $tbl_name WHERE codeCourse='$code'");
			$row2 = mysqli_fetch_array($result2);
			mysqli_close($db);
			$this->Scourses[] = new Courses($row2);
		}
		if(empty($this->Scourses)){/*do nothing*/}else{
			foreach ($this->Scourses as $value){
				$value->setstudentclasses($this->id, $value->getcode());
			}
		}
	}
	
	function updateCourses($courseid){
		$anid = $this->id;
		$tbl_name="course";
		$db = call_user_func('database_info', $tbl_name, true);
		$result=mysqli_query($db,"SELECT * FROM $tbl_name WHERE codeCourse = '$courseid' ");
		mysqli_close($db);
		$row = mysqli_fetch_array($result);
		$this->Scourses[] = new Courses($row);
		if(empty($this->Scourses)){/*do nothing*/}else{
			foreach ($this->Scourses as $value){
				$value->setstudentclasses($this->id, $value->getcode());
			}
		}
	}
	
	function DisplayClasses(){
		if (empty($this->Scourses)){
			echo("No classes");
		}else{
			$finaloutput = array();
			foreach ($this->Scourses as $value){
				foreach ($value->getclasses() as $value2){
					if ($value2->getCourses()==null){/*do nothing*/}else{
						$temp = array(
							'current_classes' => $value2->getcode(),
							'course_name'=>$value2->getCourses(),
							'class_teacher'=>$value2->getteacher()->getname(),
							'class_day'=>$value2->getTime()->getday(),
							'class_start'=>$value2->getTime()->getstart(),
							'class_end'=>$value2->getTime()->getend(),
							'class_room'=>$value2->getroom(),
							'class_building'=>$value2->getbuilding(),
							'class_tutorial_code'=>$value2->getTutorial()->getcode(),
							'class_tutorial_day'=>$value2->getTutorial()->getTime()->getday(),
							'class_tutorial_start'=>$value2->getTutorial()->getTime()->getstart(),
							'class_tutorial_end'=>$value2->getTutorial()->getTime()->getend(),
							'class_tutorial_room'=>$value2->getTutorial()->getroom(),
							'class_tutorial_building'=>$value2->getTutorial()->getbuilding(),
							'class_lab_code'=>$value2->getLab()->getcode(),
							'class_lab_day'=>$value2->getLab()->getTime()->getday(),
							'class_lab_start'=>$value2->getLab()->getTime()->getstart(),
							'class_lab_end'=>$value2->getLab()->getTime()->getend(),
							'class_lab_room'=>$value2->getLab()->getroom(),
							'class_lab_building'=>$value2->getLab()->getbuilding()
						);
						array_push($finaloutput, $temp);
					}
				}
			}
			$jsonoutput=json_encode($finaloutput);
			echo($jsonoutput);
		}
	}
	
	function DisplayClassCourses($acourse){
		//this will find the correct course from the option list
		foreach ($this->SOption->getcourses() as $value){
			if ($value->getcode()==$acourse){
				$finaloutput = array();//once it finds it an array is prepared for the output of the classes code
				foreach ($value->getclasses() as $value2){
					if ($this->selection($value2, $value)){//display everything if the student doesn't have any class right now.
					$temp = array(
											'current_classes' =>$value2->getcode(),
											'course_name'=>$value2->getCourses(),
											'class_teacher'=>$value2->getteacher()->getname(),
											'class_day'=>$value2->getTime()->getday(),
											'class_start'=>$value2->getTime()->getstart(),
											'class_end'=>$value2->getTime()->getend(),
											'class_room'=>$value2->getroom(),
											'class_building'=>$value2->getbuilding(),
											'class_tutorial_code'=>$value2->getTutorial()->getcode(),
											'class_tutorial_day'=>$value2->getTutorial()->getTime()->getday(),
											'class_tutorial_start'=>$value2->getTutorial()->getTime()->getstart(),
											'class_tutorial_end'=>$value2->getTutorial()->getTime()->getend(),
											'class_tutorial_room'=>$value2->getTutorial()->getroom(),
											'class_tutorial_building'=>$value2->getTutorial()->getbuilding(),
											'class_lab_code'=>$value2->getLab()->getcode(),
											'class_lab_day'=>$value2->getLab()->getTime()->getday(),
											'class_lab_start'=>$value2->getLab()->getTime()->getstart(),
											'class_lab_end'=>$value2->getLab()->getTime()->getend(),
											'class_lab_room'=>$value2->getLab()->getroom(),
											'class_lab_building'=>$value2->getLab()->getbuilding()
									);
							array_push($finaloutput, $temp);
					}
				}
				$jsonoutput=json_encode($finaloutput);
				echo($jsonoutput);
			}
		}
	}
	Function selection($value2, $value){
		//select day
		$temptrue=false;
		$tempstring=str_split($value2->getTime()->getday());
		foreach ($tempstring as $aday){
			foreach($this->sday as $tday){//this make sure only selected days are used
				if ($aday==$tday){
					$temptrue=true;
				}
			}
		}
		if($temptrue==false){
			return false;
		}
		//select time
		$tempstring=str_replace(':','',$value2->getTime()->getstart());
		if (($this->sstart)>$tempstring){
			return false;
		}
		$tempstring=str_replace(':','',$value2->getTime()->getend());
		if (($this->send)<$tempstring){
			return false;
		}
			if (empty($this->Scourses)){//This makes sure all course are available if no course were taken previous
				return true;
			}else{
			if ($value2->compare($this->Scourses)){//this eliminate sections already taken
				return false;
			}else{
				return true;
			}}
	}
	Function setSelection($aday, $astart, $anend, $asession){
		if(empty($aday)){
			$this->sday= array ('M','T','W','J','F','S');
		}
		$this->sday = $aday;
		if ($astart<$anend)
		{
			$this->sstart=$astart;
			$this->send=$anend;
		}
		switch ($asession){
			case 'Summer':
				$this->ssemester=1;
				break;
			case 'Fall':
				$this->ssemester=2;
				break;
			case 'All':
				$this->ssemester=0;
				break;
			case 'Winter':
				$this->ssemester=4;
				break;
		}
		
	}
	//This change the string values of a session to its integer counterpart
	Function sessionSelector($value){
		$sem=$value->getSession()->getcode();
		$nsem=$this->ssemester;
		switch($nsem){
			case 0:
				return true;
				break;
			case 1:
				if (($sem==1)||($sem==5)||($sem==5)){
					return true;
				}else{
					return false;
				}
				break;
			case 2:
				if (($sem==2)||($sem==3)||($sem==6)){
					return true;
				}else{
					return false;
				}
				break;
			case 4:
				if (($sem==3)||($sem==4)||($sem=5)){
					return true;
				}else{
					return false;
				}
				break;
		}
	}
	//this function looks if a courses already exist in a student current classes
	function courselookup($course){
		if (empty($this->Scourses)){//This makes sure all course are available if no course were taken previous
			return true;
		}else{
			foreach ($this->Scourses as $value){
				if ($course==$value->getcode()){
					return false;
				}
			}
			return true;
		}
	}
}
?>