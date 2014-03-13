<?php

// phpinfo();

// die();

//============================================================
//Filename : template/index.php
//Variables :
//  Local:
//      $name - email address of website owner.
//      $username - bu name of website owner.
//      $info - database entry for the website owner.
//  $_GET:
//      'p' - The page that needs to be opened.
//
//============================================================

    session_start();

    include '../dbvars.php';

    //Extract the bu name of website owner from the current directory name.

    $name = dirname($_SERVER['PHP_SELF']);

    do
    {
        $name = strstr(substr($name,1),"/");
    }
    while (strstr(substr($name,1),"/") != "");

    $username = substr($name,1);

    //Construct BU email address.

    $name = substr($name,1)."@bu.edu";

    //Connect to mysql server and access website information.

    mysql_connect($serverurl, $adminname, $adminp) or die(mysql_error());
    mysql_select_db($dbname) or die(mysql_error());

    $check = mysql_query("SELECT * FROM webData WHERE email = '". $name. "'")or die(mysql_error());
    $info = mysql_fetch_array( $check );

    mysql_close();

    //If a record of the website doesn't exist of the website is marked offline then
    //redirect to the under construction page

    if (!$info || !$info['isonline']) // [INDX.0001]
    {
        Header('Location:  construction.php');
        exit;
    }

    if ( !isset($_GET['p']) )
    {
    	$_GET['p'] = "home";
    }

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">



