<html>
	<?php 
		session_start();
		include 'header.php'; 
	?>
<head>    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="Style.css" />
        <title>Change password</title>

</head>

<body bgcolor="#EEEEEE">

            <center>
            <div style="position: relative; width: 945px; height: 400px; background: url('images/Body.jpg');">
                <div style="position: relative; font-family:Tahoma; font-size:14px; top: 50px; background: url('images/Changepassword.jpg'); width: 525px; height: 246px;">
                    <br><br><br><br><br><br>
                    <form action='changepassword.php' method='POST'>
                    <!--[CPW.001]-->
                    	Old Password : <input type="password" name="oldpass" value ="" size="40" /> <br> 
                        New Password : <input type="password" name="newpass1" value ="" size="40" /> <br>
                        Confirm New Password : <input type="password" name="newpass2" value ="" size="40" /> <br><br>
                        <br><br>       <input type="submit" value="Change Password" name="changePass"/>
                    </form>
                </div>
            </div>
            </center>
</body>

<?php include 'footer.php'; ?>

</html>


<?php
include 'dbvars.php';

//Checks if the user is logged in
if (!isset($_SESSION['usertype'])) echo "<script language=javascript>alert('You must be logged in to use this feature!')</script>";

//attempt to change the password if the form was submited.
if(isset($_POST['changePass']) AND isset($_SESSION['usertype'])){

	if($_POST['newpass1'] != $_POST['newpass2']){//[CPW.002]
		//New passwords didn't match
        echo "<script language=javascript>alert('The new password conformation does not match!')</script>";
	} else {
		//open the database
		mysql_connect($serverurl, $adminname, $adminp) or die(mysql_error("could not connect to database server"));
		mysql_select_db($dbname) or die(mysql_error("could not select database"));


		//Store passwords in local variables	
		$oldPassword = md5($_POST['oldpass']);
		$newPassword = md5($_POST['newpass1']);
		
		
		//Pull user's email from session data
		$userName = substr($_SESSION['email'],0,strlen($_SESSION['email'])-7) . "@bu.edu";
		
		
		//get old password from database
		$check = mysql_query("SELECT * FROM nLogin WHERE email = '". $userName. "'")or die(mysql_error());
        $info = mysql_fetch_array( $check );
    
    
		//if the password on file matches the users input
		if($oldPassword == $info['password']){//[CPW.003]
			//update the database to new pass [CPW.004]
			$update = "UPDATE nLogin SET password='".$newPassword."' WHERE email = '". $userName ."'";
            $output = mysql_query($update);
            echo "<script language=javascript>alert('Password Updated!')</script>";
		} else {
            echo "<script language=javascript>alert('The password you entered is not correct!')</script>";//[CPW.003]
		}
	}
	
}


?>