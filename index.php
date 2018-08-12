<?php
    include 'db.php';
//Setting the timezone
date_default_timezone_set('Asia/Kolkata');
include 'header.php'; //header file
include 'db.php';     //Database connectivity
include 'date.php';   //Fetching time on which it was posted  

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

$count = $conn->prepare('SELECT COUNT(*) AS rows FROM questions');
$count->execute();
$count->setFetchMode(PDO::FETCH_ASSOC);
$result = $count->fetch();
$total_rows = $result['rows'];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$query = 'SELECT u.picture, q.title, q.tags, q.ques_id, q.posted_on, q.views FROM questions q, users u WHERE u.user_id = q.user_id ORDER BY q.posted_on DESC LIMIT '.$offset.', '.$no_of_records_per_page;
$stmt=$conn->prepare($query);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

?>

<!--Main Page-->
<!DOCTYPE html>
<html lang="en">
    
    <head>  
        <title>Forum::Index</title>        
        <style type="text/css">
            .profile {
                border-radius: 50%;
                width: 40px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
                
        <br><br>

        <!--Wraps whole data on the page-->
        <div class="container">

            <!--Displaying each question-->
            <div class="row">

                <div class="col-lg-8 col-md-8">
                    <p style="font-size: 17px;"><b><u>Recent Posts</u></b></p>
                    <?php
                        if ($stmt->rowCount() == 0) 
                        {
                            echo "<div><p>No questions have been posted on the forum yet</p></div>";
                        }
                        else
                        {
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
        
    </body>

</html>