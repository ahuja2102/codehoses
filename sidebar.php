<?php
 include 'db.php';

 $stmt = $conn->prepare('SELECT q.ques_id, q.title, COUNT(c.comment) AS comments FROM questions q, comment_question c WHERE c.ques_id = q.ques_id GROUP BY q.ques_id ORDER BY comments DESC');
 $stmt->execute();
 $stmt->setFetchMode(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum :: Home Page</title>
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
<body>
    <div class="col-lg-4 col-md-4">

        <!--SideBar 1-->
        <div class="sidebarblock">
            <h3><a href="index.php">Home <span class="fa fa-home" id="home"></span></a></h3>
            <div class="divline"></div>
            <div class="blocktxt">
               <ul class="cats">
                    <li><a href="tags.php">Tags <span class="fa fa-tags" id="tags"></span></a></li>
                    <li><a href="user.php">Users <span class="fa fa-user" id="user"></span></a></li>
                </ul>
            </div>
        </div>

        <!--Sidebar 2 -->
        <div class="sidebarblock">
            <h3>Active Threads</h3>
            <?php
                while ($row = $stmt->fetch()) 
                {

            ?>
            <div class="divline"></div>
            <div class="blocktxt">
                <a href="02_topic.php?ques_id=<?php echo $row['ques_id']; ?>"><?php echo $row['title'];?></a>
            </div>
            <?php 
                }
            ?>

        </div>

    </div>

</body>
</html>        