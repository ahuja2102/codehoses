<?php
if (!isset($_SESSION)) 
{
    session_start();
}
?>
<!DOCTYPE>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum :: Home Page</title>
    
    <!-- CSS AND BOOTSTRAP-->
    <script src="js/bootstrap.min.js"></script>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.js"></script>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
        
    <!-- Custom -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome-4.0.3/css/font-awesome.min.css">

    <!-- CSS STYLE-->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen" />
    <script type="text/javascript" src="js/jquery.js"></script>

    <!-- get jQuery from the google apis -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>

    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- LOOK THE DOCUMENTATION FOR MORE INFORMATIONS -->
    <script type="text/javascript">
            
        var revapi;

        jQuery(document).ready(function() {
            "use strict";
            revapi = jQuery('.tp-banner').revolution(
                    {
                        delay: 15000,
                        startwidth: 1200,
                        startheight: 278,
                        hideThumbs: 10,
                        fullWidth: "on"
                    });

        }); //ready

    </script>   

</head>
<body>

       <!--  <div class="container-fluid"> -->
            <div class="tp-banner-container">
                <div class="tp-banner" >
                    <ul>    
                        <!-- SLIDE  -->
                        <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                            <!-- MAIN IMAGE -->
                            <img src="images/slide.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                            <!-- LAYERS -->
                        </li>
                    </ul>
                </div>
            </div>
            
           <div class="headernav">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1 col-xs-3 col-sm-2 col-md-2 logo "><a href="index.php"><img src="images/novostack.png" alt="" style="width: 60px; margin-top: 5px;" /></a></div>
                        <div class="col-lg-4 search hidden-xs hidden-sm col-md-3">
                            <div class="wrap">
                                <form action="search.php?action=topics" id="submit_topic" method="post" class="form">
                                    <div class="pull-left txt">
                                        <input type="text" class="form-control" placeholder="Search Topics" name="search">
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-default" type="button"><i class="fa fa-search" onclick="$('#submit_topic').submit();"></i></button></div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 col-sm-5 col-md-4 avt" style="margin-left: 300px;">
                            <div class="stnt pull-left">                            
                                <form action="03_new_topic.php" method="post" class="form">
                                    <button class="btn btn-primary">Add a post</button>
                                </form>
                            </div>
                            <div class="env pull-left"><i class="fa fa-envelope"></i></div>
                        <?php 
                            if(isset($_SESSION['id'])) 
                                { 
                        ?>
                            <div class="avatar pull-left dropdown">
                                <a data-toggle="dropdown" href="#"><img src="uploads/<?php if(isset($_SESSION['pic'])) {echo $_SESSION['pic'];} else { echo 'user.jpg';} ?>" alt="" width="40px"/></a> <b class="caret"></b>
                                <div class="status green">&nbsp;</div>
                                <ul class="dropdown-menu" role="menu" >
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="profile.php">My Profile</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-3" href="transact_user.php?action=Logout">Log Out</a></li>
                                     <!-- <li role="presentation"><a role="menuitem" tabindex="-4" href="04_new_account.html">Create account</a></li>  -->
                                </ul>
                            </div>
                            <?php } else { ?>
                                <div class="stnt pull-left">                            
                                <form action="05_login.php" method="post" class="form">
                                    <button class="btn btn-primary">Login</button>
                                </form>
                            </div>
                            <?php
                                }
                            ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

       
</body>
</html>