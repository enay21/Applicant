<!--
  - File Name: Applicant/DeleteApplicant.php
  - Program Description: 
  -->
<?php
	session_start();
	include "../RegistrationManager.php";
	
	class ApplicantController
	{
		function deleteApplicant()
		{
			$id = isset($_GET['id']) ? $_GET['id'] : $this->showMessage(0);
			
			$rm = new RegistrationManager();
			
			// change log
			$profile = mysql_fetch_array($rm->retrieveProfilebyId($id));
			$rm->newLog("Remove Applicant: ".$profile['userName']);
			
			// remove all violations related to this user
			$driver = mysql_fetch_assoc($rm->retrieveProfile($profile['userName']));
			$rm->removeViolationByUser($driver['driverID']);
			
			$result = $rm->removeProfile($id);
			
			if($result > 0)
				$_SESSION['message'] = "Applicant is removed.";
			else
				$_SESSION['message'] = "There has been an error in deleting the applicant.";
			
			$this->showMessage($flag);
		}
		
		function showMessage($flag)
		{
			/*if($flag==1) header("Location: ../?removesuccess=1");
			else header("Location: ../?removenotsuccess=1");*/
			header("Location: ../");
		}
	}
	
	$pc = new ApplicantController();
	$pc->deleteApplicant();
?>