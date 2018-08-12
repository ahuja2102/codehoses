<?php
  include 'db.php';
?>
<html>
<head>
    <title>Pagination</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $stmt = $conn->prepare('SELECT COUNT(*) AS rows FROM test');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        $total_rows = $result['rows'];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $query = 'SELECT * FROM test LIMIT '.$offset.', '.$no_of_records_per_page;
        $sql = $conn->prepare($query);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        echo '<table><tr><td>user_id</td><td>name</td><td>email</td><td>Password</td></tr>';
        while($row = $sql->fetch())
        {
          echo "<tr><td>".$row['user_id']."</td><td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['password']."</td></tr>";
        }
        echo "</table>";    
        ?>
                            <ul class="pagination">
                                <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"> < </a>
                                </li>
                                  <?php
                                    for ($i=1; $i<=$total_pages; $i++) 
                                    { 
                                      echo '<li><a href="?pageno='.$i.'">'.$i.'</li>';
                                    }
                                  ?>
                                <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"> > </a>
                                </li>
                            </ul>
</body>
</html>