<?php
 include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forum :: Login</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom -->
        <link href="css/custom.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->

        <!-- fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="font-awesome-4.0.3/css/font-awesome.min.css">

        <!-- CSS STYLE-->
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

        <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
        <link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen" />

</head>
<body class = "newaccountpage">
    <br><br>
    
     <!-- //echo $_SERVER['HTTP_REFERER']; -->
    
            <div class="container_fluid">  
              <section class="content">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-8 breadcrumbf">
                        <a href="#">Login</a> 
                    </div>
                  </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">

                                <?php 
                                    if (isset($_GET['msg'])) 
                                    {
                                ?>
                                    <div><p style="color:#FF0000;"><?php echo $_GET['msg'];?></p></div>
                                <?php } ?>
                            <!-- POST -->
                            <div class="post">
                               
                                <form action="transact_user.php" class="form newtopic" method="post">
                                    <div class="postinfotop">
                                        <h2>Login</h2>
                                    </div>

                                    <!-- acc section -->
                                    <div class="accsection">
                                        <div class="topwrap">
                                    
                                            <div class="posttext pull-left">
                                        
                                                <div class="col-lg-6 col-md-6">
                                                    <input type="text" placeholder="User Name" class="form-control" name="username" required/>
                                                </div>
                                            </div>    

                                            <div class="posttext pull-left">    
                                                <div class="col-lg-6 col-md-6">    
                                                  <input type="password" placeholder="Password" class="form-control" id="pass" name="pass" required/>
                                                </div>
                                

                                            </div>
                                            <div class="clearfix"></div>
                                        </div>  
                                    </div><!-- acc section END -->


                                    <div class="postinfobot">
                                        <div class="pull-right postreply">
                                            <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
                                            <div class="pull-left"><button type="submit" class="btn btn-primary" name="action" value="Login">Login</button></div>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                              <div class="col-lg-6 col-md-6">
                                <p style="font-size: 16px">New User? <a href="04_new_account.php">Click Here</a></p>
                              </div>  
                            </div><!-- POST -->






                        </div>
                        <?php 
                          include 'sidebar.php';
                        ?>
                        
                    </div>
                    <?php
                        include 'footer.php';
                    ?>
                </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>

        <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
        <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
        <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>


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
                
</body>
</html>