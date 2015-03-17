<?php
include_once('user_type.php');
Class Users extends user_type{
     protected $firstname;
	 protected $lastname;
	 protected $password;	
		function getfname(){
		return $this->firstname;
		}
		function getlname(){
		return $this->lastname;
		}
		function getname(){
		$fullname = ($this->firstname." ".$this->lastname);
		return $fullname;
		}
		function ChangePassword($oldpass, $newpass) {
		if ($oldpass != $this->password){echo("Wrong Password Please enter your current password again");}
		else
		{
			$this->password = $newpass;
			$md5pass = md5($newpass);
			$anid = $this->id;
			switch ($this->user_type){
				case 0:
					$tbl_name="administrator";
					$db = call_user_func('database_info', $tbl_name, true);
					$result=mysqli_query($db,"UPDATE $tbl_name SET password='$md5pass' WHERE idAdministrator='$anid'");
					mysqli_close($db);
					break;
				case 1:
					$tbl_name="teacher";
					$db = call_user_func('database_info', $tbl_name, true);
					$result=mysqli_query($db,"UPDATE $tbl_name SET password='$md5pass' WHERE idTeacher='$anid'");
					mysqli_close($db);
					break;
				case 2:
					$tbl_name="student";
					$db = call_user_func('database_info', $tbl_name, true);
					$result=mysqli_query($db,"UPDATE $tbl_name SET password='$md5pass' WHERE idStudent='$anid'");
					mysqli_close($db);
					break;
			}
			header("location:student_page.php");
		}
		}
		//not implemented yet. Might be removed.
		function ChangeName ($firstname2, $lastname2){
		$firstname = $firstname2;
		$lastname = $lastname2;
		/*update the settings in the database
		UPDATE table_name
		SET column1=value, column2=value2,...*/
		}
}
?>