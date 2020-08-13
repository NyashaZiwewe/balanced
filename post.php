<?php

	include 'config.php';

	function mailing_list($par1){



		//include conection to the database

		$conn = dbconnect();



		//get the jobtitles

		$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM mailing_list WHERE email = ?");

		$stmt->bind_param('s', $email);

		$email = $par1;

		$stmt->execute();

		$stmt->store_result();

		$stmt->bind_result($count);

		$stmt->fetch();

		$stmt->close();



		//set conditions for the count

		if($count == 0){



			//insert into table

			$stmt = $conn->prepare("INSERT INTO mailing_list (email) VALUES(?)");

			$stmt->bind_param('s', $email);

			$email = $par1;

			$stmt->execute();

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



			$footer = basename($_SERVER['PHP_SELF']);



			// echo "<script type='text/javascript'>

			// 	window.location.href = '".$footer."?sendmessage=true';

			// 	</script>";



		}else{



			//return error

			$footer = basename($_SERVER['PHP_SELF']);

			// echo "<script type='text/javascript'>

			// 	window.location.href = '".$footer."?errormessage=true';

			// 	</script>";



		}



		//close conn

		$conn->close();



	}

	mailing_list($_POST['email']);

?>