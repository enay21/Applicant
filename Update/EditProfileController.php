<!--
 - File Name: EditProfileController.php
 - Program Description: data transformations
-->
<?php
include "../../RegistrationManager.php";
class EditProfileController
{
	//constructor
	function EditProfileController(){
	}
	
	function editProfile($id,$profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic)
	{
		$lname = ucwords(trim(strtolower($lname)));
		$fname = ucwords(trim(strtolower($fname)));
		$mname = ucwords(trim(strtolower($mname)));
		$gender = trim(strtoupper($gender));
		$civil = trim(strtoupper($civil));
		$homeadd = trim(ucwords(strtolower($homeadd)));
		$homebrgy = trim(ucwords(strtolower($homebrgy)));
		$hometown = trim(ucwords(strtolower($hometown)));
		$homeprov = trim(ucwords(strtolower($homeprov)));
		$officeadd = trim(ucwords(strtolower($officeadd)));
		$offbrgy = trim(ucwords(strtolower($offbrgy)));
		$offtown = trim(ucwords(strtolower($offtown)));
		$offprov = trim(ucwords(strtolower($offprov)));
		$birthplace = trim(strtolower($birthplace));
		$occupation = trim(strtolower($occupation));
		$cit = trim(strtoupper($cit));
		$license = trim(strtoupper($license));
		$where = trim(ucwords(strtolower($where)));
		
		
		$editprofileview = new EditProfileView(); //instance of EditStudentView
		$update = new RegistrationManager(); //instance of StudentManager
		$editsuccess = $update->updateApplicant($id,$profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
			$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic);
		
		$update->newLog("Updated Applicant: ".$uname);
		
		$editprofileview->showMessage($editsuccess);
	}
}
?>