<?php 
 date_default_timezone_set('Asia/Kolkata');
 include 'header.php';
 include 'db.php';
 include 'date.php';
 include 'get_ip.php';

 //Increasing Views on basis of ip
 $ip = get_client_ip();
 $ip_address=$conn->prepare('SELECT * FROM ip_address WHERE ip_address= :ip AND ques_id = :qid');
 $ip_address->bindParam(':qid',$_GET['ques_id']);
 $ip_address->bindParam(':ip',$ip);
 $ip_address->execute();
 $ip_address->setFetchMode(PDO::FETCH_ASSOC);
 
 if ($ip_address->rowCount() == 0) 
 {
     $view=$conn->prepare('UPDATE questions SET views = views+1 WHERE ques_id=:id');
     $view->bindParam(':id',$_GET['ques_id']);
     $view->execute();

     $add_ip=$conn->prepare('INSERT INTO ip_address(user_id, ques_id, ip_address) VALUES(:uid, :qid,:ip)');
     $add_ip->bindParam(':uid',$_SESSION['id']);
     $add_ip->bindParam(':qid',$_GET['ques_id']);
     $add_ip->bindParam(':ip',$ip);
     $add_ip->execute();
 }


 //Fetching Questions
 $stmt = $conn->prepare('SELECT q.user_id, q.title, q.description, q.tags, q.posted_on, q.ques_id, u.firstname, u.lastname FROM questions q, users u WHERE q.ques_id = :id AND u.user_id = q.user_id');
 $stmt->bindParam(':id',$_GET['ques_id']);
 $stmt->execute();
 $stmt->setFetchMode(PDO::FETCH_ASSOC);
 $row = $stmt->fetch();
 $tags = explode('","', $row['tags']);
 $n = count($tags);
 $tags[0] = substr($tags[0], 1);
 $tags[$n-1] = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);



 //Fetching Answers
 $query = $conn->prepare('SELECT * FROM answers WHERE ques_id = :id');
 $query->bindParam(':id',$_GET['ques_id']);
 $query->execute();
 $query->setFetchMode(PDO::FETCH_ASSOC);



 //Fetching comments on questions
 $sql = $conn->prepare('SELECT comment, firstname, lastname FROM comment_question, users WHERE ques_id = :id AND comment_question.user_id = users.user_id');
 $sql->bindParam(':id',$_GET['ques_id']);
 $sql->execute();
 $sql->setFetchMode(PDO::FETCH_ASSOC);


 //Showing the topic as favourite
 $fav = $conn->prepare('SELECT * FROM favourites WHERE ques_id = :qid AND user_id = :uid');
 $fav->bindParam(':qid',$_GET['ques_id']);
 $fav->bindParam(':uid',$_SESSION['id']);
 $fav->execute();
 if ($fav->rowCount() != 0) 
 {
?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#star').addClass('checked');  //Marking Question As Favourite
        });
    </script>
<?php
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>
         
    <!-- Text Editor -->
    <script src="js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({ selector :'textarea', 
                        height: 350,
                        theme: 'modern',
                        plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak','searchreplace wordcount visualblocks visualchars code fullscreen','insertdatetime media nonbreaking save table contextmenu directionality','emoticons template paste textcolor colorpicker textpattern imagetools','codesample'],
                        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample',
                        toolbar2: 'print preview media | forecolor backcolor emoticons',
                        image_advtab: true,
                        contenteditable: false
                    });
    </script> 

   


    <!-- Comment Box -->
    <style type="text/css">
        .acomment > input[type = "text"]{
            border: 0px;
            border-bottom-width: 2px;
        }
        .acomment > input[type = "submit"]{
            display: none;
        }

        .comment {
            margin-left: 0px;
            border: solid 1px; 
            background-color: #FFDAB9;
        }

        .comment > p {
            margin-left: 5px;
            color: black;
        }

        .comment > p > strong {
            color:  #008080;
        }

        .checked {
            color: #FFD700;
        }
        span {
            font-size: 200%; 
            margin-top: 170px;
            margin-left: 20px;
        }
        span:hover {
            cursor: pointer;
        }
        .ans {
            border-bottom: solid 1px;
        }

        .topwrap > h1 > a{
            margin-left: 550px;
            font-size: 15px;
            color: blue;
        }

        .post_date {
            margin-left: 500px;
            background-color: #afeeee;
            color: #2F4F4F;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('#star').on('click', function(){

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
                            var qid = <?php echo $_GET['ques_id']; ?>;
                            $.ajax ({
                                    type: 'POST',
                                    url: 'transact_portal.php?action=favdel',
                                    data: {ques_id: qid},
                                    success: function(data){
                                        console.log(data);
                                        }
                                });
                        }

                        //Adding Favourites
                        else
                        {
                            $(this).addClass('checked');
                            var qid = <?php echo $_GET['ques_id']; ?>;
                            $.ajax ({
                                    type: 'POST',
                                    url: 'transact_portal.php?action=favins',
                                    data: {ques_id: qid},
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
    <style type="text/css">
        #home {
            margin-bottom: 5px;
            padding-left: 250px;
            font-size: 30px;
        } 

        #tags {
            padding-left: 265px;
            font-size: 20px;  
        }

        #user {
            padding-left: 260px;
            font-size: 20px;
        }
    </style>
