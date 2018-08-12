<?php
 	include 'db.php';
 	include 'header.php';

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

    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM users');
    $count->execute();
    $count->setFetchMode(PDO::FETCH_ASSOC);
    $result = $count->fetch();
    $total_rows = $result['rows'];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $query = 'SELECT * FROM users LIMIT '.$offset.', '.$no_of_records_per_page;
 	$stmt=$conn->prepare($query);
 	$stmt->execute();
 	$stmt->setFetchMode(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <title>Forum::Index</title>        
        <style type="text/css">
            .profile {
            	margin-top: 13px;
                border-radius: 50%;
                width: 50px;
            }
            .filter{
                margin-left: 530px;
                margin-top: -40px;
            }
            #search_button > button{
                margin-top: -32px;
                background-color: #808080;
            }

        </style>
    </head>
    <body>
                
        <br><br>

        <!--Wraps whole data on the page-->
        <div class="container">
        	<div class="row">
        		 <div class="col-lg-8 col-md-8">
        		 	<div class="posttext pull-left">
                		<div class="heading">
            				<h1 style="color: black;">Users
            					<div class="filter">
                                    <form action="search.php?action=name" id="submit" method="post" class="form">
                                        <div class="pull-left txt">
                                            <input type="text" class="form-control" placeholder="Filter By User Name" name="search">
                                            <div class="pull-right" id="search_button">
                                                <button class="btn btn-default" type="button"><i class="fa fa-search" onclick="$('#submit').submit();"></i></button>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
            				</h1><br>
            			</div>
                	</div>

                	<br><br><br>
                    <?php
                        if ($stmt->rowCount() == 0) 
                        {
                            echo "<div><p>No users have been registered yet</p></div>";
                        }
                        else
                        {	
                            while ($row = $stmt->fetch()) 
                            {
                            
	                            $substr = substr($row['about_me'], 0, 150).'...';
                    ?>			
                    			<br>			

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
		        
        
    </body>

</html>