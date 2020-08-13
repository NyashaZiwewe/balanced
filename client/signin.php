<?php include'functions.php';
				if(isset($_POST['login'])){
				
				signIn($_POST['email'], $_POST['password']);
				}
				
				?>