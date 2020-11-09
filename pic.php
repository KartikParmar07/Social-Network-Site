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
		 
		$folder ="uploads/"; 
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
		 $postbody=$_POST['postbody'];
		 move_uploaded_file( $_FILES['image'] ['tmp_name'], $path); 
		 $query = "INSERT INTO posts (body,posted_at,user_name,image) VALUES ('$postbody',NOW(),'$username','$image')";
		 $connect->exec($query);
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
     <h1><a href="index.php" class="logo"><b>Project</a></h1>
	        
</div>
</br>
</br>
<!-- Textbox, Buttons &  file uploader -->
<div style="padding-left:400px">
<form method="POST" enctype="multipart/form-data" action="pf.php?username=<?php echo $username; ?>"> 
        <textarea name="postbody" rows="5" cols="80"></textarea></br></br>
        <input type="file" id="image" name="image" class="button button2"  accept="image/*" onchange={handleChange()} /> 
        <input type="submit" name="ok" class="button button2" /> 
</form>
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
</div>
<!-- Image Preview container -->
<div class="container">


  <div class="preview-box"></div>
</div>

