<?php
    include 'header.php';
    if (isset($_GET['error']))
    {    
        $errors[] = unserialize($_GET['error']);
    }    
?>
<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from forum.azyrusthemes.com/04_new_account.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Jul 2018 14:41:02 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forum :: New account</title>

        <script type="text/javascript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah')
                            .attr('src', e.target.result)
                            .width(60)
                            .height(60);
                        };

                        reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                <?php 
                    if (isset($errors[0]['first'])) 
                    {
                        ?>
                            $('#first').after('<p style="color: #FF0000;"><?php echo $errors[0]['first'];?>');         
                        <?php
                    }
                    if (isset($errors[0]['last'])) 
                    {
                        ?>
                            $('#last').after('<p style="color: #FF0000;"><?php echo $errors[0]['last'];?>');
                        <?php
                    }
                    if (isset($errors[0]['u_err'])) 
                    {
                        ?>
                            $('#user').after('<p style="color: #FF0000;"><?php echo $errors[0]['u_err'];?>');
                        <?php
                    }
                    if (isset($errors[0]['email_err'])) 
                    {
                        ?>
                            $('#email').after('<p style="color: #FF0000;"><?php echo $errors[0]['email_err'];?>');                 
                        <?php
                    }
                    if (isset($errors[0]['pass'])) 
                    {
                        ?>
                            $('#pass').after('<p style="color: #FF0000;"><?php echo $errors[0]['pass'];?>');
                        <?php
                    }

                ?>
            });
        </script>
    </head>
    <body class="newaccountpage">
        <div class="container-fluid">
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 breadcrumbf">
                            <a href="#">Create New account</a> 
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">

                            <!-- POST -->
                            <div class="post">
                                <form action="transact_user.php" class="form newtopic" method="post" enctype="multipart/form-data">
                                    <div class="postinfotop">
                                        <h2>Create New Account</h2>
                                    </div>

                                    <!-- acc section -->
                                    <div class="accsection">
                                        <div class="acccap">
                                            <div class="userinfo pull-left">&nbsp;</div>
                                            <div class="posttext pull-left"><h3>Required Fields</h3></div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="topwrap">
                                            <div class="userinfo pull-left">
                                                <div class="image-upload">
                                                    <label for="file-input">
                                                        <img src="images/avatar-blank.jpg"/ width="60px" id="blah" name="profilepic">
                                                    </label>

                                                    <input id="file-input" type="file" accept="image" onchange="readURL(this)" name="profilepic" style="display: none;" />
                                                </div>
                                                <div class="imgsize"><b>Profile Picture</b></div>
                                            </div>
                                            <div class="posttext pull-left">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <input type="text" data-toggle="popover" id="first" placeholder="First Name" class="form-control" name="first" required/>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <input type="text" data-toggle="popover" id="last" placeholder="Last Name" class="form-control" name="last" required/>
                                                    </div>
                                                </div>
                                                <div>
                                                    <input type="text" data-toggle="popover" id="username" placeholder="User name" class="form-control" name="username" required/>
                                                </div>
                                                 <div>
                                                    <input type="text" data-toggle="popover" id="email" placeholder="Email" class="form-control" name="email" required/>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <input type="password" data-toggle="popover" placeholder="Password" class="form-control" id="pass" name="pass" pattern=".{6,15}" required title="6 to 15 characters required" />
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <input type="password" placeholder="Retype Password" class="form-control" id="pass2" name="pass2" required/>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="clearfix"></div>
                                        </div>  
                                    </div><!-- acc section END -->


                                    <div class="postinfobot">
                                        <div class="pull-right postreply">
                                            <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
                                            <div class="pull-left"><button type="submit" class="btn btn-primary" name="action" value="Signup">Sign Up</button></div>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            <div class="col-lg-6 col-md-6">
                                <p style="font-size: 16px">Already Registered? Login <a href="05_login.php">Here</a></p>
                            </div>  
                        </div><br><br><br><br><br><br><!-- POST -->


                        </div>
                        <?php
                             include 'sidebar.php';
                        ?>
                    </div>
                </div>

            </section>

            <?php
                include 'footer.php';
            ?>
        </div>


        <!-- get jQuery from the google apis -->
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

            });	//ready 

        </script>

        <!-- END REVOLUTION SLIDER -->
    </body>

<!-- Mirrored from forum.azyrusthemes.com/04_new_account.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Jul 2018 14:41:03 GMT -->
</html>