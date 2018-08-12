<?php
include 'db.php';
if(isset($_POST["submit"])){
$target_dir = "uploads/";
    $target_file = $target_dir.basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

        /*
         * Insert image data into database
         */
    
        
        // Check connection
        
        $dateTime = date("Y-m-d H:i:s");
        $image=basename( $_FILES["image"]["name"],".jpg");
        
        //Insert image content into database
        $stmt = $conn->prepare("INSERT into test1(image, created) VALUES(:img, :dat)");
        $stmt->bindParam(':img',$image);
        $stmt->bindParam(':dat',$dateTime);
        $stmt->execute();

        echo 'Success';
    }

?>