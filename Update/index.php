<!--
 - File Name: UpdateProfile/index.php
 - Program Description: form for editing profile information
 -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Update Applicant";
	$currentMenu = "applicant";
	
	session_start();
	
	include $root."dbconnection.php";
	if(!isset($_SESSION['username']))header("Location: ".$root);
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	//$uname = $_SESSION['username']; 
	$id = $_GET['id'];
	
	if(isset($_SESSION['editerror'])){
		$profiletype = $_SESSION['editprofiletype'];
		$uname = $_SESSION['edituname'];
		$pword = $_SESSION['editpword'] ;
		$lname = $_SESSION['editlname'];
		$fname = $_SESSION['editfname'];
		$mname = $_SESSION['editmname'];
		$contactnumber = $_SESSION['editcontactnumber'];
		$gender = $_SESSION['editgender'];
		$civil = $_SESSION['editcivil'];
		$homeadd = $_SESSION['edithomeadd'];
		$homebrgy = $_SESSION['edithomebrgy'];
		$hometown = $_SESSION['edithometown'];
		$homeprov = $_SESSION['edithomeprov'];
		$officeadd = $_SESSION['editofficeadd'];
		$offbrgy = $_SESSION['editoffbrgy'];
		$offtown = $_SESSION['editofftown'];
		$offprov = $_SESSION['editoffprov'];
		$birthday = $_SESSION['editbirthday'];
		$birthplace = $_SESSION['editbirthplace'];
		$occupation = $_SESSION['editoccupation'];
		$email = $_SESSION['editemail'];
		$cit = $_SESSION['editcit'];
		$license = $_SESSION['editlicense'];
		$where = $_SESSION['editwhere'];
		$when = $_SESSION['editwhen'];
		$expiry = $_SESSION['editexpiry'];
		$picture = $_SESSION['editpicture'];
		$licensepic = $_SESSION['editlicensepic'];
	}else{
		$query = "
			SELECT * 
			FROM table_profile p
			LEFT JOIN table_driverID d ON p.profileID=d.profileID
			WHERE p.profileID='$id'
		";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		$profiletype = $row['profileType'];
		$uname = $row['userName'];
		$pword = $row['password'];
		$lname = $row['lastName'];
		$fname = $row['givenName'];
		$mname = $row['middleName'];
		$contactnumber = $row['contactNumber'];
		$gender = $row['gender'];
		$civil = $row['civilStatus'];
		$civil = trim(strtolower($civil));
		$homeadd = $row['homeAddress'];
		$homebrgy = $row['homeBrgy'];
		$hometown = $row['homeTown'];
		$homeprov = $row['homeProvince'];
		$officeadd = $row['officeAddress'];
		$offbrgy = $row['officeBrgy'];
		$offtown = $row['officeTown'];
		$offprov = $row['officeProvince'];
		$birthday = $row['birthDate'];
		$birthplace = $row['birthPlace'];
		$occupation = $row['occupation'];
		$email = $row['emailAddress'];
		$cit = $row['citizenship'];
		$license = $row['licenseNumber'];
		$where = $row['licenseIssuedLTOBranch'];
		$when = $row['licenseIssuedDate'];
		$expiry = $row['licenseExpiryDate'];
		$picture = $row['picture'];
		$licensepic = $row['licensepic'];
	}
	
	$query = "SELECT * FROM table_vehicle v INNER JOIN table_profile p ON v.owner=p.profileID WHERE (v.status='approved' OR v.status='released') AND p.profileID='".$_SESSION['profileID']."'";
	$result = mysql_query($query);
	$vehiclesApproved = mysql_num_rows($result);
	
	
	$isnull = "<p class='fieldError'>*Required field</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
?>

