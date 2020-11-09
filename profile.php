<?php
	
	session_start();
    $message = "";  
	 
    // PDO connection_________________________________________________________________________________________________________________________________
	
      $connect = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
	  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $username=$_SESSION["username"];
	 
	 // Button click Post code_____________________________________________________________________________________________________________________________
	 
	 if(isset($_POST['ok'])){
		 
		 //image code_______________
		 
		$folder ="Pictures/"; 
         $image = $_FILES['image']['name']; 
         $path = $folder . $image ; 
         $target_file=$folder.basename($_FILES["image"]["name"]);
         $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
         $allowed=array('jpeg','png' ,'jpg'); $filename=$_FILES['image']['name']; 
         $ext=pathinfo($filename, PATHINFO_EXTENSION); if(!in_array($ext,$allowed) ) 
	               { 
                       echo "Sorry, only JPG, JPEG, PNG & GIF  files are allowed.";
                   }
                else
				{ 
				//caption code_______________
		 move_uploaded_file( $_FILES['image'] ['tmp_name'], $path); 
		$sql = "UPDATE users SET profilepic =? WHERE username=?";
$stmt= $connect->prepare($sql);
$stmt->execute([$image,$username]);
header('Location: pf.php');
				}

} 


?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
<?php include 'log.css'; ?>
</style>
</head>
<!-- Header code -->
<div class="header">
     <h1><a href="pf.php" class="logo"><b><?php echo $_SESSION["username"];?>'s Profile</b></a></h1>
	        
</div>
</br>
</br>
<!-- Image Preview container -->
<div class="container">
<form method="POST" enctype="multipart/form-data" action="Profile.php?username=<?php echo $username; ?>"> 
<!-- Textbox, Buttons &  file uploader -->
</br>
</br>
<div style="padding-left:200px">
        <input type="file" id="image" name="image" class="button button2"  accept="image/*" onchange={handleChange()} /> 
        <input type="submit" name="ok" class="button button2" /> </div>
  <div class="preview-box"></div>


</form>
</div>
<script>
const handleChange = () => {
  const fileUploader = document.querySelector('#image');
  const getFile = fileUploader.files
  if (getFile.length !== 0) {
    const uploadedFile = getFile[0];
    readFile(uploadedFile);
  }
}

const readFile = (uploadedFile) => {
  if (uploadedFile) {
    const reader = new FileReader();
    reader.onload = () => {
      const parent = document.querySelector('.preview-box');
      parent.innerHTML = `<img class="preview-content" src=${reader.result} />`;
    };
    
    reader.readAsDataURL(uploadedFile);
  }
};
</script>
