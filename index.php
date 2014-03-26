<!--
  - File Name: Applicant/index.php
  - Program Description: show applicants
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Applicant";
	$currentMenu = "applicant";
	
	//include "../dbconnection.php";
	session_start();
	
	if(!isset($_SESSION['username'])) header("Location: ".$root);
	
	include "../RegistrationManager.php";
	$rm = new RegistrationManager();
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$searchOptions = ""
		.	"<select class='filter'>"
		.		"<option value='userName'>Username</option>"
		.		"<option value='licenseNumber'>License Number</option>"
		.		"<option value='lastName'>Last Name</option>"
		.		"<option value='middleName'>Middle Name</option>"
		.		"<option value='givenName'>Given Name</option>"
		.		"<option value='gender'>Gender (F or M)</option>"
		.		"<option value='civilStatus'>Civil Status</option>"
		.		"<option value='emailAddress'>Email Address</option>"
		.		"<option value='homeAddress'>Home Address</option>"
		.		"<option value='homeBrgy'>Home Barangay</option>"
		.		"<option value='homeTown'>Home Town</option>"
		.		"<option value='homeProvince'>Home Province</option>"
		.		"<option value='officeAddress'>Office Address</option>"
		.		"<option value='officeBrgy'>Office Barangay</option>"
		.		"<option value='officeTown'>Office Town</option>"
		.		"<option value='officeProvince'>Office Province</option>"
		.		"<option value='birthPlace'>BirthPlace</option>"
		.		"<option value='citizenship'>Citizenship</option>"
		.		"<option value='occupation'>Occupation</option>"
		.		"<option value='status'>Status</option>"
		.	"</select>";