<html>



    <head>



        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



        <link rel="stylesheet" type="text/css" href="../Style.css" />



        <title><?php echo $info['name']." @ Boston University"; ?></title>



    </head>



    <body bgcolor="#EEEEEE">

        <?php

            // Include the website header

            include '../header.php';

        ?>

        <div style="text-align:center;margin:0 auto;">
            <div style="position:relative; text-align:left; width: 945px; height: 650px; background: url('../images/webBody.jpg');margin-left: auto; margin-right: auto;">

                <?php
                    //If the home page is being accessed then display the professors image.
                    if (isset($_GET['p']) && ($_GET['p'] == "" || $_GET['p'] == "home")) {
                ?>

                <div style="text-align:left; position: relative; top: 5px; right:-710px; width: 200px; height: 300px; z-index:0;">
                    <table style="border-style:solid; border-width:1px">
                        <tr>
                            <td>
                                <?php
                            		// return an array with 7 elements, index 3 is height="yyy" width="xxx"
                            		$size = getimagesize("picture.jpg"); // [PHOTO.0001]
                            		
                            		// to obatin the position of quotation mark in the string 
                            		$quo1 = strpos($size['3'], '"');
                            		$quo2 = strpos($size['3'], '"', $quo1 + 1);
                            		$quo3 = strpos($size['3'], '"', $quo2 + 1);
                            		$quo4 = strpos($size['3'], '"', $quo3 + 1);
                            		
                            		// extract the width and height of the uploaded image by the user [PHOTO.0003]
                            		$old_width = substr($size['3'], $quo1 + 1, $quo2 - $quo1 - 1);
                            		$old_height = substr($size['3'], $quo3 + 1, $quo4 - $quo3 - 1);
                            		
                            		// adjust the ratio of the uploaded image, to let one of its side to fit the fix size  [PHOTO.0003]
                            		if($old_height > 300)
                            		{
                            			$new_width = $old_width * (300/$old_height);
                            			$new_height = 300;
                            		}
                            		else if($old_width > 200)
                            		{
                            			$new_height = $old_height * (200/$old_width);
                            			$new_width = 200;
                            		}
                            		
                            		// create a copy of the resize image from the user's uploaded image
                            		$new_image = imagecreate($new_width, $new_height);
                            		$old_image = imagecreatefromjpeg("picture.jpg"); // [PHOTO.0001]
                            		imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
                            		imagejpeg($new_image, 'resize_picture.jpg');
                
                            	?>
                            
                             	<div class = "crop"> <img src = "resize_picture.jpg" > </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <?php
                    }
                ?>

                <div style="position:absolute ; text-align:left; top:10px; left:30px;">
                    <div class="weblink">
                        <div class="linkbox"><a href="index.php">Home</a></div><br>
                        <div class="linkbox"><a href="index.php?p=teaching">Teaching</a></div><br>
                        <div class="linkbox"><a href="index.php?p=research">Research</a></div><br>
                        <?php
                        if ($info['awards'] == "1") echo "<div class='linkbox'><a href='index.php?p=awards'>Awards</a></div><br>";
                        if ($info['projects'] == "1") echo "<div class='linkbox'><a href='index.php?p=projects'>Projects</a></div><br>";
                        if ($info['students'] == "1") echo "<div class='linkbox'><a href='index.php?p=students'>Students</a></div><br>";
                        if ($info['personal'] == "1") echo "<div class='linkbox'><a href='index.php?p=personal'>Personal</a></div><br>";
                        ?>

                    </div>
                </div>

                <?php
                    //If the home page is being accessed then display the home page.
                    if (isset($_GET['p']) && ($_GET['p'] == "" || $_GET['p'] == "home")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Name goes here.
                                echo $info['name'];
                            ?>
                        </span>
                        <br>
                        <span style=" font-size:14px;">
                            <?php
                                //Name goes here.
                               echo '<i>'.$info['jobtitle'].'</i>';
                            ?>
                        </span>
                        <hr noshade width="440px" align="left">

                    <h5>
                        Contact Information:
                    </h5>
                    <span style=" font-size:14px;">
                     <?php
                        //Telephone number.
                        echo $info['office'];
                    ?>
                    <br>
                    Tel:
                    <?php
                        //Telephone number.
                        echo $info['phone'];
                    ?>
                    , Fax:
                    <?php
                        //Telephone number.
                        echo $info['fax'];
                    ?>

                    <br>
                    <?php //Display the users email address. ?>
                    <img src= <?php echo "email_img.php?user=".$username; ?> />

                    <h5>Office Hours:</h5>
                    <?php
                        echo $info['ofhours'];
                    ?>
                    </span>
                    <h5>
                        Short Biography:
                    </h5>
                    <span class="nlink" style=" font-size:12px; text-align:justify">
                        <?php
                            //Short bio goes here.
                            echo $info['bio'];
                        ?>
                    </span>
                    <br>
                </div>
                <?php
                    }
                    //=================================================================================================================
                    //If the teaching is requested then display the teaching page.
                    if (isset($_GET['p']) && ($_GET['p'] == "teaching")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Title.
                                echo 'Course List:';
                            ?>
                        </span>
                    <hr>
                        <span class="nlink" style="font-size:12px;">
                            <br>
                            <?php
                                //Display each course with description using a while loop.
                                $clist = $info['teaching'];
                                //While courses remain.
                                while ($clist != "") {
                                    //Get course name
                                    $title = substr($clist,0,strpos($clist,";"));
                                    $clist = substr($clist,strpos($clist,";")+1);
                                    //Get course link.
                                    $link = substr($clist,0,strpos($clist,";"));
                                    $clist = substr($clist,strpos($clist,";")+1);
                                    //Get Course description.
                                    $desc = substr($clist,0,strpos($clist,";"));
                                    $clist = substr($clist,strpos($clist,";")+1);
                                    //Print it.
                                    echo "<a href='".$link."'>".$title."</a>".$desc."<br><br>";
                                }
                            ?>
                        </span>

                </div>
                <?php
                    }
                    //=================================================================================================================
                    //If the research is requested then display the research page.
                    if (isset($_GET['p']) && ($_GET['p'] == "research")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Heading.
                                echo 'Research:';
                            ?>
                        </span>
                    <hr>
                    <h5>Research Summary:</h5>
                    <span class ="nlink" style=" font-size:12px; text-align:justify">
                        <?php
                            //Display research summary.
                            echo $info['researchsum'];
                        ?>
                        <br><br><br><b>Research and Publications Overview : <a href="">PDF</a> | <a href="">XPS</a> | <a href="">TXT</a> </b>
                    </span>

                </div>
                <?php
                    }
                    //=================================================================================================================
                    //If the awards is requested then display the awards page.
                    if (isset($_GET['p']) && ($_GET['p'] == "awards")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Heading.
                                echo 'Awards:';
                            ?>
                        </span>
                    <hr>
                    <iframe src="awards.html" width="620px" height="500px" frameborder="0"></iframe>
                </div>
                <?php
                    }
                    //=================================================================================================================
                    //If the projects is requested then display the projects page.
                    if (isset($_GET['p']) && ($_GET['p'] == "projects")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Name goes here.
                                echo 'Projects:';
                            ?>
                        </span>
                    <hr>
                    <iframe src="projects.html" width="620px" height="500px" frameborder="0"></iframe>
                </div>
                <?php
                    }
                    //=================================================================================================================
                    //If the Students is requested then display the students page.
                    if (isset($_GET['p']) && ($_GET['p'] == "students")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Title.
                                echo 'PhD Students:';
                            ?>
                        </span>
                    <hr>
                    <iframe src="students.html" width="620px" height="500px" frameborder="0"></iframe>
                </div>
                <?php
                    }
                    //=================================================================================================================
                    //If the personal is requested then display the personal page.
                    if (isset($_GET['p']) && ($_GET['p'] == "personal")) {
                ?>
                <div style="position:absolute; top:10px; left:250px; font-family:Tahoma; width:640px;">
                        <span style=" font-size:20px; font-weight:bold">
                            <?php
                                //Title.
                                echo 'Personal:';
                            ?>
                        </span>
                    <hr>
                    <iframe src="personal.html" width="620px" height="500px" frameborder="0"></iframe>
                </div>
                <?php
                    }
                ?>
            </div>

</div>

        <?php

            //Include the website footer.
            include '../footer.php';

        ?>


    </body>

</html>
