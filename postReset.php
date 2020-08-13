<?php

	include 'config.php';

	function combinedReset($par){



		//include conection to the database

		$conn = dbconnect();



		//get the jobtitles

		$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM client_credentials WHERE email = ?");

		$stmt->bind_param('s', $email);

		$email = $par;

		$stmt->execute();

		$stmt->store_result();

		$stmt->bind_result($count);

		$stmt->fetch();

		$stmt->close();



		//check condition of count

		if($count == 1){



			$stmt = $conn->prepare("SELECT password FROM client_credentials WHERE email = ?");

			$stmt->bind_param('s', $email);

			$email = $par;

			$stmt->execute();

			$stmt->store_result();

			$stmt->bind_result($password);

			$stmt->fetch();

			$stmt->close();



			if (!empty($_SERVER["HTTP_CLIENT_IP"]))

			{

			 //check for ip from share internet

			 $ip = $_SERVER["HTTP_CLIENT_IP"];

			}

			elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))

			{

			 // Check for the Proxy User

			 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];

			}

			else

			{

			 $ip = $_SERVER["REMOTE_ADDR"];

			}



			// $salt = "ohbnjxgdfhjkh764wrdxtgfchv";

			// $pword = $password.$salt;

			// $pass = sha1($pword);



			// //send the email

			// $to = $par; 

		 //    $from = "admin@360_degrees.com"; 

		 //    $subject = "RE: Password Recovery";

		 //    $message = 'Good day, Please find below the email and password for your account. Email Address: '.$email.' Password: '.$pass.' Follow this link to login: https://ipcjobsportal.com/360_degrees/login.php Regards, IPC Administrator.';

		 //    $headers = "From:" . $from;

		   

		 //    mail($to,$subject,$message,$headers);mail('kudzai@ipcconsultants.com',$subject,$message,$headers);



			// //redirect after sending email

			// header("Location: reset.php?email_sent=true");

			//close conn

			$conn->close();



		}else{

			//include conection to the database

			$conn = dbconnect();



			//get the jobtitles

			$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM accounts WHERE email = ?");

			$stmt->bind_param('s', $email);

			$email = $par;

			$stmt->execute();

			$stmt->store_result();

			$stmt->bind_result($count);

			$stmt->fetch();

			$stmt->close();



			//check condition of count

			if($count == 1){



				$stmt = $conn->prepare("SELECT password FROM accounts WHERE email = ?");

				$stmt->bind_param('s', $email);

				$email = $par;

				$stmt->execute();

				$stmt->store_result();

				$stmt->bind_result($password);

				$stmt->fetch();

				$stmt->close();



				if (!empty($_SERVER["HTTP_CLIENT_IP"]))

				{

				 //check for ip from share internet

				 $ip = $_SERVER["HTTP_CLIENT_IP"];

				}

				elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))

				{

				 // Check for the Proxy User

				 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];

				}

				else

				{

				 $ip = $_SERVER["REMOTE_ADDR"];

				}



				// $salt = "ohbnjxgdfhjkh764wrdxtgfchv";

				// $pword = $password.$salt;

				// $pass = sha1($pword);	



				// //send the email

				// $to = $par; 

			 //    $from = "admin@360_degrees.com"; 

			 //    $subject = "RE: Password Recovery";

			 //    $message = 'Good day, Please find below the email and password for your account. Email Address: '.$email.' Password: '.$pass.' Follow this link to login: https://ipcjobsportal.com/360_degrees/login.php Regards, IPC Administrator.';

			 //    $headers = "From:" . $from;

			   

			 //    mail($to,$subject,$message,$headers);mail('kudzai@ipcconsultants.com',$subject,$message,$headers);



				// //redirect after sending email

				// header("Location: reset.php?email_sent=true");



			}else{



				// header("Location: reset.php?email_error=true");



			}



			//close conn

			$conn->close();



		}



	}

	combinedReset($_POST['email']);

?>