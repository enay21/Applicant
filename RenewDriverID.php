<!--
  - File Name: /HomePage/RenewDriverID.php
  - Program Description: 
  -->
<?php
session_start();
include "../RegistrationManager.php";

class RenewDriverID
{
	function requestRenewDriverID()
	{
		$rm = new RegistrationManager();
		
		$id = isset($_GET['id']) ? $_GET['id'] : header("Location: ./");
		
		$result = $rm->addDriverID($id);
		
		header("Location: ../");
	}
}
$rdi = new RenewDriverID();
$rdi->requestRenewDriverID();
?>