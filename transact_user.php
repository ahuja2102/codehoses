<?php
include 'db.php';
session_start();
include 'validation_function.php';
if (isset($_REQUEST['action'])) 
{
	switch ($_REQUEST['action']) 
	{

		//User Register
		case 'Signup':

			$errors = array();
			if (Email_valid($_POST['email'])) 
			{
				$err = Email_valid($_POST['email']);
				$errors['email_err']=$err;
			}
			if (username_valid($_POST['username'])) 
			{
				$err = username_valid($_POST['username']);
				$errors['u_err']=$err;
			}
			if (name_valid($_POST['first'])) 
			{
				$err = name_valid($_POST['first']);
				$errors['first']=$err;
			}
			if (name_valid($_POST['last'])) 
			{
				$err = name_valid($_POST['last']);
				$errors['last']=$err;
			}
			if (password_valid($_POST['pass'], $_POST['pass2'])) 
			{
				$err = password_valid($_POST['pass'], $_POST['pass2']);
				$errors['pass'] = $err;
			}
			if (!empty($errors)) 
			{	
				$var = serialize($errors);
				header('Location: 04_new_account.php?error='.$var);
			}
			else
			{	
				if (isset($_POST['profilepic'])) 
				{
					$target_dir = "uploads/";
				    $target_file = $target_dir.basename($_FILES["profilepic"]["name"]);
				    $uploadOk = 1;
				    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				    if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
				        echo "The file ". basename( $_FILES["profilepic"]["name"]). " has been uploaded.";
				    } else {
				        echo "Sorry, there was an error uploading your file.";
				    }
				    $image=basename( $_FILES["profilepic"]["name"],".jpg");
			    }
	 			try 
	 			{
	 				$stmt=$conn->prepare('INSERT INTO users(user_id, firstname, lastname, username, email_id, password, picture) VALUES(NULL, :first, :last, :username, :email, :pass, :pic)');
	 				$stmt->bindParam(':first',$_POST['first']);
	 				$stmt->bindParam(':last',$_POST['last']);
	 				$stmt->bindParam(':username',$_POST['username']);
	 				$stmt->bindParam(':email',$_POST['email']);
	 				$stmt->bindParam(':pass',$_POST['pass']);
	 				$stmt->bindParam(':pic',$image);
	 				$stmt->execute();

	 				$msg = 'Please login to begin with your homepage';
	 				header('Location: 05_login.php?msg='.$msg);

		 		} 
		 		catch (PDOException $e) 
		 		{
		 			echo $e->getmessage();
		 		}
	 		}
			break;

		//User Login	
		case 'Login':
				$stmt = $conn->prepare('SELECT * FROM users WHERE username = :username AND password = :pass');
				$stmt->bindParam(':username',$_POST['username']);
				$stmt->bindParam(':pass',$_POST['pass']);
				$stmt->execute();

				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$row = $stmt->fetch();
				if ($stmt->rowCount() == 0) 
				{
					$msg='Invalid email and password combination';
					header('Location: 05_login.php?msg='.$msg); 
				}
				else
				{	
					$_SESSION['id'] = $row['user_id'];
					$_SESSION['name'] = $row['firstname'];
					$_SESSION['pic'] = $row['picture'];
					
					header('Location: index.php');
				}
			break;	
		

		//User Logout
		case 'Logout':
			if (isset($_SESSION)) 
			{		
			session_unset();
			session_destroy();
			/*echo "logout successful ";
			echo session_status();*/
			}
			$url = $_SERVER['HTTP_REFERER'];
			if ($url == 'http://www.codehoses.com/stack/profile.php') 
			{
				$url = 'index.php';
			}
			header('Location: '.$url);
			break;
		
		//User Update	
		case 'Update':
			if (!empty($_POST['c_name']) && !empty($_POST['por'])) 
			{
				$por = $_POST['por'].' at '.$_POST['c_name']; 
			}
			else
			{
				$por = '';
			}
			$stmt = $conn->prepare('UPDATE users SET firstname = :first, lastname = :last, email_id = :email , Dob = :dob , por = :por , about_me = :me WHERE user_id = :id');
			$stmt->bindParam(':first',$_POST['first']);
			$stmt->bindParam(':last',$_POST['last']);
			$stmt->bindParam(':email',$_POST['email']);
			$stmt->bindParam(':dob',$_POST['dob']);
			$stmt->bindParam(':por',$por);
			$stmt->bindParam(':me',$_POST['about_me']);
			$stmt->bindParam(':id',$_SESSION['id']);
			$stmt->execute();

			header('Location: profile.php');
			break;

		//User Profile Pic Change	
		case 'change_pic':

			$target_dir = "uploads/";
		    $target_file = $target_dir.basename($_FILES["file"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		    $pic=basename( $_FILES["file"]["name"],".jpg");
		    $pic .='.jpg';

			$stmt=$conn->prepare('UPDATE users SET picture=:pic WHERE user_id=:id');
			$stmt->bindParam('pic',$pic);
			$stmt->bindParam(':id',$_SESSION['id']);
			$stmt->execute();
			$_SESSION['pic'] = $pic;

			echo 'Profile Pic changed successfully';
			break;		

        //Following a user
		case 'follow':

			$stmt=$conn->prepare('INSERT INTO followers(follwed_to, followed_by) VALUES(:tid, :fid)');
			$stmt->bindParam(':tid', $_POST['user_id']);
			$stmt->bindParam(':fid',$_SESSION['id']);
			$stmt->execute();
					
			echo 'Follower Added';		
			break;

		//Unfollowing a user	
		case 'Unfollow':

			$stmt=$conn->prepare('DELETE FROM followers WHERE followed_by=:fid');
			$stmt->bindParam(':fid',$_SESSION['id']);
			$stmt->execute();
					
			echo 'Follower Removed';		
			break;				
	}
}
?>