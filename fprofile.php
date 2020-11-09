<?php
	
	session_start();
    $message = "";  
	
    // PDO connection_________________________________________________________________________________________________________________________________
	
      $connect = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
	  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	   $pfname= $_SESSION['fa'] ;
		 $me= $_SESSION["username"];	   
	 
	 
 //Profile card code________________________________________________________________________________________________________________________________________
	 
	 $query = "SELECT * FROM users WHERE username = :user_name";  
                $z = $connect->prepare($query);
                $z->execute( array('user_name' => $pfname));  
	
	$z->setFetchMode(PDO::FETCH_ASSOC);
	
	
	 //Post retrieval code________________________________________________________________________________________________________________________________________
	 
	 $query = "SELECT * FROM posts WHERE user_name = :user_name ORDER BY id DESC";  
                $q = $connect->prepare($query);
                $q->execute( array('user_name' => $pfname));  
	
	$q->setFetchMode(PDO::FETCH_ASSOC);
	
	
	$sql = "SELECT count(*) FROM `POSTS` WHERE user_name = :username"; 
$result = $connect->prepare($sql);
$result->execute(array('username' => $pfname)); 
$nume = $result->fetchColumn(); 




  
	   
	    //Profile Card info retrieval code________________________________________________________________________________________________________________________________________
$e='';
	 try{
	 $query = "SELECT * FROM users_info WHERE username = :user_name ORDER BY id DESC";  
                $x = $connect->prepare($query);
                $x->execute( array('user_name' =>$pfname));  
	
	$x->setFetchMode(PDO::FETCH_ASSOC);
	 }
	 catch (Exception $e) {
    // Nothing, this is normal
}

 if(isset($_POST["follow"])) 
      { 
  $msn = "started following you";
        $query = "INSERT INTO followers (follower, following) VALUES ('$me','$pfname')";
        $connect->exec($query);
		
		$notf = "INSERT INTO notifications (sender,reciever,msg,at) VALUES ('$me','$pfname','$msn',NOW())";
		 $connect->exec($notf);
		 
} 
if(isset($_POST["unfollow"])) 
      { 
	   $sql = "DELETE FROM followers WHERE follower=? and following=?";
$stmt= $connect->prepare($sql);
$stmt->execute([$me,$pfname]);
} 

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
<?php include 'profilecard.css'; ?>
</style>

</head>
<div class="header">
<h1><a href="pf.php" class="logo" style="font-family:Segoe Script;text-decoration:none;"><b>Project</a></h1>	 




</div>
<!-- Profile card -------------------------------------------------------------------------------------------------------------->
<div class="container"style="padding:20px">
    <div class="row user-menu-container square">
	<form action="fprofile.php" method="post">
	<?php 

    $sql=$connect->prepare("SELECT * FROM followers WHERE follower=? and following=?");
	$sql->execute(array($me, $pfname));
	
	
	if($sql->rowCount()==1){
		
	?>
<b><input type="submit" name="unfollow" value="UnFollow" class="button button3"style=" padding: 8px 20px;  border: 2px solid 20F0EA; margin-left:1100px;color: black;"></b>

<?php  
	}
else{
?>
 <b><input type="submit" name ="follow" value="Follow" class="button button3" style=" padding: 8px 20px;  border: 2px solid 20F0EA; margin-left:1100px;color: black;" ></b>
<?php  
}
?>
 <a href="pf.php" style="color: black;text-align: center;padding: 12px;text-decoration: none;font-size: 18px; ">Message</a>
	 </form>
	
        <div class="col-md-7 user-details">
            <div class="row coralbg white">
                <div class="col-md-6 no-pad">
                    <div class="user-pad">
					<form action="user-info.php" method="post">
					<div class="user-image">
					<?php while ($row = $z->fetch()): ?>
                        <img  width="auto" height="inherit" style=" width: 100%; max-width: 370px;"src="Pictures/<?php echo htmlspecialchars($row['profilepic']); ?>" >
						 <?php endwhile; ?>
        
                    </div>
					<?php while ($row = $x->fetch()): ?>
                        <h3><?php echo $pfname ;?>'s account</h3>
						  <h4 class="white"><i class="fa fa-check-circle-o"></i> <?php echo htmlspecialchars($row['country']); ?></h4>
                        <h4 class="white"><i class="fa fa-twitter"></i> <?php echo htmlspecialchars($row['city']); ?></h4>
                        <h4 class="white"><i class="fa fa-twitter"></i>  <?php echo htmlspecialchars($row['email']); ?></h4>
                        <h4 class="white"><i class="fa fa-twitter"></i>  <?php echo htmlspecialchars($row['phone']); ?></h4>
	           <div><h4 class="white"><i class="fa fa-twitter"></i> Bio:</br> <?php echo htmlspecialchars($row['bio']); ?></h4></div>
					<?php endwhile; ?>
					
                    
					
                    </div>
                </div>
                
						</form>
						
                
            </div>
        </div>
        
     
    </div>
</div>
 <div id="container" style="padding-left:20px;margin-top:40px">
            <h1>Posts(<?php echo $nume;?>)</h1>
         
<div id="columns">
     <?php while ($row = $q->fetch()): ?>
    <figure>
	 <?php echo htmlspecialchars($row['user_name']); ?></b>
	 <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="auto" height="inherit">
    <figcaption> <?php echo htmlspecialchars($row['body']); ?></figcaption>
	<input type="submit" class="button button2" value="L">
	</figure>	
	<?php endwhile; ?>
  <small>Art &copy; <a href="//clairehummel.com">Claire Hummel</a></small>
	</div>
                  
</div>
<?php



