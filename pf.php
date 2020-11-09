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
	 //Profile card code________________________________________________________________________________________________________________________________________
	 
	 $query = "SELECT * FROM users WHERE username = :user_name";  
                $z = $connect->prepare($query);
                $z->execute( array('user_name' => $_SESSION["username"]));  
	
	$z->setFetchMode(PDO::FETCH_ASSOC);
	
	
	 //Interaction notification_______________________________________________________________________
	
	$query = "SELECT * FROM notifications WHERE reciever = :user_name ORDER BY id DESC";  
                $n = $connect->prepare($query);
                $n->execute( array('user_name' => $_SESSION["username"]));  
	
	$n->setFetchMode(PDO::FETCH_ASSOC);
	
	 //Post retrieval code________________________________________________________________________________________________________________________________________
	 
	 $query = "SELECT * FROM posts WHERE user_name = :user_name ORDER BY id DESC";  
                $q = $connect->prepare($query);
                $q->execute( array('user_name' => $_SESSION["username"]));  
	
	$q->setFetchMode(PDO::FETCH_ASSOC);
	   
	    //Profile Card info retrieval code________________________________________________________________________________________________________________________________________
$e='';
	 try{
	 $query = "SELECT * FROM users_info WHERE username = :user_name ORDER BY id DESC";  
                $x = $connect->prepare($query);
                $x->execute( array('user_name' => $_SESSION["username"]));  
	
	$x->setFetchMode(PDO::FETCH_ASSOC);
	 }
	 catch (Exception $e) {
    // Nothing, this is normal
}
$sql = "SELECT count(*) FROM `POSTS` WHERE user_name = :username"; 
$result = $connect->prepare($sql);
$result->execute(array('username' => $_SESSION["username"])); 
$nume = $result->fetchColumn(); 


$fq = "SELECT count(*) FROM `followers` WHERE follower = :username"; 
$result = $connect->prepare($fq);
$result->execute(array('username' => $_SESSION["username"])); 
$following_count = $result->fetchColumn(); 


$fqc = "SELECT count(*) FROM `followers` WHERE following = :username"; 
$result = $connect->prepare($fqc);
$result->execute(array('username' => $_SESSION["username"])); 
$followers_count = $result->fetchColumn(); 


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
</head>
<script>
$(document).ready(function() {
    var $btnSets = $('#responsive'),
    $btnLinks = $btnSets.find('a');
 
    $btnLinks.click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.user-menu>div.user-menu-content").removeClass("active");
        $("div.user-menu>div.user-menu-content").eq(index).addClass("active");
    });
});

$( document ).ready(function() {
    $("[rel='tooltip']").tooltip();    
 
    $('.view').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    ); 
});

$( "#search" ).click(function(e) {
		e.preventDefault();
		$(".search_box").toggleClass('active');
	});
</script>
<!-- Header code -->
<div class="header">
<h1><a href="index.php" class="logo" style="font-family:Segoe Script;text-decoration:none;"><b>Project</b></a></h1>	
<div><nav>
<form name="frmSearch" method="post" action="pf.php">
   
      <input name="var1" type="text" id="var1">
      <input type="submit" value="Search" name="search">
     
</div>
<div class="header-right">
   <a href="logout.php">Logout</a>
  </div>
</form>
</nav></div> 
</div>

<div style="padding-bottom:20px; margin-bottom:2px;">
</br>
<a href="pic.php"style="font-family:Segoe Script; font-size:25px; text-decoration:none; color:20F0EA; padding-left:90px;">Create a new Post, Share your content with the world...Click here.</a>
<hr style="border:solid 1px gray">

</div>

