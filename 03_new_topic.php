<?php
    include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forum :: New topic</title>

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
       
       <!-- Including Text Editor -->
        <script src="js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({ selector :'textarea', 
                            height: 350,
                            theme: 'modern',
                            plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak','searchreplace wordcount visualblocks visualchars code fullscreen','insertdatetime media nonbreaking save table contextmenu directionality','emoticons template paste textcolor colorpicker textpattern imagetools','codesample'],
                            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample',
                            toolbar2: 'print preview media | forecolor backcolor emoticons',
                            image_advtab: true
                        });
        </script> 
        <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <link href="js/tag/dist/tagify.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery.js"></script>
    </head>
    <body>
    <?php
        /*session_start();*/
        if (isset($_SESSION['id'])) 
        {
    ?>

        <div class="container-fluid">
            
            <section class="content">
                <br><br><br>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">

                            <!-- POST -->
                            <div class="post">
                                <form action="transact_portal.php?action=question" class="form newtopic" method="post">
                                    <div class="topwrap">
                                        <div class="userinfo pull-left"></div>
                                        <div class="posttext pull-left">

                                            <div>
                                                <p><b>Title</b></p>
                                                <input type="text" placeholder="Enter Question statement" class="form-control" name="title" />
                                            </div>
                                            <div id="editor">
                                                <p><b>Description</b></p>
                                                <textarea name="desc" id="desc" placeholder="Description"  class="form-control" rows="10" cols="50"></textarea>
                                            </div>

                                            <br>
                                            <div>
                                                <p><b>Tags</b></p>
                                                <input type="text" name="tags" id="skills" class="form-control">         
                                            </div>
                                            <hr>
                                            <br>
                                            <div id="editor">
                                                <p><b>Answer Statement</b></p>
                                                <textarea name="ans_desc" id="desc" placeholder="Description"  class="form-control" rows="10" cols="50"></textarea>
                                            </div> 

                                        </div>
                                        <div class="clearfix"></div>
                                    </div>                             
                                    <div class="postinfobot">

                                        <!-- <div class="notechbox pull-left">
                                            <input type="checkbox" name="note" id="note" class="form-control" />
                                        </div>

                                        <div class="pull-left">
                                            <label for="note"> Email me when some one post a reply</label>
                                        </div>
 -->
                                        <div class="pull-right postreply">
                                            <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
                                            <div class="pull-left"><button type="submit" class="btn btn-primary">Post</button></div>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div><!-- POST -->

                        </div>
                        <?php
                            include 'sidebar.php';
                        ?>
                    </div>
                </div>

                <br><br>
            </section>
            <?php
                include 'footer.php';
            ?>     
        </div>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="js/tag/dist/jQuery.tagify.js"></script>
        <script>
            $('[name=tags]').tagify();
        </script> 
         
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php 
}
    else
    {
        $msg = 'Please Login to continue';
        echo '<script type="text/javascript">location.href="05_login.php?msg='.$msg.'"; </script>';
    }
 ?>
        

    </body>
</html>