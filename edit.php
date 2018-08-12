<?php
	include 'header.php';
	include 'db.php';

	//User Info
	$stmt = $conn->prepare('SELECT * FROM users WHERE user_id=:id');
	$stmt->bindParam(':id',$_SESSION['id']);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();

	//Questions Info
	$ques = $conn->prepare('SELECT * FROM questions WHERE ques_id = :ques AND user_id = :id');
	$ques->bindParam(':ques',$_GET['ques_id']);	
	$ques->bindParam(':id',$_SESSION['id']);
	$ques->execute();
	$ques->setFetchMode(PDO::FETCH_ASSOC);
	$res = $ques->fetch();

	//Answer Info
	$ans = $conn->prepare('SELECT * FROM answers WHERE ans_id = :ans AND user_id = :id');
	$ans->bindParam(':ans',$_GET['ans_id']);
	$ans->bindParam(':id',$_SESSION['id']);
	$ans->execute();
	$ans->setFetchMode(PDO::FETCH_ASSOC);
	$r = $ans->fetch();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forum:: Edit Profile</title>
	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>


        <!--Tinymce text Editor-->
        <script src="js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({ selector :'textarea', 
                            height: 350,
                            theme: 'modern',
                            plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak','searchreplace wordcount visualblocks visualchars code fullscreen','insertdatetime media nonbreaking save table contextmenu directionality','emoticons template paste textcolor colorpicker textpattern imagetools','codesample'],
                            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample',
                            toolbar2: 'print preview | forecolor backcolor emoticons',
                            image_advtab: true
                        });
        </script>

        <!--Including jquery plugins-->
        <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <link href="js/tag/dist/tagify.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery.js"></script> 
        
        <!--Styling Date of Birth-->
        <style type="text/css">
        	.dob >input {
        		width: 200px;
        	}
        </style>



