<?php
	include 'header.php';

	//Setting Default Date
	date_default_timezone_set('Asia/Kolkata');
	include 'date.php';

	include 'db.php';	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forum:: Profile</title>
	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Custom -->
        <link href="css/custom.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->

        
        <style type="text/css">
        .image-upload > input
        {
            display: none;
        }
        </style>
        <!-- <script type="text/javascript">
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
            		$.ajax {

            		}
        		}
    		}

        </script> -->

    <style type="text/css">
    	#myprofile > div {
    		font-family: 'Times New Roman';
    		font-style: 'bold';
    		font-size: 18px;
    		color: 	#000000;
    	}
    	.profile {
    		border-radius: 50%;
    		width: 200px;
    	}
    	.new-image > input {
    		display: none;
    	}
    	.text-block {
    		position: relative;
    		bottom: -50px; 
		    right: 194px;
		    background-color: black;
		    color: white;
		    padding-left: 10px;
		    padding-right: 10px;
		    width: 180px;
		    height: 5%; 
		    opacity: 0.5;
		    border-bottom-left-radius: 1750px;
		    border-bottom-right-radius: 1750px;
		    
		}
		.text-block:hover {
			opacity: 0.8;
			cursor: pointer;
		}

		#tabs {
			background-color: #FFFFFF;
		}

		#tabs > button {
			border: none;
			font-size: 20px;
			background-color: white;
		}
		.incomplete {
			
		}
		#tabs button.active {
    		background-color: #ccc;
    		border-top: solid 2px;
		}
		.tabcontent {
		    display: none;
		    padding: 6px 12px;
		    /*border: 1px solid #ccc;*/
		    border-top: none;
		}

		#tabs >button:hover{
			 background-color: #ddd;
		}
		.active {
			display: block;
		}

    </style> 
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
                var file = input.files[0];
    			var form_data = new FormData();
    			form_data.append('file', file);	
                $.ajax({
						url: "transact_user.php?action=change_pic", // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: form_data, 
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success: function(data)   // A function to be called if request succeeds
								{
								console.log(data);
							}
				});
            }
        }
        function tabs(evt, activity) 
        {
     
		    var i, tabcontent, tablinks;
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace("active", "");
		    }
		    document.getElementById(activity).style.display = "block";
		    evt.currentTarget.className += "active";
        }
       </script>   
