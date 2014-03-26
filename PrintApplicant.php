<?php
session_start();

class PrintApplicant
{
	function requestPrintApplicant()
	{
		$root = "../";
		$data = $_SESSION['pData'];
		$content = "";
		
		include $root."assets/library/html2pdf/html2pdf.class.php";
		
		$content .= "
			<style>
				th{
					text-align: center;
					background-color: #e6e6fa;
					color:#014421;
					border: 1px solid black;
				}
				
				td{
					color:#7b1113;
				}

				#result, #result td{
					border: 1px solid black;
					border-collapse: collapse;
					padding: 10px;
				}
			</style>
		";
		
		$content .= "<p>APPLICANT LIST (" . date("Y-m-d") . ")</p>";
		
		$content .= "
			<table id='result'>
				<tr>
					<th>Name</th>
					<th>Username</th>
					<th>License Number</th>
					<th>Driver ID</th>
					<th>Profile Type</th>
					<th>Gender</th>
					<th>Status</th>
					<th>Civil Status</th>
					<th>Birth Date</th>
					<th>Email Address</th>
				</tr>
		";
		
		foreach($data as $row)
		{
			if($row['profileType'] == "DRIVER") continue;
		$content .= "
				<tr>
					<td>".$row['lastName'].", ".$row['givenName']." ".$row['middleName']."</td>
					<td>".$row['userName']."</td>
					<td>".$row['licenseNumber']."</td>
					<td align='center'>
		";
					if($row['profileType'] == "PUBLIC" || $row['profileType'] == "OPERATOR") $content .= $row['driverID']; 
					else $content .= "-";
		$content .= "
					</td>
					<td>".$row['profileType']."</td>
					<td>".$row['gender']."</td>
					<td>".$row['status']."</td>
					<td>".$row['civilStatus']."</td>
					<td>".$row['birthDate']."</td>
					<td>".$row['emailAddress']."</td>
				</tr>
		";
		}
		
		$content .= "
			</table>
		";
		
		$html2pdf = new HTML2PDF('L');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('Applicant List '.date("Y-m-d").'.pdf');
		
		exit;
	}
}
$pa = new PrintApplicant();
$pa->requestPrintApplicant();
?>