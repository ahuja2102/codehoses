<?php
include 'db.php';

//Checking Whether the session is started on not
if (!isset($_SESSION)) 
{
	session_start();
}

//Action performed on questions
if (isset($_REQUEST['action'])) 
{
	switch ($_REQUEST['action']) 
	{
		//Storing the question
		case 'question':
			date_default_timezone_set('Asia/Kolkata');
			$stmt = $conn->prepare('INSERT INTO questions(user_id, title, description, tags, posted_on, modified_on) VALUES(:id, :title, :des, :tags, :dat, :dat)');
			$stmt->bindParam(':id',$_SESSION['id']);
			$stmt->bindParam(':title',$_POST['title']);
			$stmt->bindParam(':des',$_POST['desc']);
			$stmt->bindParam(':tags',$_POST['tags']);
			$stmt->bindParam(':dat',date('Y-m-d H:i:s'));
			$stmt->execute();

			//Increasing the number of times tag is used
			$tags = explode('","', $_POST['tags']);
	        $n = count($tags);
	        $tags[0] = substr($tags[0], 1);
	        $tags[$n-1] = substr($tags[$n-1], 0, strlen($tags[$n-1])-1);

	        for ($i=0; $i<$n; $i++) 
	        { 
	        	$used = $conn->prepare('UPDATE tags SET used=used+1 WHERE tagname = :tag');
	        	$used->bindParam(':tag',strtolower($tags[$i]));
	        	$used->execute();
	        }

			header('Location: index.php');
		
			break;

		
		//Storing the answer
		case 'answer':

			if (!isset($_SESSION['id'])) 
			{
				$msg='Please Login first to provide the answer';
				header('Location: 02_topic.php?ques_id='.$_GET['ques_id'].'&msg_ans='.$msg);
			}
			else
			{	
				date_default_timezone_set('Asia/Kolkata');
				$stmt = $conn->prepare('INSERT INTO answers(user_id, ques_id, answer, posted_on, modified_on) VALUES(:uid, :qid, :ans, :dat, :dat)');
				$stmt->bindParam(':uid',$_SESSION['id']);
				$stmt->bindParam(':qid',$_GET['ques_id']);
				$stmt->bindParam(':ans',$_POST['desc']);
				$stmt->bindParam(':dat',date('Y-m-d H:i:sa'));
				$stmt->execute();

				header('Location: 02_topic.php?ques_id='.$_GET['ques_id']);
			}	
			break;


		//Inserting comment on answers	
		case 'comment_ans':

			if (!isset($_SESSION['id'])) 
			{
				$msg='Please Login first to comment';
				header('Location: 02_topic.php?ques_id='.$_GET['ques_id'].'&msg_com_ans='.$msg);
			}
			else
			{	
				$stmt = $conn->prepare('INSERT INTO comment_answer(user_id, ans_id, comment) VALUES(:uid, :aid, :comment)');
				$stmt->bindParam(':uid',$_SESSION['id']);
				$stmt->bindParam(':aid',$_GET['ans_id']);
				$stmt->bindParam(':comment',$_POST['comment']);
				$stmt->execute();

				header('Location: 02_topic.php?ques_id='.$_GET['ques_id']);
			}
			break;


		//Inserting comment on questions
		case 'comment_ques':
			
			if (!isset($_SESSION['id'])) 
			{
				$msg='Please Login first to comment';
				header('Location: 02_topic.php?ques_id='.$_GET['ques_id'].'&msg_com_ques='.$msg);
			}
			else
			{	
				$stmt = $conn->prepare('INSERT INTO comment_question(user_id, ques_id, comment) VALUES(:uid, :qid, :com)');
				$stmt->bindParam(':uid',$_SESSION['id']);
				$stmt->bindParam(':qid',$_GET['ques_id']);
				$stmt->bindParam(':com',$_POST['comment']);
				$stmt->execute();

				header('Location: 02_topic.php?ques_id='.$_GET['ques_id']);
			}	
			break;


		//Marking Favourite Questions
		case 'favins':
			$stmt=$conn->prepare('INSERT INTO favourites(user_id, ques_id) VALUES(:uid, :qid)');
			$stmt->bindParam(':uid',$_SESSION['id']);
			$stmt->bindParam(':qid',$_POST['ques_id']);
			$stmt->execute();
			echo 'favourites on '.$_POST['ques_id'].' added';
			break;


		//Deleting Favourite Questions
		case 'favdel':
			$stmt=$conn->prepare('DELETE FROM favourites WHERE ques_id = :qid AND user_id = :uid ');
			$stmt->bindParam(':qid',$_POST['ques_id']);
			$stmt->bindParam(':uid',$_SESSION['id']);
			$stmt->execute();
			echo 'favourites on '.$_POST['ques_id'].' deleted';
			break;


		//Updating the Questions	
		case 'Update_ques':
			$stmt=$conn->prepare('UPDATE questions SET title=:title, description=:des, tags=:tags, modified_on=:dat WHERE ques_id=:qid');
			$stmt->bindParam(':title',$_POST['title']);
			$stmt->bindParam(':des',$_POST['desc']);
			$stmt->bindParam(':tags',$_POST['tags']);
			$stmt->bindParam(':dat',date('Y-m-d H:i:s'));
			$stmt->bindParam(':qid',$_POST['ques_id']);
			$stmt->execute();

			header('Location: 02_topic.php?ques_id='.$_POST['ques_id']);
			break;	


		//Updating The Answer	
		case 'Update_ans':
			$stmt = $conn->prepare('UPDATE answers SET answer = :ans, modified_on = :dat WHERE ans_id = :id');
			$stmt->bindParam(':ans',$_POST['desc']);
			$stmt->bindParam(':dat',date('Y-m-d H:i:s'));
			$stmt->bindParam(':id',$_GET['ans_id']);
			$stmt->execute();

			header('Location: 02_topic.php?ques_id='.$_POST['ques_id']);
			break;

		//Like Tag	
		case 'tag_like':
			$stmt = $conn->prepare('INSERT INTO like_tag(user_id, tag_id) VALUES(:uid, :tid)');
			$stmt->bindParam(':uid',$_SESSION['id']);
			$stmt->bindParam(':tid',$_POST['tag_id']);
			$stmt->execute();
			break;

		//Dislike Tag
		case 'tag_dislike':
			$stmt = $conn->prepare('DELETE FROM like_tag WHERE tag_id=:tid');
			$stmt->bindParam(':tid',$_POST['tag_id']);
			$stmt->execute();
			break;

	}
}
?>