</head>
<body>
	<br><br>

	<div class="container-fluid">
		<div class="container">
			<div align="center">
				<img src="uploads/<?php if(isset($_SESSION['pic'])) {echo $_SESSION['pic'];} else { echo 'user.jpg';} ?>" class="profile" id="blah">
				<label for="file-input">
					<div class="text-block"><p align="center">Change Picture</p></div>
				</label>	
				<div class='new-image'><input id="file-input" class="pic" type="file" accept="image" onchange="readURL(this)" name="profilepic"/></div>
			</div>
			<br>
			<div class="userinfo pull-left">
				<div id="tabs">
					<button class="tablinks" onclick="tabs(event ,'myprofile')"> My Profile</button> |
					<button class="tablinks" onclick="tabs(event ,'questions')"> Questions</button> |
					<button class="tablinks" onclick="tabs(event ,'answers')"> answers</button> |
					<button class="tablinks" onclick="tabs(event ,'liked')"> Liked Tags</button> |
					<button class="tablinks" onclick="tabs(event ,'favourites')"> Favourites </button>
				</div>
				<hr>
	
				<!-- My Profile -->
				<div id="myprofile" class="tabcontent" style="display: block;">
					<?php
						$stmt = $conn->prepare('SELECT * FROM users WHERE user_id=:id');
						$stmt->bindParam(':id',$_SESSION['id']);
						$stmt->execute();
						$stmt->setFetchMode(PDO::FETCH_ASSOC);
						$row = $stmt->fetch();
						if (empty($row['about_me']) || empty($row['por']) || empty($row['Dob'])) 
						{
					?>
					<div class="incomplete" style="color: #FF0000;">
						Your Profile is incomplete! <a href="edit.php">Click here</a> to complete your profile.</a>
					<!-- <p align="right" style="right: 50px;"><a href="edit.php">Edit your profile</a></p> -->
					</div>
					<?php } ?>
					<br>
					<div><b>Name</b>: <?php echo $row['firstname']." ".$row['lastname'] ; ?></div>
					<br>
					<div><b>Username</b>: <?php echo $row['username']; ?></div>
					<br>
					<div><b>Email</b>: <?php echo $row['email_id']; ?></div>
					<br>
					<?php

						if ($row['Dob'] != NULL) 
						{
							echo "<div><b>Date Of Birth</b>: ".$row['Dob']." </div>";
							echo '<br>';
						}
						if ($row['por'] != NULL) 
						{
							echo '<div><b>Title</b>: '.$row['por'].'</div>';
							echo '<br>';
						}

						if ($row['about_me'] != NULL) 
						{
							echo "<div><b>About me</b>: ".$row['about_me']." </div>";
							echo "<br>";
						}
					?>
					<p style="color: #0000FF;"><a href="edit.php?action=edit_user" style="color: #0000FF;">Edit your profile</a></p>
				</div>

				<!-- Questions-->
				<div id="questions" class="tabcontent">
					<?php

						if (isset($_GET['pageno'])) 
					 	{
					      	$pageno = $_GET['pageno'];
					    } 
					    else 
					    {
					        $pageno = 1;
					    }
					    $no_of_records_per_page = 10;
					    $offset = ($pageno-1) * $no_of_records_per_page;

					    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM questions WHERE user_id = :id');
					    $count->bindParam(':id', $_SESSION['id']);
					    $count->execute();
					    $count->setFetchMode(PDO::FETCH_ASSOC);
					    $result = $count->fetch();

					    //Fetching total number of rows
					    $total_rows = $result['rows'];
					    $total_pages = ceil($total_rows / $no_of_records_per_page);

					    //fetching all questions posted by the user
					    $q = 'SELECT u.picture, q.title, q.description, q.tags, q.posted_on, q.views FROM users u, questions q WHERE u.user_id = q.user_id AND q.user_id = '.$_SESSION['id'].' ORDER BY posted_on ASC LIMIT '.$offset.', '.$no_of_records_per_page;
					 	$query=$conn->prepare($q);
					 	$query->execute();
					 	$query->setFetchMode(PDO::FETCH_ASSOC);


						echo "<h4 style='color: black;'>".$result['rows']." Question(s)</h4>";
						echo '<hr>';

						if ($query->rowCount() == 0) 
						{
						 	echo "You haven't asked any questions yet";
						} 						
						else
						{
							while ($r = $query->fetch()) 
							{  
								$posted = strtotime($r['posted_on']);
                                $date = fetch_date($posted);

                            	//For Counting the number of answers on questions
                            	$ans = $conn->prepare('SELECT * FROM answers WHERE ques_id = :qid');
                            	$ans->bindParam(':qid',$r['ques_id']);
                            	$ans->execute();
                            	$ans->setFetchMode(PDO::FETCH_ASSOC);

								$tags = explode('","', $r['tags']);
    							$n = count($tags);
    							$tags[0] = substr($tags[0], 1);
    							$tags[$n-1] = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);
					?>
								<div class="post">
                                    <div class="wrap-ut pull-left">

                                        <!--Left Side user info-->
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="uploads/<?php if(isset($r['picture'])) {echo $r['picture'];} else { echo 'user.jpg';} ?>" alt="" class="profile" style="width: 30px;" />
                                            </div>

                                            <div class="icons">
                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
                                            </div>
                                        </div>


                                        <!--Main Text-->
                                        <div class="posttext pull-left">
                                            <h2><a href="02_topic.php?ques_id=<?php echo $r['ques_id']; ?>"><?php echo $r['title']; ?></a></h2>
                                        </div>


                                        <!--Displaying Tags-->
                                        <div>
                                            <?php
                                                for ($i=0; $i < $n ; $i++) 
                                                {                                
                                                    echo '<a href="tag_name.php?tag_name='.$tags[$i].'"><button>'.$tags[$i].'</button></a>&ensp;';
                                                }
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <!--Info about questions-->
                                    <div class="postinfo pull-left">
                                        <div class="comments">
                                            <div class="commentbg" title="Number of Answers on question">
                                                <?php echo $ans->rowCount(); ?>
                                                <div class="mark"></div>
                                            </div>
                                        </div>
                                        <div class="views"><i class="fa fa-eye" title="views on post"></i> <?php echo $r['views']; ?></div>
                                    	<div class="time"><i class="fa fa-clock-o" title="posted on"></i> <?php echo $date;?></div>                                    
                                	</div>
                                	<div class="clearfix"></div>
                            	</div>
					<?php
							}
							if ($result['rows'] > 10) 
				        	{
				        		include 'pagination.php';
				        	}
								
						}		
					?>
				</div>

				<!-- answers-->
				<div id="answers" class="tabcontent">

					<?php
						if (isset($_GET['pageno'])) 
					 	{
					      	$pageno = $_GET['pageno'];
					    } 
					    else 
					    {
					        $pageno = 1;
					    }
					    $no_of_records_per_page = 10;
					    $offset = ($pageno-1) * $no_of_records_per_page;

					    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM answers WHERE user_id = :id');
					    $count->bindParam(':id', $_SESSION['id']);
					    $count->execute();
					    $count->setFetchMode(PDO::FETCH_ASSOC);
					    $result = $count->fetch();

					    //Fetching total number of rows
					    $total_rows = $result['rows'];
					    $total_pages = ceil($total_rows / $no_of_records_per_page);

					    //fetching all questions posted by the user
					    $q = 'SELECT u.picture, a.user_id, a.ques_id AS ques_id, q.title, q.views, q.posted_on, q.tags AS tags FROM answers a, questions q, users u WHERE a.user_id = '.$_SESSION['id'].' AND a.ques_id = q.ques_id AND u.user_id=a.user_id ORDER BY a.posted_on ASC LIMIT '.$offset.', '.$no_of_records_per_page;

						$sql = $conn->prepare($q);
						$sql->execute();
						$sql->setFetchMode(PDO::FETCH_ASSOC);
						echo "<h4 style='color: black;'>".$result['rows']." Answer(s)</h4>";
						echo '<hr>';
						if ($sql->rowCount() == 0) 
						{
							echo "You haven't answered any questions yet";
						}
						else
						{
							while ($rest = $sql->fetch())
							{

								//Fetching Date
								$posted = strtotime($rest['posted_on']);
                                $date = fetch_date($posted);


                            	//For Counting the number of answers on questions
                            	$ans = $conn->prepare('SELECT * FROM answers WHERE ques_id = :qid');
                            	$ans->bindParam(':qid',$rest['ques_id']);
                            	$ans->execute();
                            	$ans->setFetchMode(PDO::FETCH_ASSOC);


								// Tags
								$tags = explode('","', $rest['tags']);
    							$n = count($tags);
    							$tags[0] = substr($tags[0], 1);
    							$tags[$n-1] = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);
					?>		

								<div class="post">
                                    <div class="wrap-ut pull-left">

                                        <!--Left Side user info-->
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="uploads/<?php if(isset($rest['picture'])) {echo $rest['picture'];} else { echo 'user.jpg';} ?>" alt="" class="profile" style="width: 30px;" />
                                            </div>

                                            <div class="icons">
                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
                                            </div>
                                        </div>


                                        <!--Main Text-->
                                        <div class="posttext pull-left">
                                            <h2><a href="02_topic.php?ques_id=<?php echo $rest['ques_id']; ?>"><?php echo $rest['title']; ?></a></h2>
                                        </div>


                                        <!--Displaying Tags-->
                                        <div>
                                            <?php
                                                for ($i=0; $i < $n ; $i++) 
                                                {                                
                                                    echo '<a href="tag_name.php?tag_name='.$tags[$i].'"><button>'.$tags[$i].'</button></a>&ensp;';
                                                }
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <!--Info about questions-->
                                    <div class="postinfo pull-left">
                                        <div class="comments">
                                            <div class="commentbg" title="Number of Answers on question">
                                                <?php echo $ans->rowCount(); ?>
                                                <div class="mark"></div>
                                            </div>
                                        </div>
                                        <div class="views"><i class="fa fa-eye" title="views on post"></i> <?php echo $rest['views']; ?></div>
                                    	<div class="time"><i class="fa fa-clock-o" title="posted on"></i> <?php echo $date;?></div>                                    
                                	</div>
                                	<div class="clearfix"></div>
                            	</div>
                    <?php        
							}

							if ($result['rows'] > 10) 
				        	{
				        		include 'pagination.php';
				        	} 
						}
					?>
				</div>



				<!-- Liked Tags -->
				<div id="liked" class="tabcontent">
					<?php

						if (isset($_GET['pageno'])) 
					 	{
					      	$pageno = $_GET['pageno'];
					    } 
					    else 
					    {
					        $pageno = 1;
					    }
					    $no_of_records_per_page = 10;
					    $offset = ($pageno-1) * $no_of_records_per_page;

					    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM like_tag WHERE user_id = :id');
					    $count->bindParam(':id', $_SESSION['id']);
					    $count->execute();
					    $count->setFetchMode(PDO::FETCH_ASSOC);
					    $result = $count->fetch();

					    //Fetching total number of rows
					    $total_rows = $result['rows'];
					    $total_pages = ceil($total_rows / $no_of_records_per_page);

					    //fetching all questions posted by the user
					    $q = 'SELECT t.tagname, t.tag_desc, t.tag_pic, t.used FROM tags t, like_tag l WHERE t.tag_id = l.tag_id AND l.user_id = '.$_SESSION['id'].' LIMIT '.$offset.', '.$no_of_records_per_page;

						$tag = $conn->prepare($q);
						$tag->execute();
						$tag->setFetchMode(PDO::FETCH_ASSOC);

						echo "<h4 style='color: black;'>".$result['rows']." Liked Tag(s)</h4>";
						echo '<hr>';
						if ($tag->rowCount() == 0) 
						{
							echo "<p>You haven't liked any tags yet</p>";
						}
						else
						{
							while ($res = $tag->fetch()) 
							{
								 $substr = substr($res['tag_desc'], 0, 170).'...';
					?>
								<br>			

                    			<div class="post">
                                    <div class="wrap-ut pull-left">

                                        <!--Left Side user info-->
                                        <div class="userinfo pull-left">
                                        	<div class="avatar">
		                                        <img src="tag-pic/<?php echo $res['tag_pic']; ?>" alt="" class="profile" style="width: 60px;" />
		                                    </div>

                                            <div class="icons">
                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
                                            </div>
                                        </div>


                                        <!--Main Text-->
                                        <div class="posttext pull-left">
                                            <h2><a href="tag_name.php?tag_name=<?php echo $res['tagname']; ?>"><span style="background-color: #c1cdc1; padding-left: 5px; padding-right: 5px;"><?php echo $res['tagname']; ?></span></a> x <?php echo $res['used']; ?></h2>
                                        </div>


                                        <!--Displaying Tags-->
                    					<div>
		                                    <?php
		                                        echo '<div><p>'.$substr.'</p></div>';
		                                    ?>
		                              	</div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <!--Info about questions-->
                                    <div class="clearfix"></div>
                                </div>				
					<?php			 
							}

							if ($result['rows'] > 10) 
				        	{
				        		include 'pagination.php';
				        	}	
						}
					?>
				</div>



				<!--Show Favourite questions-->
				<div id="favourites" class="tabcontent">
					<?php

						if (isset($_GET['pageno'])) 
					 	{
					      	$pageno = $_GET['pageno'];
					    } 
					    else 
					    {
					        $pageno = 1;
					    }
					    $no_of_records_per_page = 10;
					    $offset = ($pageno-1) * $no_of_records_per_page;

					    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM favourites WHERE user_id = :id');
					    $count->bindParam(':id', $_SESSION['id']);
					    $count->execute();
					    $count->setFetchMode(PDO::FETCH_ASSOC);
					    $result = $count->fetch();

					    //Fetching total number of rows
					    $total_rows = $result['rows'];
					    $total_pages = ceil($total_rows / $no_of_records_per_page);

					    //fetching all questions posted by the user
					    $q = 'SELECT u.picture, q.ques_id AS ques_id, q.title AS title, q.tags AS tags, q.views, q.posted_on FROM questions q, favourites f, users u WHERE u.user_id = f.user_id AND q.ques_id = f.ques_id AND f.user_id = '.$_SESSION['id'].' LIMIT '.$offset.', '.$no_of_records_per_page;

						$fav=$conn->prepare($q);
						$fav->execute();
						$fav->setFetchMode(PDO::FETCH_ASSOC);

						echo "<h4 style='color: black;'>".$result['rows']." Favourite(s)</h4>";
						echo '<hr>';
						if ($fav->rowCount() == 0) 
						{
							echo "You don't have any favourite questions yet";
						}
						else
						{
							while ($result = $fav->fetch())
							{

								//Fetching Date
								$posted = strtotime($result['posted_on']);
                                $date = fetch_date($posted);


                            	//For Counting the number of answers on questions
                            	$ans = $conn->prepare('SELECT * FROM answers WHERE ques_id = :qid');
                            	$ans->bindParam(':qid',$result['ques_id']);
                            	$ans->execute();
                            	$ans->setFetchMode(PDO::FETCH_ASSOC);

								$tags = explode('","', $result['tags']);
	    						$n = count($tags);
	    						$tags[0] = substr($tags[0], 1);
	    						$tags[$n-1] = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);	
					?>	
								
								<div class="post">
                                    <div class="wrap-ut pull-left">

                                        <!--Left Side user info-->
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="uploads/<?php if(isset($result['picture'])) {echo $result['picture'];} else { echo 'user.jpg';} ?>" alt="" class="profile" style="width: 30px;" />
                                            </div>

                                            <div class="icons">
                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
                                            </div>
                                        </div>


                                        <!--Main Text-->
                                        <div class="posttext pull-left">
                                            <h2><a href="02_topic.php?ques_id=<?php echo $result['ques_id']; ?>"><?php echo $result['title']; ?></a></h2>
                                        </div>


                                        <!--Displaying Tags-->
                                        <div>
                                            <?php
                                                for ($i=0; $i < $n ; $i++) 
                                                {                                
                                                    echo '<a href="tag_name.php?tag_name='.$tags[$i].'"><button>'.$tags[$i].'</button></a>&ensp;';
                                                }
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <!--Info about questions-->
                                    <div class="postinfo pull-left">
                                        <div class="comments">
                                            <div class="commentbg" title="Number of Answers on question">
                                                <?php echo $ans->rowCount(); ?>
                                                <div class="mark"></div>
                                            </div>
                                        </div>
                                        <div class="views"><i class="fa fa-eye" title="views on post"></i> <?php echo $result['views']; ?></div>
                                    	<div class="time"><i class="fa fa-clock-o" title="posted on"></i> <?php echo $date;?></div>                                    
                                	</div>
                                	<div class="clearfix"></div>
                            	</div>
                    <?php        
                    		}
                    		echo '<br><br>';

                    		if ($result['rows'] > 10) 
				        	{
				        		include 'pagination.php';
				        	}		
                    	}	
                    ?>   	
				</div>

			</div>
		</div>
		<?php
			include 'footer.php';
		?>

	</div>
</body>
</html>