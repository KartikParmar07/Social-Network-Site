<?php
	
	session_start();
    $message = "";  
	 
    // PDO connection_________________________________________________________________________________________________________________________________
	
      $connect = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
	  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $username=$_SESSION["username"];
	 
	 //Fetching Followers________________________________________________________________________________________________________________________________________
	
	$query = "SELECT * FROM followers WHERE follower = :user_name";  
                $z = $connect->prepare($query);
                $z->execute( array('user_name' => $_SESSION["username"]));  
	
	$z->setFetchMode(PDO::FETCH_ASSOC);
	
	
	 //Fetching Followers_____________________________________________________________________
	 
	if(isset($_POST["search"])) 
        {
			$var1= $_POST["var1"];
			$sql = 'SELECT * FROM followers WHERE follower LIKE :keyword ORDER BY id DESC ';
$pdo_statement = $connect->prepare($sql);
$pdo_statement->bindValue(':keyword', '%' . $var1 . '%', PDO::PARAM_STR);
$pdo_statement->execute();
if(!$pdo_statement->rowCount()){
	$message = '<label>No result found</label>';
}
else{

$result = $pdo_statement->fetchAll();

}

}
	?>
	
	
	
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
<?php include 'profilecard.css'; ?>
</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<div class="header">
<h1><a href="pf.php" class="logo" style="font-family:Segoe Script;text-decoration:none;"><b>Project</a></h1>	
<div><nav>
<a href="followers.php" class="btn" id="search">&#9740;</a>
  
<form name="frmSearch" method="post" action="followers.php">
   
      <input name="var1" type="text" id="var1">
      <input type="submit" value="Search" name="search">
     
</div>
</form>
</nav></div> 
</head>
<div>
     <?php if(empty($var1))
	 {
		 while ($row = $z->fetch()): ?>
	<a><h4>
	  <?php  echo htmlspecialchars($row['following']);  ?>
	<hr style="border:solid 1px">
	</h4></a>
	 <?php endwhile;  ?>
	 <?php 
	 }

	 else
	 {
		 foreach( $result as $row ) 
		 {
   	?>
	<a href="followers.php">
   <?php 

   echo $row["follower"]; 
    $_SESSION['fa']= $row["follower"]; 
    
	echo '<hr>';
	 }
	 }
		 ?>
	
</div>