</head>


<body class="topic">

    <!--Main Block-->
    <div class="container-fluid">

        <section class="content">
            <div class="container" style="margin-bottom: 10px;">
                <div class="row">
                    <div class="col-lg-8 col-md-8" style="margin-bottom: 50px;">

                        <!-- POST -->
                        <br><br>
                        <div class="post beforepagination">
                            <div class="topwrap">
                                <div class="userinfo pull-left">
                                    <div class="fav">
                                        <span class="fa fa-star" id="star" title="Mark as favourite">
                                        </span>
                                    </div>    
                                </div>
                                <div class="posttext pull-left">

                                    <!--Displaying questions -->
                                    <div class="topwrap">
                                        <h1 style="color: black;"><?php echo $row['title'];?>
                                            <?php
                                                if ($_SESSION['id'] == $row['user_id']) 
                                                {
                                                    echo "<a href='edit.php?action=edit_ques&ques_id=".$_GET['ques_id']."'>Edit question</a>";
                                                }
                                            ?>
                                        </h1>
                                    </div>
                                    <hr>
                                    <div><p><?php echo $row['description']; ?></p></div>
                                    <div>

                                        <!-- Displaying Tags -->    
                                        <?php
                                            for ($i=0; $i < $n ; $i++) 
                                                {                                
                                                    echo '<a href="tag_name.php?tag_name='.$tags[$i].'"><button>'.$tags[$i].'</button></a>&ensp;';
                                                }
                                            $posted = strtotime($row['posted_on']);
                                            echo '<div class=post_date>posted '.fetch_date($posted).'<br>By: '.$row['firstname'].' '.$row['lastname'].'</div>';
                                            echo '<br><br><br>';

                                            //Displaying Comments
                                            echo "<div class= 'comment'>";
                                            while ($com = $sql->fetch()) 
                                            {
                                                echo '<p><strong>'.$com['firstname'].' '.$com['lastname'].'</strong> '.$com['comment'].'</p>';    
                                            } 
                                                echo '</div>';
                                        ?>

                                            <!-- Adding Comment -->
                                        <?php    
                                            if (isset($_GET['msg_com_ques'])) 
                                            {
                                                echo '<div style="color: #FF0000;">'.$_GET['msg_com_ques'].'</div>';
                                            }
                                         ?>       
                                        <form action="transact_portal.php?ques_id=<?php echo $_GET['ques_id']; ?>" method="post">      
                                        <div class = "acomment">
                                                <input type = "text" placeholder = "add a comment (max 100 character)"  name="comment" size = "50">
                                                <input type="submit" name="action" value="comment_ques">
                                            </div>
                                        </form>    
                                    </div>
                                    <hr>

                                    <br>

                                    <!-- Show Answered questions -->
                                    <?php
                                        if ($query->rowCount() !=0) 
                                        {
                                    ?>
                                            <h3 style="color: black;"><?php echo $query->rowCount();?> Answer(s)</h3>
                                            <?php
                                                while($r = $query->fetch()) 
                                                {
                                                    $user_info = $conn->prepare('SELECT u.firstname, u.lastname FROM users u, answers a WHERE u.user_id=a.user_id AND ans_id=:id');
                                                    $user_info->bindParam(':id',$r['ans_id']);
                                                    $user_info->execute();
                                                    $user_info->setFetchMode(PDO::FETCH_ASSOC);
                                                    $fetch = $user_info->fetch()
                                            ?>         

                                                    <!--Displaying Answers-->
                                                    <div class="ans"> 
                                                        <div>
                                                            <p><?php echo $r['answer']; ?></p>
                                                            <?php
                                                            if ($_SESSION['id'] == $r['user_id']) 
                                                            {
                                                                echo "<a href='edit.php?action=edit_ans&ans_id=".$r['ans_id']." style= 'margin-left: 10px; color: blue;'>edit</a>";
                                                            }
                                                            $post_date = strtotime($r['posted_on']);
                                                            echo '<div class=post_date>posted '.fetch_date($post_date).'<br>By: '.$fetch['firstname'].' '.$fetch['lastname'].'</div>';
                                                            ?>

                                                        </div>
                                                        <br><br><br>

                                                        <?php

                                                            //Fetching Comments From Database
                                                            $q = $conn->prepare('SELECT comment, firstname, lastname FROM comment_answer, users WHERE ans_id = :id AND comment_answer.user_id = users.user_id');
                                                            $q->bindParam(':id',$r['ans_id']);
                                                            $q->execute();
                                                            $q->setFetchMode(PDO::FETCH_ASSOC);


                                                            //Adding comments to the answer
                                                            echo "<div class= 'comment'>";
                                                            while ($com = $q->fetch()) 
                                                            {
                                                                echo '<p><strong>'.$com['firstname'].' '.$com['lastname'].'</strong> '.$com['comment'].'</p>';    
                                                            } 

                                                            echo '</div>';  
                                                        ?>

                                                        <!--Adding Comments on Answers-->
                                                        <?php
                                                            if (isset($_GET['msg_com_ans'])) 
                                                            {
                                                                echo '<div style="color: #FF0000;">'.$_GET['msg_com_ans'].'</div>';
                                                            }
                                                        ?> 
                                                        <form action="transact_portal.php?ans_id=<?php echo $r['ans_id']; ?>&ques_id=<?php echo $_GET['ques_id']; ?>" method="post">      
                                                            <div class = "acomment">
                                                                <input type = "text" placeholder = "add a comment (max 100 character)"  name="comment" size = "50">
                                                                <input type="submit" name="action" value="comment_ans">
                                                            </div>
                                                        </form>
                                                    </div> 
                                                    <br><br>       
                                    <?php                
                                                }
                                        }

                                        if (isset($_GET['msg_ans'])) 
                                        {
                                                echo '<div style="color: #FF0000;">'.$_GET['msg_ans'].'</div>';
                                        }    
                                    ?>  
                                        <h3 style="color: black;">Your Answer</h3>
                                        <form action="transact_portal.php?ques_id=<?php echo $_GET['ques_id']; ?>" method="post">
                                            <div>
                                                <textarea name="desc" id="desc" placeholder="Description"  class="form-control" rows="10" cols="50"></textarea>
                                            </div>
                                            <br>
                                            <div class="postinfobot">
                                                <div class="pull-right postreply">
                                                    <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
                                                    <div class="pull-left"><button type="submit" class="btn btn-primary" name="action" value="answer">Post Your Answer</button></div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>
                                        </form>      
                                </div>
                                <div class="clearfix"></div>
                            </div>                              
                                
                        </div>
                            
                    </div>
                    <br><br>
                    <div>
                        <div class="col-lg-4 col-md-4">

                            <?php    
                                $active = $conn->prepare('SELECT q.ques_id, q.title, COUNT(c.comment) AS comments FROM questions q, comment_question c WHERE c.ques_id = q.ques_id GROUP BY q.ques_id ORDER BY comments DESC');
                                $active->execute();
                                $active->setFetchMode(PDO::FETCH_ASSOC);

                            ?>
                            <!--SideBar 1-->
                            <div class="sidebarblock">
                                <h3><a href="index.php">Home <i class="fa fa-home" id="home"></i></a></h3>
                                <div class="divline"></div>
                                <div class="blocktxt">
                                   <ul class="cats">
                                        <li><a href="tags.php">Tags <i class="fa fa-tags" id="tags"></i></a></li>
                                        <li><a href="user.php">Users <i class="fa fa-user" id="user"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <!--Sidebar 2 -->
                            <div class="sidebarblock">
                                <h3>Active Threads</h3>
                                <?php
                                    while ($threads = $active->fetch()) 
                                    {

                                ?>
                                <div class="divline"></div>
                                <div class="blocktxt">
                                    <a href="02_topic.php?ques_id=<?php echo $threads['ques_id']; ?>"><?php echo $threads['title'];?></a>
                                </div>
                                <?php 
                                    }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>

        <br><br>
        <div>
            <?php
                include 'footer.php';
            ?>   
        </div>
    </div>



</body>
</html>