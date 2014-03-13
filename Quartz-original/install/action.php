

<?php

	//get all the variables, to make life more readable
	$rootpass = htmlspecialchars($_POST['rootpass']);
		if($rootpass == 0)
			$rootpass = "";
	$serverurl = htmlspecialchars($_POST['serverurl']);
	$adminname = htmlspecialchars($_POST['admin']);
	$adminp = htmlspecialchars($_POST['adminpass']);
	$dbname = htmlspecialchars($_POST['dbname']);

	$serverhost = htmlspecialchars($_POST['serverhost']);
	// set $serverhost to "http://localhost:81/" if you had to use port 81 to resolve the Skype issue
	$rootpath = htmlspecialchars($_POST['rootpath']);
	$rootpath .= "/";
	$canmail = 0;
	if(htmlspecialchars($_POST['canmail']) == "yes")
		$canmail = 1;

	//open dbvars
 	$ourFileName = "dbvars.php";
	$dbv = fopen($ourFileName, 'w') or die("Can't open file");

	//this clears dbvars and starts it anew
	$strData = "<!--
//This is new dbvars.php
//purpose of this script is to hold all of the important Quartz variables and many other
//files use this.
//This file is created by action.php
//end of comments-->

<?php

\$q = \"\\\"\";\n";
	fwrite($dbv, $strData);

	$strData = "\$rootpass = \"$rootpass\";\n";
	fwrite($dbv, $strData);

	$strData = "\$serverurl = \"$serverurl\";\n";
	fwrite($dbv, $strData);

	$strData = "\$adminname = \"$adminname\";\n";
	fwrite($dbv, $strData);

	$strData = "\$adminp = \"$adminp\";\n";
	fwrite($dbv, $strData);

	$strData = "\$dbname = \"$dbname\";\n";
	fwrite($dbv, $strData);

	$strData = "\$serverhost = \"$serverhost\";\n";
	fwrite($dbv, $strData);

	$strData = "\$rootpath = \"$rootpath\";\n";
	fwrite($dbv, $strData);


	$strData = "\$canmail = $canmail;\n";
	fwrite($dbv, $strData);

	fwrite($dbv, "?>");

include 'dbvars.php';
include 'makeDatabases.php';

//does all the work in making a database and granting admin access
setUpDatabases();




?>