<html>
	<?php include $root."head.php"; ?>

	<body>
		<div id='centerArea'>
			<?php include $root . "menu.php"; // display menu options ?>

			<div id='content' style='top:0'>
				<h2>Profile Editor</h2>
				<?php echo "<table><tr><td>Profile Image</td><td>Scanned License</td></tr>";
				echo "<tr><td><img src='".$root."files/profile/".$picture."' width='100'></td><td><img src='".$root."files/license/".$licensepic."' width='100'></td></tr></table>";?>
				<!-- Form for Profile Editing-->
				<form name="editProfileForm" method="post" action="EditProfileView.php" onsubmit="return showDetails()" enctype="multipart/form-data">
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
					<table>
						<tr>
							<td>Enter New Password:</td>
							<td><input type="password" name="pword" id="pword" value="<?php echo $pword; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['pwordisnull'])) echo $isnull;
								if(isset($_SESSION['scriptpword'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td>Last Name:</td>
							<td><input type="text" name="lname" id="lname" value="<?php echo $lname; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['lnameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td>First Name:</td>
							<td><input type="text" name="fname" id="fname" id="fname" value="<?php echo $fname; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['fnameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptfname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td>Middle Name:</td>
							<td><input type="text" name="mname" id="mname" value="<?php echo $mname; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['mnameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptmname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td>Contact Number:</td>
							<td><input type="text" name="contactnumber" id="contactnumber" value="<?php echo $contactnumber; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['contactnumberisnull'])) echo $isnull;
								if(isset($_SESSION['scriptcontactnumber'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>
							<select name="gender" id="gender">
								<?php if($gender=="F"){?>
								<option value="F" selected="selected">Female</option>
								<option value="M">Male</option>
								<?php }else{?>
								<option value="F">Female</option>
								<option value="M" selected="selected">Male</option>
								<?php } ?>
							</select>
							</td>
						</tr>
									<?////////////////////////////////////////?>
						<tr>
							<td>Civil Status:</td>
							<td>
								<select name="civil" id="civil">
									<?php if($civil=="single"){?>
										<option value="single" <?php echo "selected='selected'";?>>Single</option>
										<option value="married">Married</option>
										<option value="divorced">Divorced</option>
										<option value="separated">Separated</option>
										<option value="widowed">Widowed</option>
									<?php }else if ($civil=="married"){ ?>
										<option value="single">Single</option>
										<option value="married" <?php echo "selected='selected'";?>>Married</option>
										<option value="divorced">Divorced</option>
										<option value="separated">Separated</option>
										<option value="widowed">Widowed</option>
									<?php }else if ($civil=="divorced"){ ?>
										<option value="single">Single</option>
										<option value="married">Married</option>
										<option value="divorced" <?php echo "selected='selected'";?>>Divorced</option>
										<option value="separated">Separated</option>
										<option value="widowed">Widowed</option>
									<?php }else if ($civil=="separated"){ ?>
										<option value="single">Single</option>
										<option value="married">Married</option>
										<option value="divorced">Divorced</option>
										<option value="separated" <?php echo "selected='selected'";?>>Separated</option>
										<option value="widowed">Widowed</option>
									<?php }else if ($civil=="widowed"){?>
										<option value="single">Single</option>
										<option value="married">Married</option>
										<option value="divorced">Divorced</option>
										<option value="separated">Separated</option>
										<option value="widowed" <?php echo "selected='selected'";?>>Widowed</option>
									<?php } ?>
								</select>
							</td>
							<td></td>
						</tr>
						<tr id="homeadd">
							<td><label for="homeadd">Home Address:</label></td>
							<td><input type="text" name="homeadd" id="homeadd" size="50" value="<?php echo $homeadd; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['homeaddisnull'])) echo $isnull;
								if(isset($_SESSION['scripthomeadd'])) echo $script;
							?>
						</tr>
						<tr>
							</td>
							<td><label for="homebrgy">Home Barangay:</label></td>
							<td><input type="text" name="homebrgy" id="homebrgy" value="<?php echo $homebrgy; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['homebrgyisnull']))	echo $isnull;
								if(isset($_SESSION['scripthomebrgy'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="hometown">Home Town:</label></td>
							<td><input type="text" name="hometown" id="hometown" value="<?php echo $hometown; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['hometownisnull']))	echo $isnull;
								if(isset($_SESSION['scripthometown'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="homeprov">Home Province:</label></td>
							<td><input type="text" name="homeprov" id="homeprov" value="<?php echo $homeprov; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['homeprovisnull']))	echo $isnull;
								if(isset($_SESSION['scripthomeprov'])) echo $script;
							?>
							</td>
						</tr>
						
						<tr id="officeadd">
							<td><label for="officeadd">Office Address:</label></td>
							<td><input type="text" name="officeadd" id="officeadd" size="50" value="<?php echo $officeadd; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['officeaddisnull'])) echo $isnull;
								if(isset($_SESSION['scriptofficeadd'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="offbrgy">Office Barangay:</label></td>
							<td><input type="text" name="offbrgy" id="offbrgy" value="<?php echo $offbrgy; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['offbrgyisnull']))	echo $isnull;
								if(isset($_SESSION['scriptoffbrgy'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="offtown">Office Town:</label></td>
							<td><input type="text" name="offtown" id="offtown" value="<?php echo $offtown; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['offtownisnull']))	echo $isnull;
								if(isset($_SESSION['scriptofftown'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="offprov">Office Province:</label></td>
							<td><input type="text" name="offprov" id="offprov" value="<?php echo $offprov; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['offprovisnull']))	echo $isnull;
								if(isset($_SESSION['scriptoffprov'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="birthplace">
							<td><label for="birthplace">Birthplace:</label></td>
							<td><input type="text" name="birthplace" id="birthplace" value="<?php echo $birthplace; ?>"/></td><td>
							<?php
								if(isset($_SESSION['birthplaceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptbirthplace'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="birthday">
							<td><label for="birthday">Birthday: (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="birthday" id="birthday" value="<?php echo $birthday; ?>"/></td>
							<td>		
							<?php
								if(isset($_SESSION['birthdayisnull'])) echo $isnull;
								//if(isset($_SESSION['invalidsci'])) echo $invalid;
							?>
							</td>
						</tr>
						<tr id="email">
							<td><label for="email">Email Address:</label></td>
							<td><input type="text" name="email" id="email" value="<?php echo $email; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['emailisnull']))	echo $isnull;
								if(isset($_SESSION['scriptemail'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="occupation">
							<td><label for="occupation">Present Occupation:</label></td>
							<td><input type="text" name="occupation" id="occupation" value="<?php echo $occupation; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['occupationisnull']))	echo $isnull;
								if(isset($_SESSION['scriptoccupation'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="cit">
							<td><label for="cit">Citizenship:</label></td>
							<td><input type="text" name="cit" id="cit" value="<?php echo $cit; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['citisnull'])) echo $isnull;
								if(isset($_SESSION['scriptcit'])) echo $script;
								//if(isset($_SESSION['invalidcit'])) echo $invalid;
							?>
							</td>
						</tr>
						<tr id="license">
							<td><label for="license">Driver's License Number:</label></td>
							<td><input type="text" name="license" id="license" value="<?php echo $license; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['licenseisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicense'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="where">
							<td><label for="where">Where was it issued? (LTO Branch)</label></td>
							<td><select name="where" id="whereIssued">
								<option value="D01" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D01')) echo "selected='selected'";?>>D01 - Batangas Licensing Center</option>
											<option value="D02" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D02')) echo "selected='selected'";?>>D02 - Imus District Office</option>
											<option value="D03" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D03')) echo "selected='selected'";?>>D03 - Boac District Office</option>
											<option value="D04" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D04')) echo "selected='selected'";?>>D04 - Boac District Office</option>
											<option value="D05" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D05')) echo "selected='selected'";?>>D05 - Calapan District Office</option>
											<option value="D06" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D06')) echo "selected='selected'";?>>D06 - Cavite Licensing Center</option>
											<option value="D07" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D07')) echo "selected='selected'";?>>D07 - Gumaca District Office</option>
											<option value="D08" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D08')) echo "selected='selected'";?>>D08 - Lipa District Office</option>
											<option value="D09" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D09')) echo "selected='selected'";?>>D09 - Quezon Licensing Center</option>
											<option value="D10" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D10')) echo "selected='selected'";?>>D10 - Romblon District Office</option>
											<option value="D11" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D11')) echo "selected='selected'";?>>D11 - Palawan District Office</option>
											<option value="D12" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D12')) echo "selected='selected'";?>>D12 - Pila District Office</option>
											<option value="D13" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D13')) echo "selected='selected'";?>>D13 - San Jose District Office</option>
											<option value="D14" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D14')) echo "selected='selected'";?>>D14 - Laguna Licensing Center</option>
											<option value="D16" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D16')) echo "selected='selected'";?>>D16 - Cainta Extension Office</option>
											<option value="D17" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D17')) echo "selected='selected'";?>>D17 - Cavite District Office</option>
											<option value="D18" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D18')) echo "selected='selected'";?>>D18 - Tagaytay Extension Office</option>
											<option value="D19" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D19')) echo "selected='selected'";?>>D19 - Binangonan Extension Office</option>
											<option value="D20" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D20')) echo "selected='selected'";?>>D20 - Taal Extension Office</option>
											<option value="D21" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D21')) echo "selected='selected'";?>>D21 - Santa Rosa DLRC</option>
											<option value="D22" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D22')) echo "selected='selected'";?>>D22 - Calamba District Office</option>
											<option value="D23" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D23')) echo "selected='selected'";?>>D23 - Dasmarinas District Office</option>
											<option value="D24" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='D24')) echo "selected='selected'";?>>D24 - E Patrol District Office</option>
											<option value="A++" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='A++')) echo "selected='selected'";?>>A++ - Region 1</option>
											<option value="B++" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='B++')) echo "selected='selected'";?>>B++ - Region 2</option>
											<option value="C++" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='C++')) echo "selected='selected'";?>>C++ - Region 3</option>
											<option value="E++" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='E++')) echo "selected='selected'";?>>E++ - Region 5</option>
											<option value="N++" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='N++')) echo "selected='selected'";?>>N++ - National Capital Region</option>
											<option value="OTHERS" <?php if((isset($_SESSION['editwhere'])) && ($_SESSION['editwhere']=='OTHERS')) echo "selected='selected'";?>>Others</option>
											</select>
							</td>
						</tr>
						<tr id="when">
							<td><label for="when">When was is issued? (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="when" id="when" value="<?php echo $when; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['whenisnull'])) echo $isnull;
								if(isset($_SESSION['scriptwhen'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="expiry">
							<td><label for="expiry">Expiry Date: (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="expiry" id="expiry" value="<?php echo $expiry; ?>"/></td>
							<td>
							<?php
								if(isset($_SESSION['expiryisnull'])) echo $isnull;
								if(isset($_SESSION['scriptexpiry'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="picture">2x2 Picture</label></td>
							<td>
								<?php
									echo "<input type='hidden' name='pictureVal' value='".$picture."'>";
									echo "<input type='file' name='picture' id='picture' value='' disabled='disabled'>";
									echo "&nbsp;&nbsp;&nbsp;";
									echo "<input type='checkbox' name='pictureCheck' id='pictureCheck' value='1'>update file?";
								?>
								<script>
									jQuery("#pictureCheck").change(function(){
										if(jQuery("#pictureCheck").attr("checked")){
											jQuery("#picture").prop('disabled', false);
										}else{
											jQuery("#picture").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['pictureisnull'])) echo $isnull;
								if(isset($_SESSION['scriptpicture'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
										<td><label for="licensepic">Scanned image of license:</label></td>
										<td>
											<?php
												echo "<input type='hidden' name='licensepicVal' value='".$licensepic."'>";
												echo "<input type='file' name='licensepic' id='licensepic' value='' disabled='disabled'>";
												echo "&nbsp;&nbsp;&nbsp;";
												echo "<input type='checkbox' name='licensepicCheck' id='licensepicCheck' value='1'>update file?";
											?>
											<script>
												jQuery("#licensepicCheck").change(function(){
													if(jQuery("#licensepicCheck").attr("checked")){
														jQuery("#licensepic").prop('disabled', false);
													}else{
														jQuery("#licensepic").prop('disabled', true);
													}
												});
											</script>
										</td>
										<td>
										<?php
											if(isset($_SESSION['licensepicisnull'])) echo $isnull;
											if(isset($_SESSION['scriptlicensepic'])) echo $script;
										?>
										</td>
									</tr>
					</table>
					<input type="submit" name="update" value="Update"/>
					<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ""; ?>" />
					<input type="hidden" name="profileType" value="<?php echo $profiletype; ?>">
					<input type="hidden" name="username" value="<?php echo $uname; ?>">
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	$connect->closeconnection($con);
	unset($_SESSION['editerror']);
	unset($_SESSION['editprofiletype']);
	unset($_SESSION['edituname']);
	unset($_SESSION['editlname']);
	unset($_SESSION['editfname']);
	unset($_SESSION['editmname']);
	unset($_SESSION['editgender']);
	unset($_SESSION['editcivil']);
	unset($_SESSION['edithomeadd']);
	unset($_SESSION['edithomebrgy']);
	unset($_SESSION['edithometown']);
	unset($_SESSION['edithomeprov']);
	unset($_SESSION['editofficeadd']);
	unset($_SESSION['editoffbrgy']);
	unset($_SESSION['editofftown']);
	unset($_SESSION['editoffprov']);
	unset($_SESSION['editbirthplace']);
	unset($_SESSION['editbirthday']);
	unset($_SESSION['editoccupation']);
	unset($_SESSION['editemail']);
	unset($_SESSION['editcit']);
	unset($_SESSION['editlicense']);
	unset($_SESSION['editwhere']);
	unset($_SESSION['editwhen']);
	unset($_SESSION['editexpiry']);
	
	if(isset($_SESSION['scriptlname'])) unset($_SESSION['scriptlname']);
	if(isset($_SESSION['scriptfname'])) unset($_SESSION['scriptfname']);
	if(isset($_SESSION['scriptmname'])) unset($_SESSION['scriptmname']);
	if(isset($_SESSION['scriptunameisnull'])) unset($_SESSION['$unameisnull']);
	if(isset($_SESSION['scriptpwordisnull'])) unset($_SESSION['$pwordisnull']);	
	if(isset($_SESSION['lnameisnull'])) unset($_SESSION['lnameisnull']);
	if(isset($_SESSION['fnameisnull'])) unset($_SESSION['fnameisnull']);
	if(isset($_SESSION['mnameisnull'])) unset($_SESSION['mnameisnull']);
	if(isset($_SESSION['unameisnull'])) unset($_SESSION['unameisnull']);
	if(isset($_SESSION['pwordisnull'])) unset($_SESSION['pwordisnull']);
	if(isset($_SESSION['genderisnull'])) unset($_SESSION['genderisnull']);
	if(isset($_SESSION['civilisnull'])) unset($_SESSION['civilisnull']);
	if(isset($_SESSION['homeaddisnull'])) unset($_SESSION['homeaddisnull']);
	if(isset($_SESSION['homebrgyisnull'])) unset($_SESSION['homebrgyisnull']);
	if(isset($_SESSION['hometownisnull'])) unset($_SESSION['hometownisnull']);
	if(isset($_SESSION['homeprovisnull'])) unset($_SESSION['homeprovisnull']);
	if(isset($_SESSION['officeaddisnull'])) unset($_SESSION['officeaddisnull']);
	if(isset($_SESSION['offbrgyisnull'])) unset($_SESSION['offbrgyisnull']);
	if(isset($_SESSION['offtownisnull'])) unset($_SESSION['offtownisnull']);
	if(isset($_SESSION['offprovisnull'])) unset($_SESSION['offprovisnull']);
	if(isset($_SESSION['birthplaceisnull'])) unset($_SESSION['birthplaceisnull']);
	if(isset($_SESSION['birthdayisnull'])) unset($_SESSION['birthdayisnull']);
	if(isset($_SESSION['occupationisnull'])) unset($_SESSION['occupationisnull']);
	if(isset($_SESSION['emailisnull'])) unset($_SESSION['emailisnull']);
	if(isset($_SESSION['citisnull'])) unset($_SESSION['citisnull']);
	if(isset($_SESSION['licenseisnull'])) unset($_SESSION['licenseisnull']);
	if(isset($_SESSION['whereisnull'])) unset($_SESSION['whereisnull']);
	if(isset($_SESSION['whenisnull'])) unset($_SESSION['whenisnull']);
	if(isset($_SESSION['expiryisnull'])) unset($_SESSION['expiryisnull']);
?>
<script language="javascript" type="text/javascript">
	function showDetails(){
		var message = "PLEASE REVIEW INFORMATION BEFORE SUBMITTING" + "\n\n";
		
		var pword = jQuery("input#pword").val();
		var lname = jQuery("input#lname").val();
		var fname = jQuery("input#fname").val();
		var mname = jQuery("input#mname").val();
		var contactnumber = jQuery("input#contactnumber").val();
		var gender = jQuery("select#gender").val();
		var civil = jQuery("select#civil").val();
		var homeadd = jQuery("input#homeadd").val();
		var homebrgy = jQuery("input#homebrgy").val();
		var hometown = jQuery("input#hometown").val();
		var homeprov = jQuery("input#homeprov").val();
		var birthplace = jQuery("input#birthplace").val();
		var birthday = jQuery("input#birthday").val();
		var email = jQuery("input#email").val();
		var occupation = jQuery("input#occupation").val();
		var cit = jQuery("input#cit").val();
		var license = jQuery("input#license").val();
		var whereIssued = jQuery("select#whereIssued").val();
		var when = jQuery("input#when").val();
		var expiry = jQuery("input#expiry").val();
		
		message += "Password: " + pword + "\n"
			+ "Last Name: " + lname + "\n"
			+ "First Name: " + fname + "\n"
			+ "Middle Name: " + mname + "\n"
			+ "Contact Number: " + contactnumber + "\n"
			+ "Gender: " + gender + "\n"
			+ "Civil Status: " + civil + "\n"
			+ "Home Address: " + homeadd + "\n"
			+ "Home Barangay: " + homebrgy + "\n"
			+ "Home Town: " + hometown + "\n"
			+ "Home Province: " + homeprov + "\n"
			+ "Birth Place: " + birthplace + "\n"
			+ "Birthday: " + birthday + "\n"
			+ "Email: " + email + "\n"
			+ "Occupation: " + occupation + "\n"
			+ "License Number: " + license + "\n"
			+ "License Issued Date: " + whereIssued + "\n"
			+ "License Expiry Date: " + when + "\n";
		
		return confirm(message);
	}
</script>