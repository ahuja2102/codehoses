<?php
	include 'db.php';
$imagename=$_FILES["image"]["name"]; 

//Get the content of the image and then add slashes to it 
$imagetmp=addslashes (file_get_contents($_FILES['image']['tmp_name']));

//Insert the image name and image content in image_table
$dateTime = date("Y-m-d H:i:s");
try 
{
	$stmt=$conn->prepare("INSERT INTO test VALUES(:img, :dat)");
	$stmt->bindParam(':img',$imagetmp);
	$stmt->bindParam(':dat',$dateTime);
	$stmt->execute();
} 
catch (PDOException $e) 
{
	echo $e->getmessage();
}

/*$insert_image="INSERT INTO test VALUES('$imagetmp','$dateTime')";
mysql_query($insert_image);*/
echo 'success';

?>