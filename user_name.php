<?php

	//header file 
	include 'header.php';

	include 'date.php';
	//Database Connectivity
 	include 'db.php';

 	//Fetching Data about the tag using tag-name	
	$stmt = $conn->prepare('SELECT * FROM users WHERE user_id=:id');
	$stmt->bindParam(':id',$_GET['user_id']);
 	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row=$stmt->fetch();

	//Fetching all questions
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

    $q = 'SELECT COUNT(*) AS rows FROM questions WHERE user_id='.$_GET['user_id'];
    $count = $conn->prepare($q);
    $count->execute();
    $count->setFetchMode(PDO::FETCH_ASSOC);
    $result = $count->fetch();
    $total_rows = $result['rows'];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    
    $query = 'SELECT u.picture, q.title, q.tags, q.ques_id, q.posted_on, q.views FROM questions q, users u WHERE u.user_id = q.user_id AND q.user_id ='.$_GET['user_id'].' ORDER BY q.posted_on ASC LIMIT '.$offset.', '.$no_of_records_per_page;
    $ques=$conn->prepare($query);
	$ques->execute();
	$ques->setFetchMode(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forum::Tag Info</title>

	<style type="text/css">
		#follow {
			margin-left: 550px;
			margin-top: -30px;
			font-size: 17px;
			width: 100px;
			padding-left: 5px;
			padding-right: 5px;
			padding-top: 0px;
			padding-bottom: 0px;
		}

		#follow:hover{
			cursor: pointer;
		}

		.checked {
			color: #6495ed;
		}

		.img{
			margin-top: 10px;
			margin-left: 0px;
		}

		.heading {
			margin-top: -130px;
			margin-left: 130px;
		}

		.profile {
			width: 40px;
			margin-top: 10px;
		}

	</style>

	<script type="text/javascript">
	   $(document).ready(function(){
            $('#follow').on('click', function(){

                //Checking Whether user is logged in or not
                <?php
                    if (!isset($_SESSION['id'])) 
                    {
                ?>
                        alert('Please Login First');
                <?php
                    }

                    else
                    {    
                ?>     
                        //Removing favourites  
                        if ($(this).hasClass('checked')) 
                        {
                            $(this).removeClass('checked')
                            var uid = <?php echo $row['user_id']; ?>;
                            $.ajax ({
                                    type: 'POST',
                                    url: 'transact_user.php?action=follow',
                                    data: {user_id: uid},
                                    success: function(data){
                                        console.log(data);
                                        }
                                });
                        }

                        //Adding Favourites
                        else
                        {
                            $(this).addClass('checked');
                            var uid = <?php echo $row['user_id']; ?>;
                            $.ajax ({
                                    type: 'POST',
                                    url: 'transact_user.php?action=unfollow',
                                    data: {user_id: uid},
                                    success: function(data){
                                        console.log(data);
                                    }
                            });
                        }    
                <?php
                    }            
                ?>    
            });
        });    
    </script>
</head>
<body>
	<div class="container">
	    <div class="row">
	        <div class="col-lg-8 col-md-8">
	        	<!-- <div class="userinfo pull-left">
	        		<div class="picture">
	        			<img src="uploads/<?php //echo $row['picture'];?>" style="width: 100px;">
	        		</div>	
	        	</div> -->
	        	<div class="posttext pull-left">
	        		<br>
	        		<div class="img">
	                	<img src="uploads/<?php if(isset($row['picture'])) {echo $row['picture'];} else { echo 'user.jpg';} ?>" style="width: 120px; border-radius: 20%;">
	                </div>
	                <div class="heading">	
	            		<h1 style="color: black;"><?php echo $row['firstname'].' '.$row['lastname'];?>

	            		<!-- User cannot follow itself -->
	            		<?php 
	            			if (isset($_SESSION['id'])) 
	            			{
	            				if ($_SESSION['id'] != $_GET['user_id']) 
	            				{
	            		?>					
	            					<span class="fa fa-user" id="follow"> Follow</span>
	            		<?php	
	            				}
	            			}	 
	            		?>	
	            		</h1>
	            		<p><?php echo $row['por']; ?></p>
	           			<p><?php echo $row['about_me']; ?></p>
	       			</div>
	            </div>

	   			<br><br><br><br><br><br><br><br>
                <h3 style="color: black;"><?php echo $result['rows']; ?> questions posted</h3>
                <hr>
                    <?php
                          	while ($res = $ques->fetch()) 
                            {
                            	//date posted
                            	$posted = strtotime($res['posted_on']);
                                $date = fetch_date($posted);

                            	//For Counting the number of answers on questions
                            	$ans = $conn->prepare('SELECT * FROM answers WHERE ques_id = :qid');
                            	$ans->bindParam(':qid',$res['ques_id']);
                            	$ans->execute();
                            	$ans->setFetchMode(PDO::FETCH_ASSOC);

                                //Converting string of tags to array
                                $tags = explode('","', $res['tags']);
                                $n = count($tags);
                                $tags[0] = substr($tags[0], 1);
                                $tags[$n-1] = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);  		
                               
                    ?>

                                <!-- POSTS -->
                                <div class="post">
                                    <div class="wrap-ut pull-left">

                                        <!--Left Side user info-->
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="uploads/<?php if(isset($res['picture'])) {echo $res['picture'];} else { echo 'user.jpg';} ?>" alt="" class="profile" />
                                            </div>

                                            <div class="icons">
                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
                                            </div>
                                        </div>


                                        <!--Main Text-->
                                        <div class="posttext pull-left">
                                            <h2><a href="02_topic.php?ques_id=<?php echo $res['ques_id']; ?>"><?php echo $res['title']; ?></a></h2>
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
                                        <div class="views"><i class="fa fa-eye" title="views on post"></i> <?php echo $res['views']; ?></div>
                                        <div class="time"><i class="fa fa-clock-o" title="posted on"></i> <?php echo $date;?></div>                                    
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                   		 <?php  
                   		 		
                       		 }    
                   		 ?><!-- POST -->

                </div>
                <br><br>
                <!-- Including Sidebar-->
                <?php 
                	include 'sidebar.php';
                ?>
            </div>
        </div>

        <!--Including footer-->
        <?php
        if ($result['rows'] > 10) 
        {
            include 'pagination.php';
        }   	
          
            include 'footer.php';
        ?>

</body>
</html>