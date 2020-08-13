<?php

	//include config file
	include 'client/functions.php';

	//include connection to db
	$conn = dbconnect();

    $email = test_input($_POST['email']);
	$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bsc_accounts WHERE email = ?");
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();

	if($count == 0){

	//variables

	$password = 'IPC'.substr((md5($_POST['first_name'].' '.$_POST['client_id'].' '.$_POST['last_name'])),0,10);
	//$username = 'IPC'.substr((md5($_POST['first_name'].' '.$_POST['client'])),0,5);
	//$status = 0;
	$first_name = test_input($_POST['first_name']);
	$last_name = test_input($_POST['last_name']);
	$email = test_input($_POST['email']);
	$account_type = test_input($_POST['account_type']);
	$client_id = test_input($_POST['client_id']);
	$business_unit = test_input($_POST['business_unit']);
	$department_id = test_input($_POST['department_id']);

	 $stmt = $conn->prepare("INSERT INTO bsc_accounts (first_name, last_name, client, email,business_unit, department, account_type, password) VALUES (?,?, ?, ?,?, ?, ?,?)");
      $stmt->bind_param('ssssssss', $first_name, $last_name, $client_id, $email,$business_unit, $department_id,$account_type,$password);   
      $stmt->execute();
      $stmt->close();
      $last_id = $conn->insert_id;

    addEmployeeScorecard($last_id, $client_id, $business_unit, $department_id, $account_type);


		$subject = "RE: New Job Ipeform Account Creation";

		$message = "<html>
						<body style='color:#1575a7;'>
							<p>Good day <b>".$first_name." ".$last_name."</b>,</p>
							<p>Thank you for registering with us today. Your account has been created successfully.</p><p>Please find below the login credentials and the link to sign in:</p>
							<p><b>Email:</b> ".$email."</p>
							<p><b>Password:</b> ".$password."</p>
							<p><b>Link to sign in:</b> <a href='https://www.epsychos.net/demo/signin.php'>https://www.epsychos.net/demo/signin.php</a></p>
							<p>Regards,</p>
							<p>Industrial Psychology Consultants (Pvt) Ltd</p>
					</html>";
		$message1 = "<html>
						<body style='color:#1575a7;'>
							<p>Good day team,</p>
							<p><b>".$first_name." ".$last_name."</b> of <b>".getClientName($client_id)."</b> has registered on Iperform system. Sign in to view more details.</p>
							<p>Link to sign in:  <a href='https://www.epsychos.net/demo/signin.php'>https://www.epsychos.net/demo/signin.php</a></p>
							<p>Regards,</p>
							<p>Administrator</p>
					</html>";
					
			$headers = "From:  Industrial Psychology Consultants" . strip_tags('admin@epsychos.net') . "\r\n";
			$headers .= "Reply-To: ". strip_tags('bis@ipcconsultants.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			
			$admin='bis@ipcconsultants.com';

		 mail($email, $subject, $message, $headers);
		 mail($admin, $subject, $message1, $headers);

		$conn->close();


      //close conn
      $conn->close();

      echo "<script type='text/javascript'>
        window.location.href = 'signin.php?success=true';
        </script>";
    }
	   else{

        echo "<script type='text/javascript'>
        window.location.href = 'cregister.php?email=true';
        </script>";
		$conn->close();

	}

?>