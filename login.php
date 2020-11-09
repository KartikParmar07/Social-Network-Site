    <?php
	
session_start();
$message = "";  

try  
 {  
//PDO code____________________________________________________________________________________________________________________________
 
      $connect = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
		      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
     
//Button click login code_______________________________________________________________________________________________
		
		if(isset($_POST["login"])) 
        {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<label>All fields are required</label>';  
           }  
           else  
           {  
                $query = "SELECT * FROM users WHERE username = :username AND password = :password";  
                $statement = $connect->prepare($query);
                $statement->execute( array('username' => $_POST["username"],'password' => $_POST["password"]  ));  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
			$_SESSION["username"]= $_POST["username"];
			echo  $_SESSION["username"];
			header('Location: index.php');
                }
                else  
                {  
                     $message = '<label>Invalid username or password</label>';
                }  
           }  
      }  
 }  
 //If error occurs_________________________________________
 
 catch(PDOException $error)  
 {  
    $message = $error->getMessage();  
 }  
 //Register button code_______________________________________________________________________________________________
 
 if(isset($_POST["Sign-up"])) 
      { 
      header('Location: create-account.php');
      }
 
?>


<head>
<style>
<?php include 'login.css'; ?>
<style><?php include 'div.css'; ?></style>
</style>
<head>
<form action="login.php" method="post">
<div>
<h1 style="padding-left:30px; font-size:35px; font-family:Segoe Script;">Login to your account</h1>
<hr style="width:90%">
<input type="text" name="username" value="" placeholder="Username ..."></br>
<input type="password" name="password" value="" placeholder="Password ..."></br>
<input type="submit" name="login" value="login" class="button button2">
</br>
<hr style="width:90%">
<p>If you are not registered yet then</p>
<input type="submit" name ="Sign-up" value="Sign-up" class="button button2"> 
</br>
</br>
                <?php  
                if(isset($message))  
                {  
                     echo '<label class="text-danger">'.$message.'</label>';  
                }  
                ?>  
</form>
</div>
