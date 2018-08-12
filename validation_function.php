<?php

	function Email_valid($email)
	{
		include 'db.php';
		$stmt=$conn->prepare('SELECT email_id FROM users');
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		if (isset($email)) 
		{
			while ($row=$stmt->fetch()) 
			{
				if ($email == $row['email_id']) 
				{
					$emailErr = 'Email already exists';
					return $emailErr;
				}
			}
			
			if (!preg_match("/^([a-z0-9\+_\-]+)([a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $email)) 
			{
				$emailErr = 'Invalid Email Format';
				return $emailErr;
			}
		}
	}

	function username_valid($u_name)
	{
		include 'db.php';
		$stmt=$conn->prepare('SELECT username FROM users');
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		if (isset($u_name)) 
		{
			while ($row = $stmt->fetch()) 
			{
				if($u_name == $row['username'])
				{
					$uErr = 'Username Already Exists';
					return $uErr;
				}	
			}

		}
	}

	function name_valid($name)
	{
		if (isset($name)) 
		{
			if (!preg_match("/^([a-zA-Z' ]+)$/",$name)) 
			{
				$name = 'Name is not valid';
				return $name;
			}
		}
	}

	function password_valid($pass1, $pass2)
	{
		if (isset($pass1) && isset($pass2)) 
		{
			if ($pass1 != $pass2) 
			{
				$passErr = 'Password do not match';
				return $passErr;
			}

		}
	}
?>