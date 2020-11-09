<?php
session_start();
        $pdo = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if(isset($_POST['confirm'])){
			
session_destroy();
header('Location: login.php');
exit;
		}
	?>
	
	
	
	<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
<?php include 'log.css'; ?>
</style>

</head>
<body>

<div class="header">
  <a href="index.php" class="logo">Project</a>
 </div>
</h1>
<h1> Logout account <?php echo  $_SESSION["username"];?>
	<h5> Are you sure you'd like to Logout?</h5>
	<form action="logout.php" method="post">
		    <input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices</br></br>
			<input type="submit" name="confirm" value="Confirm">

	</form>