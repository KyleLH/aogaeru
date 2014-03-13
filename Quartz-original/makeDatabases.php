<!--
//author: Samantha Baum
//makeDatabase.php
//based off of the example from lab 1
//The purpose of this script is to create the backend MySQL databases
-->
<?php


$thisfilename = "makeDatabases.php";
//connect to the server for the first time

function setUpDatabases(){

include 'dbvars.php';


$conn = mysql_connect($serverurl, "root", $rootpass);

$query = "CREATE DATABASE $dbname;";
mysql_query($query);

$query = "USE $dbname;";
mysql_query($query);

$query = "GRANT ALL ON $dbname.* TO '$adminname'@'$serverurl';";
mysql_query($query);

$query = "SET PASSWORD FOR '$adminname'@'$serverurl' = PASSWORD('$adminp');";
mysql_query($query);
//these queries are taken from the orignial DATABASE script

//loginSet
$query = "CREATE TABLE `loginSet` (
  `email` varchar(40) NOT NULL,
  `isApproved` int(5) NOT NULL default '0',
  `hash` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
mysql_query($query);

$query = "INSERT INTO `loginSet` (`email`, `isApproved`, `hash`) VALUES('$adminname@bu.edu', 1, '');";
mysql_query($query);



//nLogin
$query = "CREATE TABLE `nLogin` (
  `email` varchar(40) collate ascii_bin NOT NULL,
  `password` varchar(100) collate ascii_bin NOT NULL,
  `name` varchar(40) collate ascii_bin NOT NULL,
  `buid` varchar(9) collate ascii_bin NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  PRIMARY KEY  (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii COLLATE=ascii_bin;";

mysql_query($query);

//need to be able to change the admin password
$encradminp = md5($adminp);
$query = "INSERT INTO `nLogin` (`email`, `password`, `name`, `buid`, `isactive`) VALUES('$adminname@bu.edu', '$encradminp', 'admin', 'U00000000', 2);";
mysql_query($query);



//webData
$query = "CREATE TABLE `webData` (
  `email` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL default 'Title. Name M. Last',
  `bio` varchar(1500) NOT NULL default 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ...anim id est laborum.',
  `phone` varchar(15) NOT NULL default '(XXX) XXX-XXXX',
  `fax` varchar(40) NOT NULL default '(XXX) XXX-XXXX',
  `office` varchar(100) NOT NULL default '#XXX Street Name, BID-RMN <br> Boston, MA 02215, USA',
  `jobtitle` varchar(40) NOT NULL default 'Job Title Here',
  `ofhours` varchar(100) NOT NULL default 'Day TT:TT - TT:TT <br> Day TT:TT - TT:TT',
  `isonline` tinyint(1) NOT NULL default '0',
  `researchsum` varchar(2000) NOT NULL default 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ...anim id est laborum.',
  `teaching` varchar(1000) NOT NULL,
  `reslink` varchar(100) NOT NULL,
  `awards` varchar(5) NOT NULL,
  `projects` varchar(5) NOT NULL,
  `students` varchar(5) NOT NULL,
  `personal` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
mysql_query($query);

$query = "INSERT INTO `webData` (`email`, `name`, `bio`, `phone`, `fax`, `office`, `jobtitle`, `ofhours`, `isonline`, `researchsum`, `teaching`, `reslink`, `awards`, `projects`, `students`, `personal`) VALUES('$adminname@bu.edu', 'Title. Name M. Last', 'Lorem ipsum dolor ... est laborum.', '(XXX) XXX-XXXX', '(XXX) XXX-XXXX', '#XXX Street Name, BID-RMN <br> Boston, MA 02215, USA', 'Job Title Here', 'Day TT:TT - TT:TT <br> Day TT:TT - TT:TT', 1, 'Lorem ipsum dolor sit ...anim id est laborum.', 'CS XXX : Course Title;; - Lorem ipsum dolor ... pariatur.;CS XXX : Course Title;; - Lorem ipsum dolor ... pariatur.;', '', '', '', '', '');";
mysql_query($query);

//granting access to the admin
$query = "USE $dbname;";
mysql_query($query);

$query = "GRANT ALL ON $dbname.* TO '$adminname'@'bu.edu';";
mysql_query($query);

$query = "SET PASSWORD FOR '$adminname'@'bu.edu' = PASSWORD('$adminp');";
mysql_query($query);


print("Quartz is all set up! If you are admin, you are ready to begin using Quartz. Simply follow the below link to the login page and log in. If you are a professor, follow the link below to the Quartz login page. On that page, there is an option to create a new account. Choose that option and follow the instructions provided.\n");

Echo "<html>";
Echo "<a href=$rootpath>Go to Quartz now!</a>";
Echo "</html>";
}

?>	