<?php

	include 'config.php';

	//include connection to db
	$conn = dbconnect();

	$par1 = test_input($_POST['email']);
	$par2 = test_input($_POST['password']);

	//session start up
	session_start();

	//set loging to false
	$login = false;
	$status = 1;

	// prepare and bind
	$stmt = $conn->prepare("SELECT bsc_client_credentials.client_id, bsc_client_credentials.email, bsc_client_credentials.password, bsc_client_work_details.company_name, special FROM bsc_client_credentials INNER JOIN bsc_client_work_details ON bsc_client_credentials.client_id = bsc_client_work_details.client_id WHERE bsc_client_credentials.email = ? AND bsc_client_credentials.password = ? AND bsc_client_credentials.status = ?");
	$stmt->bind_param("ssi", $email, $password, $status);

	// set parameters 
	$email = test_input(@$par1);
	$password = test_input(@$par2);
	

	//get the count of the email
	$sql = "SELECT COUNT(*) AS count FROM bsc_client_credentials WHERE email = '".$email."' AND password = '".$password."' AND status = $status";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$count = $row['count'];

	//set condition and execute depending on the condition
	if($count == 1){

		$stmt->execute();

		$stmt->store_result();
		$stmt->bind_result($client_id, $email,$password, $company_name, $special);

		while($stmt->fetch())
		{

			//get the session variables
		//	$_SESSION["client_id"] = $company_name;
			$_SESSION["client_id"] = $client_id;
			$_SESSION["email"] = $email;
			$_SESSION["password"] = $password;
			$_SESSION['account_type'] =1;
			$_SESSION["business_unit"] = "All";
			$_SESSION["special"]= $special;
			$_SESSION["logged"] = true;
		    $login = true;
		    break; 

		}
  
			header("Location: client/home");
		}

	else{

		//get the count of the email
		$sql = "SELECT COUNT(*) AS count FROM bsc_accounts WHERE email = '".$email."' AND password = '".$password."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$count = $row['count'];

		if($count == 1){

			//set loging to false
			$login = false;

			// prepare and bind
			$stmt = $conn->prepare("SELECT id AS user_id, client, first_name, last_name, email, password, supervisoremail, business_unit, department, account_type FROM bsc_accounts WHERE email = ? AND password = ?");
			$stmt->bind_param("ss", $email, $password);

			// set parameters 
			$email = test_input(@$_POST['email']);
			$password = test_input(@$_POST['password']);

			$stmt->execute();

			$stmt->store_result();
			$stmt->bind_result($user_id, $client, $first_name, $last_name, $email,$password, $supervisoremail, $business_unit, $department_id, $account_type);

			while($stmt->fetch())
			{

				//get the session variables
				$_SESSION["client_id"] = $client;
				$_SESSION["user_id"] = $user_id;
				$_SESSION["email"] = $email;
				$_SESSION["password"] = $password;
				$_SESSION["first_name"] = $first_name;
				$_SESSION["last_name"] = $last_name;
				$_SESSION["supervisoremail"] = $supervisoremail;
				$_SESSION["business_unit"] = $business_unit;
				$_SESSION["department_id"] = $department_id;
				$_SESSION["account_type"] = $account_type;
				$_SESSION["logged"] = true;
			    $login = true;
			    break; 

			}

			header("Location: client/home");

		}else{
			header("Location: signin.php?failure=true");
			exit;

		}

	}

	$stmt->close();
	$conn->close();

?>