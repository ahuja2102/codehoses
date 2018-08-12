<?php
 	include 'db.php';
 	include 'header.php';

 	//Displaying all tags
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

    $count = $conn->prepare('SELECT COUNT(*) AS rows FROM tags');
    $count->execute();
    $count->setFetchMode(PDO::FETCH_ASSOC);
    $result = $count->fetch();
    $total_rows = $result['rows'];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $query = 'SELECT * FROM tags LIMIT '.$offset.', '.$no_of_records_per_page;
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
            				<h1 style="color: black;">Tags
                                <div class="filter">
                                    <form action="search.php?action=tags" id="submit" method="post" class="form">
                                        <div class="pull-left txt">
                                            <input type="text" class="form-control" placeholder="Filter By tag Name" name="search">
                                            <div class="pull-right" id="search_button">
                                                <button class="btn btn-default" type="button"><i class="fa fa-search" onclick="$('#submit').submit();"></i></button>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </h1>
            				<p>A tag is a keyword or label that categorizes your question with other, similar questions and makes it easier for others to find and answer your question.</p>
            			</div>
                	</div>
                    <hr><hr><hr><hr>

                	<br><br><br>
                    <?php
                        if ($stmt->rowCount() == 0) 
                        {
                            echo "<div><p>No tags have been posted on the forum yet</p></div>";
                        }
                        else
                        {	$tags_used = 0;
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
		        
        
    </body>

</html>