<!--
  - File Name: BlockApplicant.php
  - Program Description: 
  -->
<?php
session_start();
include "../RegistrationManager.php";

class BlockApplicant
{
	function requestBlockApplicant()
	{
		$profileID = isset($_GET['pn']) ? $_GET['pn'] : header("Location: ../");
		$block = isset($_GET['b']) ? $_GET['b'] : header("Location: ../");

		$rm = new RegistrationManager(); //instance of RegistrationManager
		$success = $rm->blockApplicant($profileID, $block);
		
		$this->showMessage($success);
	}
	
	function showMessage($flag) {
		if($flag == 1) 
			$_SESSION['message'] = "The applicant is blocked.";
		else
			$_SESSION['message'] = "The applicant is unblocked.";
		
		header("Location: ../");
	}
}
$blockapplicant = new BlockApplicant();
$blockapplicant->requestBlockApplicant();
?>