<!-- Profile card -------------------------------------------------------------------------------------------------------------->
<div class="container">
    <div class="row user-menu-container square">
        <div class="col-md-7 user-details">
            <div class="row coralbg white">
                <div class="col-md-6 no-pad">
                    <div class="user-pad">
                        <h3>Welcome back,<?php echo $_SESSION["username"];?></h3>
						<?php while ($row = $x->fetch()): ?>
                        <h4 class="white"><i class="fa fa-check-circle-o"></i> <?php echo htmlspecialchars($row['country']); ?></h4>
                        <h4 class="white"><i class="fa fa-twitter"></i> <?php echo htmlspecialchars($row['city']); ?></h4>
                        <h4 class="white"><i class="fa fa-twitter"></i>  <?php echo htmlspecialchars($row['email']); ?></h4>
                        <h4 class="white"><i class="fa fa-twitter"></i>  <?php echo htmlspecialchars($row['phone']); ?></h4>
								
								 <a type="button" class="btn btn-labeled btn-info" href="user-info.php">
								 <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</a>
                    </div>
					<div><h4 class="white"><i class="fa fa-twitter"></i> Bio:</br> <?php echo htmlspecialchars($row['bio']); ?></h4></div>
					<?php endwhile; ?>
                </div>
                <div class="col-md-6 no-pad">
                    <div class="user-image">
					<?php while ($row = $z->fetch()): ?>
                        <a href='profile.php'><img  width="auto" height="inherit" style=" width: 100%; max-width: 370px  " src="Pictures/<?php echo htmlspecialchars($row['profilepic']); ?>" ></a>
						 <?php endwhile; ?>
        
                    </div>
                </div>
            </div>
            <div class="row overview">
                <div class="col-md-4 user-pad text-center">
                    <h3><a href="followers.php">FOLLOWERS</a></h3>
                    <h4><?php echo $followers_count ?></h4>
                </div>
                <div class="col-md-4 user-pad text-center">
                    <h3><a href="following.php">FOLLOWING</a></h3>
                    <h4><?php echo $following_count ?></h4>
                </div>
                <div class="col-md-4 user-pad text-center">
                    <h3>Posts</h3>
                    <h4><?php echo $nume;?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-1 user-menu-btns">
            <div class="btn-group-vertical square" id="responsive">
                <a href="#" class="btn btn-block btn-default active">
                  <i class="fa fa-bell-o fa-3x"></i>
                </a>
                <a href="#" class="btn btn-default">
                  <i class="fa fa-envelope-o fa-3x"></i>
                </a>
                <a href="#" class="btn btn-default">
                  <i class="fa fa-laptop fa-3x"></i>
                </a>
                <a href="#" class="btn btn-default">
                  <i class="fa fa-cloud-upload fa-3x"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 user-menu user-pad">
            <div class="user-menu-content active">
                <h3>
                    Recent Interactions
                </h3>
                <ul class="user-menu-list">
				<?php while($row = $n->fetch()):  ?>
                    <li>
                        <h4><i class="fa fa-user coral"></i> <?php  echo "<a>"; echo $row['sender']; echo "</a>";  
						echo "&nbsp;"; echo $row['msg'];	echo "</br>"; echo $row['at']; echo"<hr>"; ?></h4>
                    </li>
                    <?php endwhile;  ?>
                </ul>
            </div>
            <div class="user-menu-content">
                <h3>
                    Your Inbox
                </h3>
                <ul class="user-menu-list">
                    <li>
                        <h4>From Roselyn Smith <small class="coral"><strong>NEW</strong> <i class="fa fa-clock-o"></i> 7:42 A.M.</small></h4>
                    </li>
                    <li>
                        <h4>From Jonathan Hawkins <small class="coral"><i class="fa fa-clock-o"></i> 10:42 A.M.</small></h4>
                    </li>
                    <li>
                        <h4>From Georgia Jennings <small class="coral"><i class="fa fa-clock-o"></i> 10:42 A.M.</small></h4>
                    </li>
                    <li>
                        <button type="button" class="btn btn-labeled btn-danger" href="#">
                            <span class="btn-label"><i class="fa fa-envelope-o"></i></span>View All Messages</button>
                    </li>
                </ul>
            </div>
            <div class="user-menu-content">
                <h3>
                    Trending
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="view">
                            <div class="caption">
                                <p>47LabsDesign</p>
                                <a href="" rel="tooltip" title="Appreciate"><span class="fa fa-heart-o fa-2x"></span></a>
                                <a href="" rel="tooltip" title="View"><span class="fa fa-search fa-2x"></span></a>
                            </div>
                            <img src="http://24.media.tumblr.com/273167b30c7af4437dcf14ed894b0768/tumblr_n5waxesawa1st5lhmo1_1280.jpg" class="img-responsive">
                        </div>
                        <div class="info">
                            <p class="small" style="text-overflow: ellipsis">An Awesome Title</p>
                            <p class="small coral text-right"><i class="fa fa-clock-o"></i> Posted Today | 10:42 A.M.</small>
                        </div>
                        <div class="stats turqbg">
                            <span class="fa fa-heart-o"> <strong>47</strong></span>
                            <span class="fa fa-eye pull-right"> <strong>137</strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="view">
                            <div class="caption">
                                <p>47LabsDesign</p>
                                <a href="" rel="tooltip" title="Appreciate"><span class="fa fa-heart-o fa-2x"></span></a>
                                <a href="" rel="tooltip" title="View"><span class="fa fa-search fa-2x"></span></a>
                            </div>
                            <img src="http://24.media.tumblr.com/282fadab7d782edce9debf3872c00ef1/tumblr_n3tswomqPS1st5lhmo1_1280.jpg" class="img-responsive">
                        </div>
                        <div class="info">
                            <p class="small" style="text-overflow: ellipsis">An Awesome Title</p>
                            <p class="small coral text-right"><i class="fa fa-clock-o"></i> Posted Today | 10:42 A.M.</small>
                        </div>
                        <div class="stats turqbg">
                            <span class="fa fa-heart-o"> <strong>47</strong></span>
                            <span class="fa fa-eye pull-right"> <strong>137</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-menu-content">
                <h2 class="text-center">
                 About
                </h2>
                <center><i class="fa fa-cloud-upload fa-4x"></i></center>
                <div class="share-links">
                    <center><button type="button" class="btn btn-lg btn-labeled btn-success" href="#" style="margin-bottom: 15px;">
                            <span class="btn-label"><i class="fa fa-bell-o"></i></span>A FINISHED PROJECT
                    </button></center>
                    <center><button type="button" class="btn btn-lg btn-labeled btn-warning" href="#">
                            <span class="btn-label"><i class="fa fa-bell-o"></i></span>A WORK IN PROGRESS
                    </button></center>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
