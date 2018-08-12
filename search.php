<?php
	date_default_timezone_set('Asia/Kolkata');
	include 'header.php';
	include 'db.php';
	include 'date.php';
?>

	<style type="text/css">
		.profile {
			width: 50px;
			margin-top: 10px;
		}

		.filter {
			margin-left: 500px;
			margin-bottom: -10px;
		}

		#search_button > button{
                margin-top: -32px;
                background-color: #808080;
            }

	</style>
<?php
	if (isset($_REQUEST['action'])) 
	{
		switch ($_REQUEST['action']) 
		{
			//Search By topics
			case 'topics':

				//Pagination
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

				$count = $conn->prepare('SELECT COUNT(*) AS rows FROM questions WHERE title LIKE "%'.$_REQUEST['search'].'%"');
				$count->execute();
				$count->setFetchMode(PDO::FETCH_ASSOC);
				$result = $count->fetch();
				$total_rows = $result['rows'];
				$total_pages = ceil($total_rows / $no_of_records_per_page);
				$query = 'SELECT u.picture, q.title, q.tags, q.ques_id, q.posted_on, q.views FROM questions q, users u WHERE u.user_id = q.user_id AND title LIKE "%'.$_REQUEST['search'].'%" ORDER BY q.posted_on DESC LIMIT '.$offset.', '.$no_of_records_per_page;

				$stmt=$conn->prepare($query);
				$stmt->execute();
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				?>
					<style type="text/css">
						.profile {
							width: 40px;
                			margin-top: 10px;
						}

					</style>
					<br><br><br>
					<!--Wraps whole data on the page-->
			        <div class="container">

			            <!--Displaying each question-->
			            <div class="row">

			                <div class="col-lg-8 col-md-8">

			                    <?php
			                        if ($stmt->rowCount() == 0) 
			                        {
			                            echo "<div><p style='font-size: 17px; color:black;'><b>No result found</b></p></div>";
			                        }
			                        else
			                        {	echo "<p>Search Results</p>";
			                            while ($row = $stmt->fetch()) 
			                            {
			                                //Fetching the time at which the question was posted
			                                $posted = strtotime($row['posted_on']);
			                                $date = fetch_date($posted);
			                                //Calculating the number of answers   
			                                $ans = $conn->prepare('SELECT * FROM answers WHERE ques_id = :qid');
			                                $ans->bindParam(':qid',$row['ques_id']);
			                                $ans->execute();

			                                //Converting string of tags to array
			                                $tags = explode('","', $row['tags']);
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
			                                                <img src="uploads/<?php if(isset($row['picture'])) {echo $row['picture'];} else { echo 'user.jpg';}  ?>" alt="" class="profile" />
			                                            </div>

			                                            <div class="icons">
			                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
			                                            </div>
			                                        </div>


			                                        <!--Main Text-->
			                                        <div class="posttext pull-left">
			                                            <h2><a href="02_topic.php?ques_id=<?php echo $row['ques_id']; ?>"><?php echo $row['title']; ?></a></h2>
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
			                                        <div class="views"><i class="fa fa-eye" title="views on post"></i> <?php echo $row['views']; ?></div>
			                                        <div class="time"><i class="fa fa-clock-o" title="posted on"></i> <?php echo $date;?></div>                                    
			                                    </div>
			                                    <div class="clearfix"></div>
			                                </div>
			                    <?php
			                            }
			                        }    
			                    ?><!-- POST -->

			                </div>
			                
			                <!--Including Sidebar-->
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

				<?php
				break;
			

			//Search By tag Name
			case 'tags':
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

			    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM tags WHERE tagname LIKE "%'.$_REQUEST['search'].'%"');
			    $count->execute();
			    $count->setFetchMode(PDO::FETCH_ASSOC);
			    $result = $count->fetch();
			    $total_rows = $result['rows'];
			    $total_pages = ceil($total_rows / $no_of_records_per_page);
			    $query = 'SELECT * FROM tags WHERE tagname LIKE "%'.$_REQUEST['search'].'%" LIMIT '.$offset.', '.$no_of_records_per_page;
			    $stmt=$conn->prepare($query);
			    $stmt->execute();
			    $stmt->setFetchMode(PDO::FETCH_ASSOC);
			    ?>
			    	<br><br>

		        <!--Wraps whole data on the page-->
		        <div class="container">
		        	<div class="row">
		        		 <div class="col-lg-8 col-md-8">

		   					<div class="filter">
                                <form action="search.php?action=tags" id="submit" method="post" class="form">
                                    <div class="pull-left txt">
                                        <input type="text" class="form-control" placeholder="Filter By tag Name" name="search" value="<?php if (isset($_REQUEST['search'])) { echo $_REQUEST['search'];}?>" >
                                        <div class="pull-right" id="search_button">
                                             <button class="btn btn-default" type="button"><i class="fa fa-search" onclick="$('#submit').submit();"></i></button>
                                        </div>
                                    </div>
                                        
                                    <div class="clearfix"></div>
                               	</form>
                            </div>
		                    <?php
		                        if ($stmt->rowCount() == 0) 
		                        {
		                            echo "<div><p>No resuts found.</p></div>";
		                        }
		                        else
		                        {	echo "<p>Search Results</p>";
		                        	$tags_used = 0;
		                            while ($row = $stmt->fetch()) 
		                            {

			                            $substr = substr($row['tag_desc'], 0, 170).'...';
		                    ?>			
		                    			<br>			

		                    			<div class="post">
		                                    <div class="wrap-ut pull-left">

		                                        <!--Left Side user info-->
		                                        <div class="userinfo pull-left">
		                                        	<div class="avatar">
				                                        <img src="tag-pic/<?php echo $row['tag_pic']; ?>" alt="" class="profile" />
				                                    </div>

		                                            <div class="icons">
		                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
		                                            </div>
		                                        </div>


		                                        <!--Main Text-->
		                                        <div class="posttext pull-left">
		                                            <h2><a href="tag_name.php?tag_name=<?php echo $row['tagname']; ?>"><span style="background-color: #c1cdc1; padding-left: 5px; padding-right: 5px;"><?php echo $row['tagname']; ?></span></a> x <?php echo $row['used']; ?></h2>
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
		                        }    
		                    ?>
			            </div>
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
			    <?php
				break;

			//Search By Username
			case 'name':
				
				//Displaying all users
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

			    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM users WHERE username LIKE "%'.$_REQUEST['search'].'%" OR firstname LIKE "%'.$_REQUEST['search'].'%" OR lastname LIKE "%'.$_REQUEST['search'].'%"');
			    $count->execute();
			    $count->setFetchMode(PDO::FETCH_ASSOC);
			    $result = $count->fetch();
			    $total_rows = $result['rows'];
			    $total_pages = ceil($total_rows / $no_of_records_per_page);
			    $query = 'SELECT * FROM users WHERE username LIKE "%'.$_REQUEST['search'].'%" OR firstname LIKE "%'.$_REQUEST['search'].'%" OR lastname LIKE "%'.$_REQUEST['search'].'%" LIMIT '.$offset.', '.$no_of_records_per_page;
			 	$stmt=$conn->prepare($query);
			 	$stmt->execute();
			 	$stmt->setFetchMode(PDO::FETCH_ASSOC);
			 	?>
			 		

		        <!--Wraps whole data on the page-->
		        <div class="container">
		        	<div class="row">
		        		 <div class="col-lg-8 col-md-8">
		                	<br><br>
		                	<div class="filter">
                                    <form action="search.php?action=name" id="submit" method="post" class="form">
                                        <div class="pull-left txt">
                                            <input type="text" class="form-control" placeholder="Filter By User Name" name="search" value="<?php if (isset($_REQUEST['search'])) { echo $_REQUEST['search'];}?>">
                                            <div class="pull-right" id="search_button">
                                                <button class="btn btn-default" type="button"><i class="fa fa-search" onclick="$('#submit').submit();"></i></button>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
		                    <?php
		                        if ($stmt->rowCount() == 0) 
		                        {
		                            echo "<div><p>No result found</p></div>";
		                        }
		                        else
		                        {	echo "<p>Search Results</p>";
		                            while ($row = $stmt->fetch()) 
		                            {
		                            
			                            $substr = substr($row['about_me'], 0, 150).'...';
		                    ?>

		                    			<div class="post">
		                                    <div>

		                                        <!--Left Side user info-->
		                                        <div class="userinfo pull-left">
		                                        	<div class="avatar">
				                                        <img src="uploads/<?php if(isset($row['picture'])) {echo $row['picture'];} else { echo 'user.jpg';} ?>" alt="" class="profile" />
				                                    </div>

		                                            <div class="icons">
		                                                <img src="images/icon1.jpg" alt="" /><img src="images/icon4.jpg" alt="" />
		                                            </div>
		                                        </div>


		                                        <!--Main Text-->
		                                        <div class="posttext pull-left">
		                                            <h2><a href="user_name.php?user_id=<?php echo $row['user_id']; ?>"><span style="background-color: #c1cdc1; padding-left: 5px; padding-right: 5px;"><?php echo $row['firstname'].' '.$row['lastname']; ?></span></a></h2>
		                                            <p><?php echo $row['por']; ?></p>
		                                        </div>


		                                        <!--Displaying Tags-->
		                    					<div>
				                                    <?php
				                                        echo '<div><p>'.$row['about_me'].'</p></div>';
				                                    ?>
				                              	</div>

		                                        <div class="clearfix"></div>
		                                    </div>

		                                    <div class="clearfix"></div>
		                                </div>
		                    <?php
		                            }
		                        }    
		                    ?>
			            </div>
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
			 	<?php
				break;	
		}
	}
?>