</head>
<body>

	<br><br>

	<?php
		if (isset($_REQUEST['action'])) 
		{
			switch ($_REQUEST['action']) 
			{
				//User Edit
				case 'edit_user':
			
	?>
		<div class="container-fluid">
			<div class="container">
				<div class="post">
					<form action="transact_user.php" class="form newtopic" method="post" enctype="multipart/form-data">
                        <div class="postinfotop">
                            <p style="font-size: 20px; padding: 30px; padding-left: 170px;">Edit Your Profile</p>
                        </div>
                        <hr>

                        <div class="topwrap">
                        	<div class="userinfo pull-left"></div>
	                        <div class="posttext pull-left">
	                        	<div class="row">
	                                <div class="col-lg-6 col-md-6">
	                                	<p>First Name</p>
	                                    <input type="text" placeholder="First Name" class="form-control" name="first" value="<?php echo $row['firstname']; ?>" required/>
	                                </div>
	                                <div class="col-lg-6 col-md-6">
	                                	<p>Last Name</p>
	                                    <input type="text" placeholder="Last Name" class="form-control" name="last" value="<?php echo $row['lastname']; ?>" required/>
	                                </div>
	                 	        </div>
	                 	        <div>
	                 	        	<p>Email</p>
	                 	        	<input type="text" placeholder="Email" class="form-control" name="email" value="<?php echo $row['email_id']; ?>" required/>
	                 	        </div>
	                 	        <div class="dob">
	                 	        	<p>Date of Birth</p>
	                 	        	<input type="date" class="form-control" name="dob" value="<?php echo $row['Dob']; ?>" />
	                 	        	
	                 	    	</div>
	                 	    	<br>
	                 	    	<?php
	                 	    	$por = explode(" ", $row['por']);
	                 	    	$n = count($por);
	                 	    	?>
	                 	    	<div>
	                 	    	<p>Company Name</p>
	                 	    	<input type="text" placeholder="Company Pvt. Ltd." class="form-control" name="c_name" value="<?php for($i=2; $i<$n; $i++) { echo $por[$i].' '; } ; ?>" />
	                 	    	</div>
	                 	    	<div>
	                 	    	<p>Position of responsibility</p>
								<input type="text" placeholder="Postion" class="form-control" name="por" value="<?php echo $por[0]; ?>">
	                 	    	</div>
	                 	    	<div>
	                 	    		<p>About Me</p>
	                 	    		<textarea name="about_me" id="desc" placeholder="Description"  class="form-control" rows="10" cols="50"><?php echo $row['about_me']; ?></textarea>
	                 			</div>
	                    	</div>
	                    	<div class="clearfix"></div>
                   		</div>
                   		<div class="postinfobot">
                        	<div class="pull-right postreply">
	                         	<div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
	                            <div class="pull-left"><button type="submit" class="btn btn-primary" name="action" value="Update">Update</button></div>
	                            <div class="clearfix"></div>
                        	</div>
                        	<div class="clearfix"></div>
                    	</div>
                	</form>    
				</div>
			</div>
			<?php 
				include 'footer.php';
			?>
		</div>	

	<?php
				break;

			case 'edit_ques':
			//Tags separating
			$tag = '';
			$tags = explode('","', $res['tags']);
 			$n = count($tags);
 			$fstr = substr($tags[0], 1);
 			$lstr = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);
 			$tag .= $fstr.',';
 			for ($i=1; $i < $n-1 ; $i++) 
 			{ 
 				$tag .=$tags[$i].',';
 			}
 			$tag .= $lstr.','; 

	?>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				/*var data = <?php //echo $res['description']?>;*/
        		/*$('#desc').html(<?php //echo $res['description']; ?>);*/
        		
        	});
        </script>
		<div class="container-fluid">
            
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 breadcrumbf">
                            <a href="#">Borderlands 2</a> <span class="diviver">&gt;</span> <a href="#">General Discussion</a> <span class="diviver">&gt;</span> <a href="#">New Topic</a>
                        </div>
                    </div>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">

                            <!-- POST -->
                            <div class="post">
                                <form action="transact_portal.php?action=Update_ques" class="form newtopic" method="post">
                                    <div class="topwrap">
                                        <div class="userinfo pull-left"></div>
                                        <div class="posttext pull-left">

                                        	<!--Question Title-->
                                            <div>
                                                <input type="text" placeholder="Enter Question Title" class="form-control" name="title" value="<?php echo $res['title'];?>" />
                                            </div>

                                            <!--Question Descrition-->
                                            <div id="editor">
                                                <textarea name="desc" id="desc" placeholder="Description"  class="form-control" rows="10" cols="50"><?php echo htmlspecialchars($res['description']); ?></textarea>
                                            </div>
                                            <input type="hidden" name="ques_id" value="<?php echo $res['ques_id']; ?>">
                                            <br>
                                            <div>
                                                <p>Tags </p>
                                                    <input type="text" name="tags" id="skills" class="form-control" value="<?php echo rtrim($tag, ','); ?>">         
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
                                            <div class="pull-left"><button type="submit" class="btn btn-primary">Edit</button></div>
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

	<?php				
				break;

			//Editing Answer		
			case 'edit_ans':
	?>
		 <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">

                    <!-- POST -->
                    <div class="post">	
						<h3 style="color: black;">Your Answer</h3>
	                    <form action="transact_portal.php?ans_id=<?php echo $_GET['ans_id']; ?>" method="post">
	                        <div>
	                            <textarea name="desc" id="desc" placeholder="Description"  class="form-control" rows="10" cols="50"><?php echo htmlspecialchars($r['answer']); ?></textarea>
	                        </div>
	                        <input type="hidden" name="ques_id" value="<?php echo $r['ques_id'];?>">
		                    <br>
	                        <div class="postinfobot">
	                        	<div class="pull-right postreply">
	                                <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
	                                <div class="pull-left"><button type="submit" class="btn btn-primary" name="action" value="Update_ans">Update Your Answer</button></div>
	                                <div class="clearfix"></div>
	                            </div>

	                            <div class="clearfix"></div>
	                        </div>
	                    </form> 
	                </div>
	            </div>
                <?php
                    include 'sidebar.php';
                ?>
            </div> 
        <?php
            include 'footer.php';
        ?>     
    </div>             
                    
	<?php				
				break;	
			}
		}					
	?>	

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
	
</body>
</html>