<hr style="border:solid 1px">
<h1 style="padding-left:500px; font-family:Segoe Script; font-size:50px">My Posts</h1>
			<hr style="border:solid 1px">
 <div id="container" style="padding-left:20px;margin-top:40px">
                 
<div id="columns">

     <?php while ($row = $q->fetch()): ?>
    <figure>
	 <a href="fprofile.php" style="text-decoration:none">
	<b> <?php echo htmlspecialchars($row['user_name']); $_SESSION['fa'] = $row['user_name'];?></b>
	 </a>
	 <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="auto" height="inherit">
    <figcaption style="font-size:13px"> <?php echo htmlspecialchars($row['body']); ?></br>
	Posted at: <?php echo htmlspecialchars($row['posted_at']); ?></figcaption>
	<input type="submit" class="button button4" value="Like(<?php 
// Likes retrieval code_______________________________________________________________________________________
	$lk = "SELECT count(*) FROM `likes` WHERE pid = :pid"; 
$result = $connect->prepare($lk);
$result->execute(array('pid' => $row['image'])); 
$lkc = $result->fetchColumn(); 
echo $lkc;
	?>)">
	<input type="textC" name="comment" placeholder="Comment....."><input type="submit" class="button button4" value="Post" style="">
	</figure>	
	<?php endwhile; ?>
   <small>SOCIAL-NETWORK; <a">K$P</a></small>
	</div>
                  
</div>