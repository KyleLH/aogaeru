<?php
include Model.php;
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
    // localhost:8888/aogaeru/Quartz-original/index.php?id=kholz1
    $name = $_REQUEST['id'];

    //Construct BU email address.

    $email = $name."@bu.edu";

    //If a record of the website doesn't exist of the website is marked offline then
    //redirect to the under construction page

    if (getStatus($name) == 0)
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
        <title><?php $name." @ Boston University"; ?></title>
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
                              <div class = "crop"> <img src = <?php echo getPicture($name); ?> > </div>
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
                        if (getAwards($name)) echo "<div class='linkbox'><a href='index.php?p=awards'>Awards</a></div><br>";
                        if (getProjects($name)) echo "<div class='linkbox'><a href='index.php?p=projects'>Projects</a></div><br>";
                        if (getStudents($name)) echo "<div class='linkbox'><a href='index.php?p=students'>Students</a></div><br>";
                        if (getPersonal($name)) echo "<div class='linkbox'><a href='index.php?p=personal'>Personal</a></div><br>";
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
                                echo $name;
                            ?>
                        </span>
                        <br>
                        <span style=" font-size:14px;">
                            <?php
                                //Name goes here.
                               echo '<i>'.getTitle($name).'</i>';
                            ?>
                        </span>
                        <hr noshade width="440px" align="left">

                    <h5>
                        Contact Information:
                    </h5>
                    <span style=" font-size:14px;">
                     <?php
                        //Telephone number.
                        echo getAddress($name);
                    ?>
                    <br>
                    Tel:
                    <?php
                        //Telephone number.
                        echo getPhone($name);
                    ?>
                    , Fax:
                    <?php
                        //Telephone number.
                        echo getFax($name);
                    ?>

                    <br>
                    <?php 
                        //Display the users email address. 
                        echo getEmail($name);
                    ?>

                    <h5>Office Hours:</h5>
                    <?php
                        echo getOffice($name);
                    ?>
                    </span>
                    <h5>
                        Short Biography:
                    </h5>
                    <span class="nlink" style=" font-size:12px; text-align:justify">
                        <?php
                            //Short bio goes here.
                            echo getBio($name);
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
                            echo getResearch($name);
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
                                echo getAwards($name);
                            ?>
                        </span>
                    <hr>
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
                                echo getProjects($name);
                            ?>
                        </span>
                    <hr>
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
                                echo getStudents($name);
                            ?>
                        </span>
                    <hr>
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
                                echo getPersonal($name);
                            ?>
                        </span>
                    <hr>
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
