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
	
	
	
 

 if(isset($_POST['search']))
           {  
            $_SESSION['var1'] = $var1;
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