?>
<html>
	<?php include $root."head.php"; ?>
	<body id="">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
				<?php
					if(isset($_SESSION["message"])) {
						if($_SESSION["message"] != ""){
							echo "<div class='message'>";
								echo $_SESSION["message"];
							echo "</div>";
						}
						unset($_SESSION["message"]);
					}
				?>
				<div id="searchPanel">
					<form action="javascript:getFilters()" method="post">
						<div id="searchFilter">
							<div>
								<input class="keyword" name="keyword" type="text" value="" />
								<?php echo $searchOptions; ?>
							</div>
						</div>
						<div class="searchButton">
							<input type="button" value="Add Filter" onclick="javascript:addFilter()" />
							<input type="button" value="Search" onclick="javascript:getFilters()" />
						</div>
					</form>
				</div>
				<form name="viewForm" id="viewForm" method="post" action="">
					<div style=''>
					<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
						<input type="button" value="Add Applicant" onclick="this.form.action='../Registration/';submit();" style="float:right;" /><?}?>
						<input type="button" value="Print" onclick="this.form.action='./PrintApplicant.php';submit();" style="float:right;" />
						<div style="clear:both;"></div>
						<?php
						$profile = $rm->retrieveProfile(null); 
						$data = array();
						?>	
						<table id="result">
							<tr>
								<th></th>
								<th class="sortable" onclick="javascript:sortColumns('lastName, givenName, middleName');">Name</th>
								<th class="sortable" onclick="javascript:sortColumns('userName');">Username</th>
								<th class="sortable" onclick="javascript:sortColumns('driverID');">Driver ID</th>
								<th class="sortable" onclick="javascript:sortColumns('licenseNumber');">License No</th>
								<th class="sortable" onclick="javascript:sortColumns('status');">Status</th>
								<!--th class="sortable" onclick="javascript:sortColumns('violation');">Violation</th-->
								<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
								<th></th>
								<th></th>
								<th></th>
								<? } ?>
							</tr>
							<?php
							$target = "../files/profile/";
							while($row = mysql_fetch_assoc($profile))
							{
								array_push($data, $row);
								if($row['profileType'] != "ADMIN")
								{
									if($row['profileType'] == "DRIVER" ||$row['profileType'] == "OPERATIONS") continue;
								?>
									<tr>
										<td><img src="<?php echo $target.$row['picture']; ?>" width="100"></td>
										<td><?php echo $row['lastName'] . ", " . $row['givenName'] . " " . $row['middleName']; ?></td>
										<td>
											<?php
												$vdata = $rm->retrieveVehicle($row['pid']);
												$vehicles = "";
												//while($d = mysql_fetch_assoc($vdata)){ $vehicles .= $d['plateNumber'] . "\n"; }
												//echo $vehicles;
												
												$ddata = $rm->retrieveDrivers($row['pid']);
												$drivers = "";
												//while($d = mysql_fetch_assoc($ddata)){ $drivers .= $d['lastName'] . ", " . $d['givenName'] . " " . $d['middleName'] . "\n"; }
												//echo $drivers;
											?>
											<span style="cursor:pointer;" onclick="alert('Username: <?php echo $row['userName'];?>\nName: <?php echo $row['lastName'].", ".$row['givenName']." ".$row['middleName'];?>\nGender: <?php echo $row['gender'];?>\nCivil Status: <?php echo ucwords(strtolower($row['civilStatus']));?>\nHome Address: <?php echo $row['homeAddress'];?>\nHome Barangay: <?php echo $row['homeBrgy'];?>\nHome Town: <?php echo $row['homeTown'];?>\nHome Province: <?php echo $row['homeProvince'];?>\nOffice Address: <?php echo $row['officeAddress'];?>\nOffice Barangay: <?php echo $row['officeBrgy'];?>\nOffice Town: <?php echo $row['officeTown'];?>\nOffice Province: <?php echo $row['officeProvince'];?>\nBirthplace: <?php echo $row['birthPlace'];?>\nBirthdate: <?php echo $row['birthDate'];?>\nEmail Address: <?php echo $row['emailAddress'];?>\nOccupation: <?php echo $row['occupation'];?>\nCitizenship: <?php echo $row['citizenship'];?>\nLicense Number: <?php echo $row['licenseNumber'];?>\nLicense Issued On: <?php echo $row['licenseIssuedDate']."(".$row['licenseIssuedLTOBranch'].")";?>\nExpiry Date: <?php echo $row['licenseExpiryDate'];?>\n\nVehicles:\n<?php while($d = mysql_fetch_assoc($vdata)){ echo $d['plateNumber'] . '\n'; } ?>\n\nDrivers:\n<?php while($d = mysql_fetch_assoc($ddata)){ echo $d['lastName'] . ', ' . $d['givenName'] . ' ' . $d['middleName'] . '\n'; } ?>');"><?php echo $row['userName']; ?></span>
										</td>
										<td align="center">
											<?php
												//if($row['profileType'] == "PUBLIC" || $row['profileType'] == "OPERATOR"){
												if($row['profileType'] == "APPLICANT"){
													if($row['block'] == 1){
														echo "<img title='The system cannot renew that driver ID number because the user is blocked.' src='".$root."assets/images/icons/refresh24_x.png' />";
													}elseif($row['driverID'] == ""){
														echo "<a href='RenewDriverID.php/?id=".$row['pid']."'><img title='Renew Driver ID' src='".$root."assets/images/icons/refresh24.png' /></a>";
													}else{
														echo $row['driverID'];
													}
												}else {
													echo "-";
												}
											?>
										</td>
										<td><?php echo $row['licenseNumber']; ?></td>
										<td><?php echo $row['status'];?></td>
										<!--td align="center"><!--?php echo $row['violation']; ?></td-->
										<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
											
										<td>
											<?php if($row['block'] == 1){ ?>
												<img title="Account is BLOCKED." src="<?php echo $root."assets/images/icons/edit24_x.png"; ?>">
											<?php }else{ ?>
												<a href="./Update/?id=<?php echo $row['pid']; ?>"><img title="Edit Applicant" src="<?php echo $root."assets/images/icons/edit24.png"; ?>"></a>
											<?php } ?>
										</td>
										<td>
											<?php if($row['block'] == 1){ ?>
												<img title="Delete Applicant" src="<?php echo $root."assets/images/icons/delete24_x.png"; ?>">
											<?php }else{ ?>
												<a href="./DeleteApplicant.php/?id=<?php echo $row['pid']; ?>"><img title="Delete Applicant" src="<?php echo $root."assets/images/icons/delete24.png"; ?>"></a>
											<?php } ?>
										</td>
										<td>
											<?php 
												if($row['block'] == 0){
													echo "<a href='BlockApplicant.php/?pn=".$row['pid']."&b=1'><img title='Click to block this applicant.' src='".$root."assets/images/icons/unlock24.png'></a>";
												}else{
													echo "<a href='BlockApplicant.php/?pn=".$row['pid']."&b=0'><img title='Click to unblock this applicant.' src='".$root."assets/images/icons/lock24.png'></a>";
												}
											?>
										</td>
										
										<? } ?>
									</tr>
								<?php
								}
							}
							$_SESSION['pData'] = $data;
							?>
						</table>
					</div>
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
				</form>
			</div>
		</div>
	</body>
</html>