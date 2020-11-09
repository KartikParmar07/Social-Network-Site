<?php
include('classes/DB.php');
if (isset($_POST['createaccount'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
		
        $pdo = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		

		if ( empty($username) || empty($email) || empty($password) )
    {
    echo "Complete all fields</br><hr>";
    }
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
    echo $emailvalid = "Enter a  valid email</br><hr>";
    }
	if (strlen($password) <= 6){
    echo $passlength = "Choose a password longer then 6 character</br> <hr>";
}

     $query = "SELECT * FROM users WHERE username = :username" ; 
			  
			  $statement = $pdo->prepare($query);
			   $pdoExec = $statement->execute(array(":username"=>$username));
			  
    if($pdoExec)
    {   
        if($statement->rowCount()>0)
        {
           echo $validus = "username already exists, select another username</br><hr>";
        }
    }		
 $query = "SELECT * FROM users WHERE email = :email" ; 
			  
			  $statement = $pdo->prepare($query);
			   $pdoExe = $statement->execute(array(":email"=>$email));
			  
    if($pdoExe)
    {   
        if($statement->rowCount()>0)
        {
           echo $validem = "Email-id already registered";
        }
    }				
  if(empty($passmatch) && empty($emailvalid) && empty($passlength) && empty($validus) && empty($validem)) {
		
        $sql = "INSERT INTO users (username, password,email) VALUES ('$username','$password','$email')";
 
$pdo->exec($sql);

 $query = "INSERT INTO users_info (username) VALUES ('$username')";
 
$pdo->exec($query);
echo "Success!";
 header('Location: login.php');
		
}
}
if(isset($_POST["Login"])) 
      { 
      header('Location: login.php');
      }
?>
<head><style>
<?php include 'create-account.css'; ?>
</style>
</head>
<div class="container">
<h1 style="padding-left:80px; font-size:45px; font-family:Segoe Script;">Register</h1>
<hr style="width:90%">
<form action="create-account.php" method="post">
<input type="text" name="username" value="" placeholder="Username ..."><p />
<input type="password" name="password" value="" placeholder="Password ..."><p />
<input type="email" name="email" value="" placeholder="someone@somesite.com"><p />
</br>
<p>By clicking Register, you agree to our <a href="">Terms</a> and that you have read our <a href="">Data use policy</a>, including our T&C. </p>
<input type="submit" name="createaccount" value="Register" class="button button1">
</br>
</br>
</br>
<hr style="width:90%">
<p>If you already have an account, then <input type="submit" name="Login" value="Login" class="button button1"> </p>
</form>
</div>

