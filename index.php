<?php
session_start();  

//PDO connection_________________________________________________________________________________________________________________________
try{
              $connect = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
		      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
			   $username=$_SESSION["username"];
}	   
	 catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
	   //posting code________________________________________________________________________________________________________
	    $usnm = $_SESSION["username"];
	  $lk1="caafbcc9457fc97c2df2086dd9f31b0f--strange-facts-crazy-facts.jpg";
	
	  if(isset($_POST['post'])){
		   if(empty($_POST['postbody'])) 
           {  
                 $message = '<label>Cant post nothing XD</label>';  
           }  
           else  
           {  $postbody=$_POST['postbody'];
		
		 $query = "INSERT INTO posts (body,posted_at,user_name) VALUES ('$postbody',NOW(),'$username')";
		 $connect->exec($query);
		 }
		

	 }
// post retrieval code_______________________________________________________________________________________
			  
			  $sql = "SELECT * FROM posts ORDER BY id DESC";  
	
                $q = $connect->prepare($sql);
                $q->execute( array('user_name' => $_SESSION["username"]));  
	
	$q->setFetchMode(PDO::FETCH_ASSOC);
	
	
	
 
try{




}
 catch (Exception $e) {
    // Nothing, this is normal
}

 if(isset($_POST['search']))
           {  
	         $var1 = $_POST['var1'];
            $_SESSION['var1'] = $var1;
			$query = "SELECT * FROM users WHERE username LIKE :search OR email LIKE :search";
$stmt = $connect->prepare($query);
$stmt->bindValue(':search', '%' . $var1 . '%', PDO::PARAM_INT);

$stmt->setFetchMode(PDO::FETCH_ASSOC);
			  header('Location: search.php');
           }  


		   
		   
		   if(isset($_POST['comment']))
           {  
	   $sender=$_SESSION["username"];
	   $comment= $_POST['comment'];

         $query = "INSERT INTO comment (comment,sender,receiver) VALUES ('$comment',$sender,'$reciever')";
		 $connect->exec($query);
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
  <a href="#default" class="logo">Project</a>
 
  <div class="header-right">
   <a href="logout.php">Logout</a>
    <a href="pf.php">Profile</a>
  </div>
  <div style="padding-left:270px;margin-top:30px;">
<form name="frmSearch" method="post" action="index.php">
   
      <input name="var1" type="text" id="var1">
      <input type="submit" value="Search" name="search">
     
</div>
</form>
</div>
</div>

<div style="padding-bottom:20px; margin-bottom:2px;">
</br>
<a href="pic.php"style="font-family:Segoe Script; font-size:25px; text-decoration:none; color:20F0EA; padding-left:90px;">Create a new Post, Share your content with the world..... Click here</a>
<hr style="border:solid 1px gray">
</div>
 <div id="container" style="padding-left:20px;margin-top:20px">
            <h1 style="font-family:Segoe Script;font-size:50px" >News Feed</h1>

<div id="columns">


     <?php while ($row = $q->fetch()): ?>
    <figure>
	 <a href="fprofile.php" style="text-decoration:none"><?php echo htmlspecialchars($row['user_name']); $_SESSION['fa'] = $row['user_name'];?></b></a>
	 <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="auto" height="inherit">
    <figcaption> <?php echo htmlspecialchars($row['body']); ?> </br><hr>Posted at: <?php echo htmlspecialchars($row['posted_at']); ?><hr></figcaption>
	<hr>
	<script>
$( "#search" ).click(function(e) {
		e.preventDefault();
		$(".search_box").toggleClass('active');
	});
	
	</script>

	<input type="submit" class="button button4" value="Like(<?php 
// Likes retrieval code_______________________________________________________________________________________
	$lk = "SELECT count(*) FROM `likes` WHERE pid = :pid"; 
$result = $connect->prepare($lk);
$result->execute(array('pid' => $row['image'])); 
$lkc = $result->fetchColumn(); 
echo $lkc;
	?>)"> &nbsp &nbsp
	<input type="text" name="comment" placeholder="Comment....."><input type="submit" class="button button4" value="Post">
	</figure>	
	<?php endwhile; ?>
  <small>SOCIAL-NETWORK; <a">K$P</a></small>
  
  
  
  

	</div>
                  
</div>
</body>
</html>



